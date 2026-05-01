<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean', // ← cast 0/1 ke true/false
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portofolio::class);
    }
}