<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SortieObstrace extends Model
{
    protected $fillable = [
        
        'plage',
        'nbre_observateurs',
        'suivi',
        'prospection_heure_debut',
        'prospection_heure_fin',
        'remark',
        'type_bateau',
        'nom_bateau',
        'hauteur_bateau',
        'sortie_id',
        'weather_report_id',

    ];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }

    public function weatherReport()
    {
        return $this->belongsTo(WeatherReport::class);
    }




   
     
}
