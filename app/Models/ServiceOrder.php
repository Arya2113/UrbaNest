<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'architect_id',
        'full_name',
        'email',
        'phone_number',
        'project_location',
        'service_type',
        'estimated_budget',
        'project_date',
        'project_description',
        'status'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function architect()
    {
        return $this->belongsTo(Architect::class);
    }
}
