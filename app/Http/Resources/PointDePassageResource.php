<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class PointDePassageResource extends JsonResource
{
    //  modele PointDePassage resource  with swagger documentation 
    
    /**
     * @OA\Schema(
     *     schema="PointDePassage",
     *     title="PointDePassage",
     *     description="PointDePassage",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="nom",title="nom",type="string"),
     *     @OA\Property(property="latitude_deg_min_sec",title="latitude_deg_min_sec",type="string"),
     *     @OA\Property(property="latitude_deg_dec",title="latitude_deg_dec",type="string"),
     *     @OA\Property(property="longitude_deg_min_sec",title="longitude_deg_min_sec",type="string"),
     *     @OA\Property(property="longitude_deg_dec",title="longitude_deg_dec",type="string"),
     *     @OA\Property(property="description",title="description",type="string"),
     *     @OA\Property(property="zone_id",title="zone_id",type="integer"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'latitude_deg_min_sec' => $this->latitude_deg_min_sec,
            'latitude_deg_dec' => $this->latitude_deg_dec,
            'longitude_deg_min_sec' => $this->longitude_deg_min_sec,
            'longitude_deg_dec' => $this->longitude_deg_dec,
            'description' => $this->description,
            'zone_id' => $this->zone_id,
            // 'zone' => $this->zone ? New ZoneResource($this->zone) : null,
        ];
    }
    
     
    
    
     
    
}
