<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class CategoryResource extends JsonResource
{
    //  category resource  with swagger documentation
    /**
     * @OA\Schema(
     *     schema="Category",
     *     title="Category",
     *     description="Category",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="name",title="name",type="string"),
     *     @OA\Property(property="description",title="description",type="string"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'especes' => EspeceResource::collection($this->especes),
        ];
    }
}
