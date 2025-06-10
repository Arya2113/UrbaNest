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
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'alamat',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'image_path', // This will likely become obsolete or represent a single main image
        'developer_id',
        'locked_by_user_id',
        'locked_until',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'locked_until' => 'datetime',
    ];

    /**
     * The amenities that belong to the property.
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity'); // Specify the pivot table name
    }

     /**
     * Get the developer that owns the property.
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    /**
     * The users that have favorited the property.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_user')->withTimestamps();
    }

    /**
     * Get the user that currently has the property locked.
     */
    public function lockedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by_user_id');
    }

    public function propertyCheckoutTransactions()
    {
        return $this->hasMany(PropertyCheckoutTransaction::class, 'property_id');
    }

    /**
     * Get the images for the property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }
}
