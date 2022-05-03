<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionsUserController extends Controller
{
    public function store(Request $request)
    {
        return response("Created",201);
    }

    public function byUser(User $user)
    {
        return Subscription::whereIn('user_id', $user)->with('user')->latest()->get();
    }
}
