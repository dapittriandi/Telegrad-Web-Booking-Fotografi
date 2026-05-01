<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_link',
        'delivery_file',
        'delivery_date',
        'status',
        'notes'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}