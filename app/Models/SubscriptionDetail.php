<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
      'subscription_id',
      'product_id',
      'price',
      'quantity'
    ];

    public function product () {
        return $this->belongsTo(Product::class);
    }
}
