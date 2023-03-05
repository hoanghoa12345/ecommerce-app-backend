<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();
        return $profiles;
    }

    /**
     * Display the specified user profile.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $profile = Profile::where('user_id', $user_id)->first();
        return $profile;
    }

    /**
     * Store a newly created user profile in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "description" => "required",
            "address" => "required",
            "phone_number" => "required",
            "avatar" => "required",
        ]);

        $profile = new Profile($request->all());
        $path = $request->avatar->store('upload/avatar');
        $profile->avatar = $path;

        return Response($profile, 201);
    }
    /**
     * Update the specified profile in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $request->validate([
            "description" => "required",
            "address" => "required",
            "phone_number" => "required",
            "avatar" => "required",
        ]);

        $profile = Profile::where('user_id', $user_id)->first();
        $profile->description = $request->description;
        $profile->address = $request->address;
        $profile->phone_number = $request->phone_number;
        if ($request->avatar !== 'undefined') {
            $profile->avatar = $request->avatar->store('upload/avatar');
        }
        return $profile->save();
    }
}
