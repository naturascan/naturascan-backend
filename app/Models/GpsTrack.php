<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsTrack extends Model
{
    protected $fillable = [
        
        'longitude',
        'latitude',
        'timestamp',
        'device',
        'inObservation',
        'sortie_id',
    ];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }
   
}
