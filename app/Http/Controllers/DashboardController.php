<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Load collection info in dashboard
     */
    public function index()
    {
        //Get total clients
        $total_client = User::all()->count();
        //Get Account balance

        //Get new Sales by month

        //Get pending contact

        //Get clients
        $users = User::all()->map(function ($user) {
            $user_profile = Profile::where('user_id', $user->id)->first();
            $user->avatar = $user_profile->avatar;
            $user->amount = 0;
            $user->status = 'Active';
            $user->date = $user->created_at->format('d/m/Y');
            return $user;
        });

        //Get account balance
        $account_balance = Order::whereMonth('created_at', Carbon::now()->month)->sum('total_price');


        //Get orders
        $new_sales = Order::whereMonth('created_at', Carbon::now()->month)->count();

        return response([
            'total_client' => $total_client,
            'account_balance' => $account_balance,
            'new_sales' => $new_sales,
            'pending_contacts' => 0, // It's hard code number and will be change
            'clients' => $users
        ]);
    }

    /**
     * Get list banner image in home page
     * It will be change with database storage image
     */

    public function getSliderBanner()
    {
        $banners = collect([
            "https://www.bigc.vn/files/banners/2022/mar/blog-website-c-1.jpg",
            "https://www.bigc.vn/files/banners/2021/oct-21/unilever-big-c-cover-blog.jpg",
            "https://www.bigc.vn/files/banners/2022/mar/blog-c-100.jpg",
            "https://www.bigc.vn/files/banners/2022/feb/1080-x-540-cover-1.png",
        ]);
        return response($banners, 200);
    }

    /**
     * Get categories in home page it will be change to database storage
     */
    public function getCategoryHome()
    {
        //$path = config('app.url');
        $categories = collect([
            [
                'image' => 'https://cdn.tgdd.vn/bachhoaxanh/banners/3174/banner-landingpage-3174-2903202292754.jpg',
                'name' => 'Bột giặt'
            ],
            [
                'image' => 'https://cdn.tgdd.vn/bachhoaxanh/banners/3095/banner-landingpage-3095-1003202210747.jpg',
                'name' => 'Dầu gội',
            ],
            [
                'image' => 'https://cdn.tgdd.vn/bachhoaxanh/banners/3032/banner-landingpage-3032-23032022205023.jpg',
                'name' => 'Nước lau sàn'
            ]
        ]);
        return response($categories, 200);
    }
}
