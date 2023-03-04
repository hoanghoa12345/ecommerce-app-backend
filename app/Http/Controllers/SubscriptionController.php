<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * Listing all subscriptions
     */
    public function index()
    {

        return Subscription::with(['details' => function ($query) {
            $query->with(['product']);
        }, 'user'])->latest()->get();
    }

    /**
     * Find subscription create by admin
     */
    public function getSubByAdmin()
    {
        //get all user with roles `admin`
        $users = User::all()->where('roles', 'admin')->pluck('id');
        $query = Subscription::has('details', '>=', 1)->whereIn('user_id', $users)->with(['details' => function ($query) {
            $query->with(['product']);
        }])->latest();
        Log::debug($query->toSql());
        return [
            'data' => $query->get(),
            'error_code' => 0,
            'message' => 'Successful',
            'status' => 1
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
            'total_price' => 'required'
        ]);
        $subscription = new Subscription();
        $subscription->name = $request->name;
        $subscription->duration = $request->duration;
        $subscription->total_price = $request->total_price;
        $subscription->user_id = auth()->user()->id;

        if ($subscription->save())
            return response($subscription, 201);
        return response(['message' => 'Failed to save subscription'], 500);
    }

    public function show(Subscription $subscription)
    {
        return Subscription::with(['details' => function ($query) {
            $query->with(['product']);
        }])->findOrFail($subscription->id);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
            'total_price' => 'required'
        ]);

        $subscription = Subscription::find($subscription->id);
        $subscription->name = $request->name;
        $subscription->duration = $request->duration;
        $subscription->total_price = $request->total_price;
        if ($subscription->save())
            return \response([
                'message' => 'Updated Subscription'
            ], 200);
        return \response([
            'message' => 'Subscription can not updated'
        ]);
    }

    public function destroy(Subscription $subscription)
    {
        if (SubscriptionDetail::where('subscription_id', '=', $subscription->id)->count() > 0) {
            DB::table('subscription_details')->where('subscription_id', $subscription->id)->delete();
        }

        return Subscription::destroy($subscription->id);
    }

    public function getSubsByUserId($id)
    {
        return Subscription::where('user_id', $id)->latest()->get();
    }

    public function copySubscription(Request $request)
    {
        $user_id = $request->input('user_id');
        $subscription_name = $request->input('subscription_name');
        $subscription_duration = $request->input('subscription_duration');
        $subscription = Subscription::create([
            'name' => $subscription_name,
            'duration' => $subscription_duration,
            'total_price' => 0,
            'user_id' => $user_id
        ]);

        $subscription_detail = $request->input('subscription_detail');

        $totalPrice = 0;
        foreach ($subscription_detail as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
            SubscriptionDetail::create([
                'subscription_id' => $subscription->id,
                'product_id' => $item['product_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
        }

        $subscription->total_price = $totalPrice;
        $subscription->save();

        return response([
            'status' => 201,
            'subscription_id' => $subscription->id,
            'message' => 'Copy subscription successful'
        ], 201);
    }
}
