<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserSubscription::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'payment_status' => 'required',
            'delivery_schedule' => 'required',
        ]);
        $userSubscription = new UserSubscription();
        $userSubscription->user_id = auth()->user()->id;
        $userSubscription->subscription_id = $request->subscription_id;
        $userSubscription->status = 'active';
        $userSubscription->start_date = $request->start_date;
        $userSubscription->end_date = $request->end_date;
        $userSubscription->payment_status = $request->payment_status;
        $userSubscription->delivery_schedule = $request->delivery_schedule;
        if($userSubscription->save())
            return response(['message'=>'Save subscription success'],201);
        return response(['message' => 'Failed to save subscription'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userSubscription = UserSubscription::find($id);
        if ($userSubscription)
            return response($userSubscription, 200);
        return response('User not have subscription', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userSubscription = UserSubscription::find($id);
        if ($userSubscription) {
            //Update user subscription
            return response($userSubscription, 200);
        }
        return response('User not have subscription', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (UserSubscription::destroy($id)) {
            return response(["message" => "Success delete user subscription!"], 200);
        } else {
            return response(["message" => "Failed to delete user subscription"], 200);
        }
    }
}
