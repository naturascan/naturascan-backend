<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class EtapeResource extends JsonResource
{
    //  modele Etape resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="Etape",
     *     title="Etape",
     *     description="Etape",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="nom",title="nom",type="string"),
     *     @OA\Property(property="description",title="description",type="string"),
     *     @OA\Property(property="heure_depart_port",title="heure_depart_port",type="string"),
     *     @OA\Property(property="heure_arrivee_port",title="heure_arrivee_port",type="string"),
     *     @OA\Property(property="sortie_id",title="sortie_id",type="integer"),
     *     @OA\Property(property="point_de_passage_id",title="point_de_passage_id",type="integer"),
     *     @OA\Property(property="departure_weather_report_id",title="departure_weather_report_id",type="integer"),
     *     @OA\Property(property="arrival_weather_report_id",title="arrival_weather_report_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'heure_depart_port' => $this->heure_depart_port,
            'heure_arrivee_port' => $this->heure_arrivee_port,
            'sortie_id' => $this->sortie_id,
            'point_de_passage_id' => $this->point_de_passage_id,
            'departure_weather_report_id' => $this->departure_weather_report_id,
            'arrival_weather_report_id' => $this->arrival_weather_report_id,
            'point_de_passage' => new PointDePassageResource($this->point_de_passage),
            'departure_weather_report' => new WeatherReportResource($this->departure_weather_report),
            'arrival_weather_report' => new WeatherReportResource($this->arrival_weather_report),
        ];
    }
    
     
    
}
