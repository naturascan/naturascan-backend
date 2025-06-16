<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class ObservateurResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Observateur",
     *     title="Observateur",
     *     description="Observateur",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="nom",title="nom",type="string"),
     *     @OA\Property(property="prenom",title="prenom",type="string"),
     * )
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
        ];
    }
   
    
     
    
}
