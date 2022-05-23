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

    public function bulkInsert(Request $request) {
        $listProduct = $request->all();
        $totalPrice = 0;
        foreach ($listProduct as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
            SubscriptionDetail::create($item);
        }
        $subscription = Subscription::find($listProduct[0]['subscription_id']);
        $subscription->total_price = $totalPrice;
        $subscription->save();
        return response('1',201);
    }

    public function update(Request $request, SubscriptionDetail $subscriptionDetail) {
        $subscriptionDetail = Subscription::find($subscriptionDetail);
        $subscriptionDetail->update($request->all());
        return $subscriptionDetail;
    }

    public function destroy($id)
    {
        return SubscriptionDetail::destroy($id);
    }
}
