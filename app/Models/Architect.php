<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Architect extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name',
        'photo',
        'title',
        'rating',
        'reviews_count',
        'experience_years',
        'location',
        'styles',
    ];

    protected $casts = [
        'styles' => 'array',
    ];

    // ✅ Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
