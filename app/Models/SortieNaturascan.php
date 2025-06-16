<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SortieNaturascan extends Model
{
    protected $fillable = [
        
       'structure',
       'port_depart',
       'port_arrivee',
       'heure_depart_port',
       'heure_arrivee_port',
       'duree_sortie',
       'nbre_observateurs',
       'type_bateau',
       'nom_bateau',
       'hauteur_bateau',
       'heure_utc',
       'distance_parcourue',
       'superficie_echantillonnee',
        'remarque_depart',
        'remarque_arrivee',
        'sortie_id',
        'departure_weather_report_id',
        'arrival_weather_report_id',
        'zone_id'

    ];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }

    public function departureWeatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }

    public function arrivalWeatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    

   
     
}
