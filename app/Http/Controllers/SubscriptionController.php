<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index() {

        return Subscription::with(['details' => function($query){
            $query->with(['product']);
        }])->latest()->get();
    }

    public function store(Request $request) {
        $request->validate([
           'name' => 'required',
           'duration' => 'required',
           'total_price' => 'required'
        ]);

        return Subscription::create($request->all());
    }

    public function show(Subscription $subscription) {
        return Subscription::with(['details' => function($query){
            $query->with(['product']);
        }])->findOrFail($subscription->id);
    }

    public function update(Request $request, Subscription $subscription) {
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
            'total_price' => 'required'
        ]);

        $subscription = Subscription::find($subscription->id);
        $subscription->name = $request->name;
        $subscription->duration = $request->duration;
        $subscription->total_price = $request->total_price;
        if($subscription->save())
            return \response([
                'message' => 'Updated Subscription'
            ],200);
        return \response([
            'message' => 'Subscription can not updated']);
    }

    public function destroy(Subscription $subscription) {
        DB::table('subscription_details')->where('subscription_id', $subscription->id)->delete();
        return Subscription::destroy($subscription->id);
    }
}
