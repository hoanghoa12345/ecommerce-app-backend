<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionDetail;
use http\Env\Response;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index() {
        return Subscription::with('details')->latest()->get();
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
        return Subscription::with('details')->findOrFail($subscription->id);
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
        return Subscription::destroy($subscription->id);
    }
}
