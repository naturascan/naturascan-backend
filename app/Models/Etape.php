<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    protected $fillable = [
        
        'nom',
        'description',
        'heure_depart_port',
        'heure_arrivee_port',
        'sortie_id',
        'point_de_passage_id',
        'departure_weather_report_id',
        'arrival_weather_report_id',

    ];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }

    public function pointDePassage()
    {
        return $this->belongsTo(PointDePassage::class);
    }

    public function departureWeatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }

    public function arrivalWeatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }
    
     
}
