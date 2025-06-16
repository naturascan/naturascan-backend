<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'taille',
        'nbre_estime',
        'nbre_mini',
        'nbre_maxi',
        'nbre_jeunes',
        'nbre_nouveau_ne',
        'structure_groupe',
        'sous_group',
        'nbre_sous_groupes',
        'nbre_indiv_sous_groupe',
        'comportement_surface',
        'vitesse',
        'reaction_bateau',
        'distance_estimee',
        'gisement',
        'element_detection',
        'especes_associees',
        'heure_debut',
        'heure_fin',
        'location_d_latitude_deg_min_sec',
        'location_d_latitude_deg_dec',
        'location_d_longitude_deg_min_sec',
        'location_d_longitude_deg_dec',
        'location_f_latitude_deg_min_sec',
        'location_f_latitude_deg_dec',
        'location_f_longitude_deg_min_sec',
        'location_f_longitude_deg_dec',
        'vitesse_navire',
        'activites_humaines_associees',
        'effort',
        'commentaires', 
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
