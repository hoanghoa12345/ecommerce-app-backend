<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function save(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'total_price' => $request->input('total_price'),
            'total_qty' => $request->input('total_qty'),
            'order_number' => Str::uuid(),
            'status' => $request->input('status'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
        ]);

        $order_detail = $request->input('order_detail');
        foreach ($order_detail as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response([
            'status' => 201,
            'message' => 'Create order successful!'
        ], 201);
    }

    public function list()
    {
        return Order::with(['details' => function ($query) {
            $query->with(['product']);
        }, 'user'])->latest()->get();
    }

    public function destroy($id)
    {
        $order_details = OrderDetail::select()
            ->where('order_id', $id)->get();
        if(count($order_details) > 0){
            //Get only id
            $order_details_id = $order_details->pluck('id');
            $delete_detail = OrderDetail::destroy($order_details_id);
            logger($delete_detail);
        }
        $delete_order = Order::destroy($id);
        logger($delete_order);
        if ($delete_order) {
            return response(['message' => 'Delete order successful!'], 200);
        } else {
            return response(['message' => 'Has error when delete order'], 500);
        }
    }
}
