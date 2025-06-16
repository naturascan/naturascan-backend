<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class ObservationResource extends JsonResource
{
    //  modele Observation resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="Observation",
     *     title="Observation",
     *     description="Observation",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="type",title="type",type="string"),
     *     @OA\Property(property="sortie_id",title="sortie_id",type="integer"),
     *     @OA\Property(property="animal_id",title="animal_id",type="integer"),
     *     @OA\Property(property="bird_id",title="bird_id",type="integer"),
     *     @OA\Property(property="waste_id",title="waste_id",type="integer"),
     *     @OA\Property(property="created_at",title="created_at",type="string"),
     *     @OA\Property(property="updated_at",title="updated_at",type="string"),
     * )
    */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'sortie_id' => $this->sortie_id,
            'animal_id' => $this->animal_id,
            'bird_id' => $this->bird_id,
            'waste_id' => $this->waste_id, 
            'animal' => $this->animal ? New AnimalResource($this->animal) : null,
            'bird' => $this->bird ? New BirdResource($this->bird) : null,
            'waste' => $this->waste ? New WasteResource($this->waste) : null,
        ];
    }
   
    
}
