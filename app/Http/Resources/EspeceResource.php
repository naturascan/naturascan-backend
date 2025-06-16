<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class EspeceResource extends JsonResource
{
    //  modele Espece resource  with swagger documentation (Espece Model)
    /**
     * @OA\Schema(
     *     schema="Espece",
     *     title="Espece",
     *     description="Espece",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="common_name",title="common_name",type="string"),
     *     @OA\Property(property="scientific_name",title="scientific_name",type="string"),
     *     @OA\Property(property="description",title="description",type="string"),
     *     @OA\Property(property="category_id",title="category_id",type="integer"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'common_name' => $this->common_name,
            'scientific_name' => $this->scientific_name,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];
    }
     
    
}
