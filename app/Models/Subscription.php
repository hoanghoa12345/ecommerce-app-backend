<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'total_price'
    ];

    public function details() {
        return $this->hasMany(SubscriptionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id','name']);
    }

    public function userSubs() {
        return $this->hasMany(UserSubscription::class);
    }
}
