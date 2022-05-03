<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();
        return $profiles;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $profile = Profile::where('user_id',$user_id)->first();
        return $profile;
    }
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

        return Response($profile,201);
    }
    /**
     * Update the specified resource in storage.
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
        if ($request->avatar !== 'undefined'){
            $profile->avatar = $request->avatar->store('upload/avatar');
        }
        return $profile->save();
    }
}
