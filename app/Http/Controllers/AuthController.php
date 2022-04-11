<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request){
        $fields = $request->validate([
            'name'=>'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

//        $isUser = User::where('email', $fields['email'])->first();
//        if (!$isUser){
//            return [
//                'message' => 'Email already exists.'
//            ];
//        }

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $response = [
            'user' => $user,
        ];

        return Response($response,201);
    }

    public function Login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $fields['email'])->first();

        if (!$user){
            return [
                'message' => 'The email you entered is not connected to any account.'
            ];
        }
        elseif (!Hash::check($fields['password'], $user->password)){
            return [
                'message' => 'The password you entered is incorrect.'
            ];
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return Response($response,201);
    }

    public function Logout(){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
