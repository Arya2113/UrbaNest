<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

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
        'alamat', // Added alamat here
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'image_path',
        'developer_id',
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
        return $this->belongsToMany(User::class, 'property_user');
    }
}
