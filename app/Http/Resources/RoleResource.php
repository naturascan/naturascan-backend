<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 

class RoleResource extends JsonResource
{   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->firstname,
            'enabled' => $this->email,
            'isSysRole' => $this->mobile_number,
        ];
    }

 
}
