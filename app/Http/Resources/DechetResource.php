<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class DechetResource extends JsonResource
{
    //  modele Dechet resource  with swagger documentation 
    // name

    /**
     * @OA\Schema(
     *     schema="Dechet",
     *     title="Dechet",
     *     description="Dechet",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="name",title="name",type="string"),
     * )
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
   
    
     
    
}
