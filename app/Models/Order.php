<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'start_time',
        'end_time',
        'phone', 
        'location',
        'notes',
        'total_price',
        'status'
    ];

    /*
    |--------------------------------
    | RELATIONSHIP
    |--------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}