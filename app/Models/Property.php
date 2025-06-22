<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'address',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'image_path', 
        'developer_id',
        'locked_by_user_id',
        'locked_until',
    ];

    protected $casts = [
        'locked_until' => 'datetime',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity');  
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_user')->withTimestamps();
    }

    public function lockedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by_user_id');
    }

    public function propertyCheckoutTransactions()
    {
        return $this->hasMany(PropertyCheckoutTransaction::class, 'property_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }
}
