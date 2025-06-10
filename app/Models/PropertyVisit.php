<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyVisit extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property that the visit is for.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
