<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Order;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'duration',
        'participants',
        'features',
        'min_participants',
        'max_participants',
        'unlimited_participants',
        'is_active',
    ];

    protected $casts = [
        'is_active'              => 'boolean',
        'unlimited_participants' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}