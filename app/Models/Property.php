<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Amenity;

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
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'image_path',
    ];

    /**
     * The amenities that belong to the property.
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity'); // Specify the pivot table name
    }

    //
}