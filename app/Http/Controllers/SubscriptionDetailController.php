<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionDetail;
use Illuminate\Http\Request;

class SubscriptionDetailController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'subscription_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);
        return SubscriptionDetail::create($request->all());
    }

    public function update(Request $request, SubscriptionDetail $subscriptionDetail) {
        $subscriptionDetail = Subscription::find($subscriptionDetail);
        $subscriptionDetail->update($request->all());
        return $subscriptionDetail;
    }

    public function destroy(SubscriptionDetail  $subscriptionDetail) {
        return SubscriptionDetail::destroy($subscriptionDetail);
    }
}
