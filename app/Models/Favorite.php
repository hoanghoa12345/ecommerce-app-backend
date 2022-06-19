<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}
