<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class Amenity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The properties that have this amenity.
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenity');  
    }

     
}