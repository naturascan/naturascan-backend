<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bird extends Model
{
    protected $fillable = [
        'nbre_estime',
        'presence_jeune',
        'etat_groupe',
        'comportement',
        'reaction_bateau',
        'distance_estimee',
        'especes_associees',
        'heure_debut',
        'heure_fin',
        'vitesse_navire',
        'activites_humaines_associees',
        'effort',
        'commentaires',
        'location_d_latitude_deg_min_sec',
        'location_d_latitude_deg_dec',
        'location_d_longitude_deg_min_sec',
        'location_d_longitude_deg_dec',
        'location_f_latitude_deg_min_sec',
        'location_f_latitude_deg_dec',
        'location_f_longitude_deg_min_sec',
        'location_f_longitude_deg_dec',
        'espece_id',
        'weather_report_id',
    ];

    public function espece()
    {
        return $this->belongsTo(Espece::class);
    }

    public function weatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }

    
 

     
}
