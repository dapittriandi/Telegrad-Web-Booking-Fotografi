<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'image',
        'description',
        'is_active', // ← tambahkan ini
    ];

    protected $casts = [
        'is_active' => 'boolean', // ← agar otomatis cast ke true/false
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}