<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class ZoneResource extends JsonResource
{
    //  modele Zone resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="Zone",
     *     title="Zone",
     *     description="Zone",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="name",title="name",type="string"),
     *     @OA\Property(property="nbre_points",title="nbre_points",type="integer"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nbre_points' => $this->nbre_points,
            'points' => PointDePassageResource::collection($this->pointDePassages), 
        ];
    }
    
     
    
}
