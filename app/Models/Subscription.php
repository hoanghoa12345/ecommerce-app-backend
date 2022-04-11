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
}
