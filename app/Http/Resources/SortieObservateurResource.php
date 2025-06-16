<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 
class SortieObservateurResource extends JsonResource
{   

    //  modele SortieObservateur resource  with swagger documentation
    /**
     * @OA\Schema(
     *     schema="SortieObservateur",
     *     title="SortieObservateur",
     *     description="SortieObservateur",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="role",title="role",type="string"),
     *     @OA\Property(property="sortie_id",title="sortie_id",type="integer"),
     *     @OA\Property(property="user_id",title="user_id",type="integer"),
     * )
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role' => $this->role,
            'sortie_id' => $this->sortie_id,
            'user_id' => $this->user_id,
        ];
    }
    
}
