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
}
