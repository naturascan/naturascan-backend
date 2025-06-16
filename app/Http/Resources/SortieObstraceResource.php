<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SortieObstraceResource extends JsonResource
{   
    //  modele SortieObstrace resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="SortieObstrace",
     *     title="SortieObstrace",
     *     description="SortieObstrace",
     *     @OA\Property(property="plage",title="plage",type="string"),
     *     @OA\Property(property="nbre_observateurs",title="nbre_observateurs",type="integer"),
     *     @OA\Property(property="suivi",title="suivi",type="string"),
     *     @OA\Property(property="prospection_heure_debut",title="prospection_heure_debut",type="string"),
     *     @OA\Property(property="prospection_heure_fin",title="prospection_heure_fin",type="string"),
     *     @OA\Property(property="remark",title="remark",type="string"),
     *     @OA\Property(property="type_bateau",title="type_bateau",type="string"),
     *     @OA\Property(property="nom_bateau",title="nom_bateau",type="string"),
     *     @OA\Property(property="hauteur_bateau",title="hauteur_bateau",type="string"),
     *     @OA\Property(property="sortie_id",title="sortie_id",type="integer"),
     *     @OA\Property(property="weather_report_id",title="weather_report_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            'plage' => $this->plage,
            'nbre_observateurs' => $this->nbre_observateurs,
            'suivi' => $this->suivi,
            'prospection_heure_debut' => $this->prospection_heure_debut,
            'prospection_heure_fin' => $this->prospection_heure_fin,
            'remark' => $this->remark,
            'type_bateau' => $this->type_bateau,
            'nom_bateau' => $this->nom_bateau,
            'hauteur_bateau' => $this->hauteur_bateau,
            'sortie_id' => $this->sortie_id,
            'weather_report_id' => $this->weather_report_id,
            'weather_report' => new WeatherReportResource($this->weather_report),
        ];
    }

 
}
