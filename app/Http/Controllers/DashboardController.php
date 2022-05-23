<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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

        return response([
            'total_client' => $total_client,
            'account_balance' => 0,
            'new_sales' => 0,
            'pending_contacts' => 0,
            'clients' => $users
        ]);
    }

    public function getSliderBanner() {
        $banners = collect([
            "https://www.bigc.vn/files/banners/2022/mar/blog-website-c-1.jpg",
            "https://www.bigc.vn/files/banners/2021/oct-21/unilever-big-c-cover-blog.jpg",
            "https://www.bigc.vn/files/banners/2022/mar/blog-c-100.jpg",
            "https://www.bigc.vn/files/banners/2022/feb/1080-x-540-cover-1.png",
        ]);
        return response($banners, 200);
    }

    public function getCategoryHome() {
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
        return response($categories,200);
    }
}
