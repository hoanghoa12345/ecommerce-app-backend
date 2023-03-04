<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * Handle register user
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $response = [
            'user' => $user,
        ];

        return Response($response, 201);
    }

    /**
     * Handle login with email and password
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return [
                'message' => 'The email you entered is not connected to any account.'
            ];
        } elseif (!Hash::check($fields['password'], $user->password)) {
            return [
                'message' => 'The password you entered is incorrect.'
            ];
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return Response($response, 201);
    }

    /**
     * Handle logout user
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
            'status' => 1,
            'error_code' => 0
        ];
    }

    /**
     * Handle forgot password and send link reset password to email
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response(['message' => 'Email confirmation successful!'], 200)
            : response(['message' => 'An error occurred while sending the email!'], 500);
    }

    /**
     * Handle reset password with token sent by email
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? \response(['message' => 'Password recovery successful!', 'status' => 1, 'error_code' => 0], 200)
            : \response(['message' => 'An error occurred while recovering the password', 'status' => 0, 'error_code' => 1], 500);
    }
}
