<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class BirdResource extends JsonResource
{
    //  modele Bird resource  with swagger documentation 

    /**
     * @OA\Schema(
     *     schema="Bird",
     *     title="Bird",
     *     description="Bird",
     *     @OA\Property(property="nbre_estime",title="nbre_estime",type="integer"),
     *     @OA\Property(property="presence_jeune",title="presence_jeune",type="string"),
     *     @OA\Property(property="etat_groupe",title="etat_groupe",type="string"),
     *     @OA\Property(property="comportement",title="comportement",type="string"),
     *     @OA\Property(property="reaction_bateau",title="reaction_bateau",type="string"),
     *     @OA\Property(property="distance_estimee",title="distance_estimee",type="string"),
     *     @OA\Property(property="especes_associees",title="especes_associees",type="string"),
     *     @OA\Property(property="heure_debut",title="heure_debut",type="string"),
     *     @OA\Property(property="heure_fin",title="heure_fin",type="string"),
     *     @OA\Property(property="vitesse_navire",title="vitesse_navire",type="string"),
     *     @OA\Property(property="activites_humaines_associees",title="activites_humaines_associees",type="string"),
     *     @OA\Property(property="effort",title="effort",type="string"),
     *     @OA\Property(property="commentaires",title="commentaires",type="string"),
     *     @OA\Property(property="location_d_latitude_deg_min_sec",title="location_d_latitude_deg_min_sec",type="string"),
     *     @OA\Property(property="location_d_latitude_deg_dec",title="location_d_latitude_deg_dec",type="string"),
     *     @OA\Property(property="location_d_longitude_deg_min_sec",title="location_d_longitude_deg_min_sec",type="string"),
     *     @OA\Property(property="location_d_longitude_deg_dec",title="location_d_longitude_deg_dec",type="string"),
     *     @OA\Property(property="location_f_latitude_deg_min_sec",title="location_f_latitude_deg_min_sec",type="string"),
     *     @OA\Property(property="location_f_latitude_deg_dec",title="location_f_latitude_deg_dec",type="string"),
     *    @OA\Property(property="location_f_longitude_deg_min_sec",title="location_f_longitude_deg_min_sec",type="string"),
     *   @OA\Property(property="location_f_longitude_deg_dec",title="location_f_longitude_deg_dec",type="string"),
     * @OA\Property(property="espece_id",title="espece_id",type="integer"),
     * @OA\Property(property="weather_report_id",title="weather_report_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            'nbre_estime' => $this->nbre_estime,
            'presence_jeune' => $this->presence_jeune,
            'etat_groupe' => $this->etat_groupe,
            'comportement' => $this->comportement,
            'reaction_bateau' => $this->reaction_bateau,
            'distance_estimee' => $this->distance_estimee,
            'especes_associees' => $this->especes_associees,
            'heure_debut' => $this->heure_debut,
            'heure_fin' => $this->heure_fin,
            'vitesse_navire' => $this->vitesse_navire,
            'activites_humaines_associees' => $this->activites_humaines_associees,
            'effort' => $this->effort,
            'commentaires' => $this->commentaires,
            'location_d_latitude_deg_min_sec' => $this->location_d_latitude_deg_min_sec,
            'location_d_latitude_deg_dec' => $this->location_d_latitude_deg_dec,
            'location_d_longitude_deg_min_sec' => $this->location_d_longitude_deg_min_sec,
            'location_d_longitude_deg_dec' => $this->location_d_longitude_deg_dec,
            'location_f_latitude_deg_min_sec' => $this->location_f_latitude_deg_min_sec,
            'location_f_latitude_deg_dec' => $this->location_f_latitude_deg_dec,
            'location_f_longitude_deg_min_sec' => $this->location_f_longitude_deg_min_sec,
            'location_f_longitude_deg_dec' => $this->location_f_longitude_deg_dec,
            'espece_id' => $this->espece_id,
            'weather_report_id' => $this->weather_report_id,
            'espece' => new EspeceResource($this->espece),
            'weatherReport' => new WeatherReportResource($this->weatherReport),
        ];
    }

    
    
     
    
}
