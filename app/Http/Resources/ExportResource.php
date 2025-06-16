<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class ExportResource extends JsonResource
{

    /**
     * @OA\Schema(
     *     schema="Export",
     *     title="Export",
     *     description="Export",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="uuid",title="uuid",type="string"),
     *     @OA\Property(property="data",title="data",type="string"),
     * )
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'data' => $this->data,
        ];
    }
    
}
