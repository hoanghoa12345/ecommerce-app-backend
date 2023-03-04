<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionDetailController extends Controller
{
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

    public function update(Request $request, SubscriptionDetail $subscriptionDetail)
    {
        $subscriptionDetail = Subscription::find($subscriptionDetail);
        $subscriptionDetail->update($request->all());
        return $subscriptionDetail;
    }

    public function destroy($id): int
    {
        return SubscriptionDetail::destroy($id);
    }

    public function updateList(Request $request, $subscriptionId)
    {
        //$subscriptionDetailsCount = SubscriptionDetail::where('subscription_id',$subscriptionId)->count();
        //$deleted = DB::table('subscription_details')->where('subscription_id', $subscriptionId)->delete();
        //Deleted id always return num of record deleted
    }
}
