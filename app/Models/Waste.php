<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    protected $fillable = [
        'nature_deche',
        'estimated_size',
        'matiere',
        'color',
        'deche_peche',
        'picked',
        'heure_debut',
        'vitesse_navire',
        'effort',
        'commentaires',
        'location_latitude_deg_min_sec',
        'location_latitude_deg_dec',
        'location_longitude_deg_min_sec',
        'location_longitude_deg_dec',  
        'weather_report_id',
        'dechet_id'
    ];


    public function weatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }

    public function dechet()
    {
        return $this->belongsTo(Dechet::class);
    }
 
}
