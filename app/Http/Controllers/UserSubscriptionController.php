<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeMail;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use App\Services\ZaloPayService;
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

        $userId = auth()->user()->id;
        $subscriptionId = $request->subscription_id;
        $status = 'active';
        $paymentStatus = 'Chưa thanh toán';

        // Find all user subscription by id is not payment
        UserSubscription::where('subscription_id', $subscriptionId)->where('user_id', $userId)->where('payment_status', $paymentStatus)->delete();

        // Handle create new subscription
        $userSubscription = new UserSubscription();
        $userSubscription->user_id = $userId;
        $userSubscription->subscription_id = $subscriptionId;
        $userSubscription->status = $status;
        $userSubscription->start_date = $request->start_date;
        $userSubscription->end_date = $request->end_date;
        $userSubscription->payment_status = $request->payment_status;
        $userSubscription->delivery_schedule = $request->delivery_schedule;

        if ($userSubscription->save()) {
            $user = User::find($userSubscription->user_id);
            $profile = Profile::find($userSubscription->user_id);
            $subscription = Subscription::find($userSubscription->subscription_id);

            Mail::to($user)->send(new SubscribeMail($user, $profile, $userSubscription, $subscription));
            return response(['message' => 'Save subscription success', 'sub_id' => $userSubscription->id], 201);
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

    /**
     * Get subscription created by user
     */
    public function getUserSubsByUserId($id)
    {
        return UserSubscription::where('user_id', $id)->with('subscription')->latest()->get();
    }

    /**
     * Update payment status for user subscription paid
     */
    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'sub_id' => 'required',
            'sub_pay_status' => 'required'
        ]);
        $subId = $request->input('sub_id');
        $subItem = UserSubscription::find($subId);
        $subItem->payment_status = $request->input('sub_pay_status');
        $saveSub = $subItem->save();
        if ($saveSub) return response(['message' => 'Update subscription payment success!']);
        return response(['message' => 'Update subscription payment failed']);
    }

    /**
     * Get Zalo Pay bank list
     */
    public function zalopayBankList(ZaloPayService $service)
    {
        return $service->getBankList();
    }

    /**
     * Create payment request using ZaloPay Service
     */
    public function zalopayPayment(Request $request, ZaloPayService $service)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $amount = $request->input('amount');
        $bankCode = $request->input('bank_code');
        $redirectUrl = 'http://localhost:3000/payment-result'; //This will be redirect to frontend if payment done
        $description = 'Eclean - Thanh toan cho don hang '; // Title of order payment
        $orderCode = ''; // Order code of subscription will be update late

        return $service->createPayment($amount, $bankCode, $redirectUrl, $description, $orderCode);
    }

    /**
     * Update status of order created by ZaloPay
     */
    public function zalopayStatusPayment(Request $request, ZaloPayService $service)
    {
        $app_trans_id = $request->query('app_trans_id');  // Input your app_trans_id

        if (!$app_trans_id) return response([
            'message' => 'app_trans_id query params is required'
        ], 422);

        return $service->getStatusPayment($app_trans_id);
    }
}
