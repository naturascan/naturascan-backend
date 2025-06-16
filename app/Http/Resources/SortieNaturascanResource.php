<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SortieNaturascanResource extends JsonResource
{   
    //  modele SortieNaturascan resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="SortieNaturascan",
     *     title="SortieNaturascan",
     *     description="SortieNaturascan",
     *     @OA\Property(property="structure",title="structure",type="string"),
     *     @OA\Property(property="port_depart",title="port_depart",type="string"),
     *     @OA\Property(property="port_arrivee",title="port_arrivee",type="string"),
     *     @OA\Property(property="heure_depart_port",title="heure_depart_port",type="string"),
     *     @OA\Property(property="heure_arrivee_port",title="heure_arrivee_port",type="string"),
     *     @OA\Property(property="duree_sortie",title="duree_sortie",type="string"),
     *     @OA\Property(property="nbre_observateurs",title="nbre_observateurs",type="integer"),
     *     @OA\Property(property="type_bateau",title="type_bateau",type="string"),
     *     @OA\Property(property="nom_bateau",title="nom_bateau",type="string"),
     *     @OA\Property(property="hauteur_bateau",title="hauteur_bateau",type="string"),
     *     @OA\Property(property="heure_utc",title="heure_utc",type="string"),
     *     @OA\Property(property="distance_parcourue",title="distance_parcourue",type="string"),
     *     @OA\Property(property="superficie_echantillonnee",title="superficie_echantillonnee",type="string"),
     *     @OA\Property(property="remarque_depart",title="remarque_depart",type="string"),
     *     @OA\Property(property="remarque_arrivee",title="remarque_arrivee",type="string"),
     *     @OA\Property(property="sortie_id",title="sortie_id",type="integer"),
     *     @OA\Property(property="departure_weather_report_id",title="departure_weather_report_id",type="integer"),
     *     @OA\Property(property="arrival_weather_report_id",title="arrival_weather_report_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            'structure' => $this->structure,
            'port_depart' => $this->port_depart,
            'port_arrivee' => $this->port_arrivee,
            'heure_depart_port' => $this->heure_depart_port,
            'heure_arrivee_port' => $this->heure_arrivee_port,
            'duree_sortie' => $this->duree_sortie,
            'nbre_observateurs' => $this->nbre_observateurs,
            'type_bateau' => $this->type_bateau,
            'nom_bateau' => $this->nom_bateau,
            'hauteur_bateau' => $this->hauteur_bateau,
            'heure_utc' => $this->heure_utc,
            'distance_parcourue' => $this->distance_parcourue,
            'superficie_echantillonnee' => $this->superficie_echantillonnee,
            'remarque_depart' => $this->remarque_depart,
            'remarque_arrivee' => $this->remarque_arrivee,
            'sortie_id' => $this->sortie_id,
            'departure_weather_report_id' => $this->departure_weather_report_id,
            'arrival_weather_report_id' => $this->arrival_weather_report_id,
            'departure_weather_report' => new WeatherReportResource($this->departure_weather_report),
            'arrival_weather_report' => new WeatherReportResource($this->arrival_weather_report),
            'zone' => new ZoneResource($this->zone),
            'etapes' => EtapeResource::collection($this->etapes),
            'observations' => ObservationResource::collection($this->observations),
            'gps'=> GpsResource::collection($this->gps),

        ];
    }


 
}
