<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class WasteResource extends JsonResource
{
    //  modele Waste resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="Waste",
     *     title="Waste",
     *     description="Waste",
     *     @OA\Property(property="nature_deche",title="nature_deche",type="string"),
     *     @OA\Property(property="estimated_size",title="estimated_size",type="string"),
     *     @OA\Property(property="matiere",title="matiere",type="string"),
     *     @OA\Property(property="color",title="color",type="string"),
     *     @OA\Property(property="deche_peche",title="deche_peche",type="string"),
     *     @OA\Property(property="picked",title="picked",type="string"),
     *     @OA\Property(property="heure_debut",title="heure_debut",type="string"),
     *     @OA\Property(property="vitesse_navire",title="vitesse_navire",type="string"),
     *     @OA\Property(property="effort",title="effort",type="string"),
     *     @OA\Property(property="commentaires",title="commentaires",type="string"),
     *     @OA\Property(property="location_latitude_deg_min_sec",title="location_latitude_deg_min_sec",type="string"),
     *     @OA\Property(property="location_latitude_deg_dec",title="location_latitude_deg_dec",type="string"),
     *     @OA\Property(property="location_longitude_deg_min_sec",title="location_longitude_deg_min_sec",type="string"),
     *     @OA\Property(property="location_longitude_deg_dec",title="location_longitude_deg_dec",type="string"),
     *     @OA\Property(property="weather_report_id",title="weather_report_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            
            'nature_deche'=> $this->nature_deche,
            'estimated_size'=> $this->estimated_size,
            'matiere'=> $this->matiere,
            'color'=> $this->color,
            'deche_peche'=> $this->deche_peche,
            'picked'=> $this->picked,
            'heure_debut'=> $this->heure_debut,
            'vitesse_navire'=> $this->vitesse_navire,
            'effort'=> $this->effort,
            'commentaires'=> $this->commentaires,
            'location_latitude_deg_min_sec'=> $this->location_latitude_deg_min_sec,
            'location_latitude_deg_dec'=> $this->location_latitude_deg_dec,
            'location_longitude_deg_min_sec'=> $this->location_longitude_deg_min_sec,
            'location_longitude_deg_dec'=> $this->location_longitude_deg_dec,
            'weather_report_id'=> $this->weather_report_id,
            'weather_report'=> New WeatherReportResource($this->weatherReport),
            'dechet_id'=> $this->dechet_id,
            'dechet'=> New DechetResource($this->dechet),

        ];
    
    }
    
}
