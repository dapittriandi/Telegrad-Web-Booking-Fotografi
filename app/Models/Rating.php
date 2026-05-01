<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'rating',
        'review'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION ORDER
    |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION USER
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}