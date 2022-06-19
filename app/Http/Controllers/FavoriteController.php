<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function index(User $userId)
    {
        return Favorite::with(['product','subscription'])->where('user_id',$userId->id)->get();
    }

    public function save(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');
        $subscription_id = $request->input('subscription_id');

        $favorites = Favorite::where('user_id', $user_id);

        //user id and product id is same
        if($favorites->where('product_id', $product_id)->count() > 0) {
            return response(['message' => 'Product has been added!'],200);
        }

        if($favorites->where('subscription_id', $subscription_id)->count() > 0) {
            return response(['message' => 'Subscription has been added!'],200);
        }

        $favorite = new Favorite();
        $favorite->user_id = $user_id;
        $favorite->product_id = $product_id;
        $favorite->subscription_id = $subscription_id;
        $status = $favorite->save();
        if($status)
        {
            return response(['message' => 'Add to favorites successful!'],200);
        }
        return response(['message' => 'Can not add to favorites'],500);
    }

    public function destroy(int $id) {
        $status = Favorite::destroy($id);
        return $status ? response(['message' => 'Delete favorite success!'],200)
            : response(['message' => 'Can not delete favorite record'],500);
    }
}
