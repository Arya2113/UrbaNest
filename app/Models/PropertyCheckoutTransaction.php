<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCheckoutTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'status_transaksi',
        'harga_properti',
        'biaya_jasa',
        'total_transfer',
        'bukti_transfer_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
