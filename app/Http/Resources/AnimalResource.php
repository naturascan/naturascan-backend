<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 
class AnimalResource extends JsonResource
{
    //  modele Animal resource  with swagger documentation
    /**
     * @OA\Schema(
     *     schema="Animal",
     *     title="Animal",
     *     description="Animal",
     *     @OA\Property(property="taille",title="taille",type="string"),
     *     @OA\Property(property="nbre_estime",title="nbre_estime",type="integer"),
     *     @OA\Property(property="nbre_mini",title="nbre_mini",type="integer"),
     *     @OA\Property(property="nbre_maxi",title="nbre_maxi",type="integer"),
     *     @OA\Property(property="nbre_jeunes",title="nbre_jeunes",type="integer"),
     *     @OA\Property(property="nbre_nouveau_ne",title="nbre_nouveau_ne",type="integer"),
     *     @OA\Property(property="structure_groupe",title="structure_groupe",type="string"),
     *     @OA\Property(property="sous_group",title="sous_group",type="string"),
     *     @OA\Property(property="nbre_sous_groupes",title="nbre_sous_groupes",type="integer"),
     *     @OA\Property(property="nbre_indiv_sous_groupe",title="nbre_indiv_sous_groupe",type="integer"),
     *     @OA\Property(property="comportement_surface",title="comportement_surface",type="string"),
     *     @OA\Property(property="vitesse",title="vitesse",type="string"),
     *     @OA\Property(property="reaction_bateau",title="reaction_bateau",type="string"),
     *     @OA\Property(property="distance_estimee",title="distance_estimee",type="string"),
     *     @OA\Property(property="gisement",title="gisement",type="string"),
     *     @OA\Property(property="element_detection",title="element_detection",type="string"),
     *     @OA\Property(property="especes_associees",title="especes_associees",type="string"),
     *     @OA\Property(property="heure_debut",title="heure_debut",type="string"),
     *     @OA\Property(property="heure_fin",title="heure_fin",type="string"),
     * 
     *    @OA\Property(property="location_d_latitude_deg_min_sec",title="location_d_latitude_deg_min_sec",type="string"),
     *   @OA\Property(property="location_d_latitude_deg_dec",title="location_d_latitude_deg_dec",type="string"),
     *  @OA\Property(property="location_d_longitude_deg_min_sec",title="location_d_longitude_deg_min_sec",type="string"),
     * @OA\Property(property="location_d_longitude_deg_dec",title="location_d_longitude_deg_dec",type="string"),
     * @OA\Property(property="location_f_latitude_deg_min_sec",title="location_f_latitude_deg_min_sec",type="string"),
     * @OA\Property(property="location_f_latitude_deg_dec",title="location_f_latitude_deg_dec",type="string"),
     * @OA\Property(property="location_f_longitude_deg_min_sec",title="location_f_longitude_deg_min_sec",type="string"),
     * @OA\Property(property="location_f_longitude_deg_dec",title="location_f_longitude_deg_dec",type="string"),
     * @OA\Property(property="vitesse_navire",title="vitesse_navire",type="string"),
     * @OA\Property(property="activites_humaines_associees",title="activites_humaines_associees",type="string"),
     * @OA\Property(property="effort",title="effort",type="string"),
     * @OA\Property(property="commentaires",title="commentaires",type="string"),
     * @OA\Property(property="espece_id",title="espece_id",type="integer"),
     * @OA\Property(property="weather_report_id",title="weather_report_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            
            'taille'=> $this->taille,
            'nbre_estime'=> $this->nbre_estime,
            'nbre_mini'=> $this->nbre_mini,
            'nbre_maxi'=> $this->nbre_maxi,
            'nbre_jeunes'=> $this->nbre_jeunes,
            'nbre_nouveau_ne'=> $this->nbre_nouveau_ne,
            'structure_groupe'=> $this->structure_groupe,
            'sous_group'=> $this->sous_group,
            'nbre_sous_groupes'=> $this->nbre_sous_groupes,
            'nbre_indiv_sous_groupe'=> $this->nbre_indiv_sous_groupe,
            'comportement_surface'=> $this->comportement_surface,
            'vitesse'=> $this->vitesse,
            'reaction_bateau'=> $this->reaction_bateau,
            'distance_estimee'=> $this->distance_estimee,
            'gisement'=> $this->gisement,
            'element_detection'=> $this->element_detection,
            'especes_associees'=> $this->especes_associees,
            'heure_debut'=> $this->heure_debut,
            'heure_fin'=> $this->heure_fin,
            'location_d_latitude_deg_min_sec'=> $this->location_d_latitude_deg_min_sec,
            'location_d_latitude_deg_dec'=> $this->location_d_latitude_deg_dec,
            'location_d_longitude_deg_min_sec'=> $this->location_d_longitude_deg_min_sec,
            'location_d_longitude_deg_dec'=> $this->location_d_longitude_deg_dec,
            'location_f_latitude_deg_min_sec'=> $this->location_f_latitude_deg_min_sec,
            'location_f_latitude_deg_dec'=> $this->location_f_latitude_deg_dec,
            'location_f_longitude_deg_min_sec'=> $this->location_f_longitude_deg_min_sec,
            'location_f_longitude_deg_dec'=> $this->location_f_longitude_deg_dec,
            'vitesse_navire'=> $this->vitesse_navire,
            'activites_humaines_associees'=> $this->activites_humaines_associees,
            'effort'=> $this->effort,
            'commentaires'=> $this->commentaires, 
            'espece_id'=> $this->espece_id,
            'weather_report_id'=> $this->weather_report_id,
            'espece'=> new EspeceResource($this->espece),
            'weather_report'=> new WeatherReportResource($this->weather_report),
            

        ];

    }
}
