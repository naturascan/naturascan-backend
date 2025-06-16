<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 

class PolicyResource extends JsonResource
{   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->firstname,
            'enabled' => $this->email,
        ];
    }

 
}
