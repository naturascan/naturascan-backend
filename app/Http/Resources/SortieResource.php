<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SortieResource extends JsonResource
{   
    //  modele Zone resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="Sortie",
     *     title="Sortie",
     *     description="Sortie",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="type",title="type",type="string"),
     *     @OA\Property(property="synchronised",title="synchronised",type="boolean"),
     *     @OA\Property(property="obstrace",title="obstrace",type="object",ref="#/components/schemas/SortieObstrace"),
     *    @OA\Property(property="naturascan",title="naturascan",type="object",ref="#/components/schemas/SortieNaturascan"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'synchronised' => true,
            'obstrace' => $this->type == 'obstrace' ? New SortieObstraceResource($this->obstrace) : null,
            'naturascan' => $this->type == 'naturascan' ? New SortieNaturascan($this->naturascan) : null,
        ];
    }

 
}
