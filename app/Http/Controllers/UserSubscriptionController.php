<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeMail;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserSubscription::with(['user'])->latest()->get();
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

        if ($userSubscription->save()) {
            $user = User::find($userSubscription->user_id);
            $profile = Profile::find($userSubscription->user_id);
            $subscription = Subscription::find($userSubscription->subscription_id);

            Mail::to($user)->send(new SubscribeMail($user, $profile, $userSubscription, $subscription));
            return response(['message' => 'Save subscription success','sub_id' => $userSubscription->id], 201);
        }

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

    public function getUserSubsByUserId($id)
    {
        return UserSubscription::where('user_id', $id)->with('subscription')->latest()->get();
    }

    public function updatePaymentStatus(Request $request) {
        $request->validate([
           'sub_id' => 'required',
           'sub_pay_status' => 'required'
        ]);
        $subId = $request->input('sub_id');
        $subItem = UserSubscription::find($subId);
        $subItem->payment_status = $request->input('sub_pay_status');
        $saveSub = $subItem->save();
        if($saveSub) return response(['message' => 'Update subscription payment success!']);
        return response(['message' => 'Update subscription payment failed']);
    }

    public function  zalopayBankList()
    {
        /**
         * Get all banks list
         */
        $config = [
            "appid" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
            "endpoint" => "https://sbgateway.zalopay.vn/api/getlistmerchantbanks"
        ];

        $reqtime = round(microtime(true) * 1000); // miliseconds
        $params = [
            "appid" => $config["appid"],
            "reqtime" => $reqtime,
            "mac" => hash_hmac("sha256", $config["appid"] . "|" . $reqtime, $config["key1"]) // appid|reqtime
        ];

        $resp = file_get_contents($config["endpoint"] . "?" . http_build_query($params));
        $result = json_decode($resp, true);

        return $result;
    }

    public function zalopayPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $config = [
            "app_id" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
        ];
        if($request->input('bank_code')) {
            $embeddata = '{"redirecturl": "http://localhost:3000/payment-result"}';
        }else {
            $embeddata = '{"redirecturl": "http://localhost:3000/payment-result", "bankgroup": "ATM"}'; // Merchant's data
        }

        $items = '[]'; // Merchant's data
        $transID = rand(0, 1000000); //Random trans id
        $app_trans_id = date("ymd") . "_" . $transID;
        $order = [
            "app_id" => $config["app_id"],
            "app_time" => round(microtime(true) * 1000), // miliseconds
            "app_trans_id" => $app_trans_id,
            "app_user" => "user123",
            "item" => $items,
            "embed_data" => $embeddata,
            "amount" => $request->input('amount'),
            "description" => "Lazada - Payment for the order #$transID",
            "bank_code" => $request->input('bank_code'),
        ];

        // appid|app_trans_id|appuser|amount|apptime|embeddata|item
        $data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
            . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
        $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);

        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order)
            ]
        ]);

        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);

        return $result;

    }

    public function zalopayStatusPayment(Request $request)
    {
        $config = [
            "app_id" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/query"
        ];

        $app_trans_id = $request->query('app_trans_id');  // Input your app_trans_id
        if(!$app_trans_id) return response([
            'message' => 'app_trans_id query params is required'
        ],422);
        $data = $config["app_id"] . "|" . $app_trans_id . "|" . $config["key1"]; // app_id|app_trans_id|key1
        $params = [
            "app_id" => $config["app_id"],
            "app_trans_id" => $app_trans_id,
            "mac" => hash_hmac("sha256", $data, $config["key1"])
        ];

        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($params)
            ]
        ]);

        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);

        return $result;
    }
}
