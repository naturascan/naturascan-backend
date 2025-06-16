<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointDePassage extends Model
{
    protected $fillable = [
    
        'nom',
        'latitude_deg_min_sec',
        'latitude_deg_dec',
        'longitude_deg_min_sec',
        'longitude_deg_dec',
        'description',
        'zone_id',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    
    
}
