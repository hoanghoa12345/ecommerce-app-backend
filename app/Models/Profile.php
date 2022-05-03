<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

//    protected $guarded = [];
    protected $fillable = [
        'description',
        'address',
        'avatar',
        'phone_number',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
