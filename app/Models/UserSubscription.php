<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'start_date',
        'end_date',
        'payment_status',
        'delivery_schedule',
    ];

    /**
     * @return HasMany
     */
    public function deliveries ()
    {
        return $this->hasMany(SubscriptionDelivery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}
