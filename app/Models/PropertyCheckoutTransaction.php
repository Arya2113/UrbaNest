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
    
    public function getBuktiTransferTypeAttribute(): string
    {
        if (!$this->bukti_transfer_url) {
            return 'none';
        }

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
        
        if (Str::isUrl($this->bukti_transfer_url)) {
            
            $path = parse_url($this->bukti_transfer_url, PHP_URL_PATH);
        } else {
            
            $path = $this->bukti_transfer_url;
        }
        
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        }

        if ($extension === 'pdf') {
            return 'pdf';
        }

        return 'other';
    }
}
