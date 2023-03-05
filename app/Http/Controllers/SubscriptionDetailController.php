<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionDetailController extends Controller
{
    /**
     * Store user subscription to database
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);
        return SubscriptionDetail::create($request->all());
    }

    /**
     * Insert all item to User Subscription
     */
    public function bulkInsert(Request $request)
    {
        Log::info('================ Insert list detail subscription ===================');
        $listProduct = $request->all();
        //Handle delete old items when update
        DB::table('subscription_details')->where('subscription_id', $listProduct[0]['subscription_id'])->delete();
        Log::info('[INFO] Hanle remove old product');
        $totalPrice = 0;
        foreach ($listProduct as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
            SubscriptionDetail::create($item);
        }
        Log::info('[INFO] Handle update price');
        $subscription = Subscription::find($listProduct[0]['subscription_id']);
        $subscription->total_price = $totalPrice;
        $subscription->save();
        return response([
            "data" => null,
            "error_code" => 0,
            "message" => "Successful",
            "status" => 1
        ], 201);
    }

    /**
     * Update User Subscription by ID
     */
    public function update(Request $request, SubscriptionDetail $subscriptionDetail)
    {
        $subscriptionDetail = Subscription::find($subscriptionDetail);
        $subscriptionDetail->update($request->all());
        return $subscriptionDetail;
    }

    /**
     * Remove user subscription by ID
     */
    public function destroy($id): int
    {
        return SubscriptionDetail::destroy($id);
    }

    /**
     * Update list products of subscription by ID
     */
    public function updateList(Request $request, $subscriptionId)
    {
        Log::info('Update list user subscription by subscription Id');
        Log::info('Subscription Id: ', $subscriptionId);
        Log::info('Request: ', [$request]);

        if (!isset($subscriptionId)) {
            return response([
                'message' => 'Subscription Id params not exist',
                'error_code' => 1,
                'status' => 1,
            ], 200);
        }

        SubscriptionDetail::where('subscription_id', $subscriptionId)->delete();

        $listProduct = $request->listProduct;

        $totalPrice = 0;
        foreach ($listProduct as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
            SubscriptionDetail::create($item);
        }

        $subscription = Subscription::find($subscriptionId);
        $subscription->total_price = $totalPrice;
        $subscription->save();

        return response([
            'message' => 'Updated list',
            'error_code' => 0,
            'status' => 1
        ], 200);
    }
}
