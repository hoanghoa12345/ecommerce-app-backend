<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','total_price','total_qty','order_number'];

    public function details()
    {
        $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
