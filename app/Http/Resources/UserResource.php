<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 

class UserResource extends JsonResource
{   
    //  modele User resource  with swagger documentation
    /**
     * @OA\Schema(
     *     schema="User",
     *     title="User",
     *     description="User",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="name",title="name",type="string"),
     *     @OA\Property(property="firstname",title="firstname",type="string"),
     *     @OA\Property(property="email",title="email",type="string"),
     *     @OA\Property(property="mobile_number",title="mobile_number",type="string"),
     *     @OA\Property(property="adress",title="adress",type="string"),
     *     @OA\Property(property="access",title="access",type="string"),
     *     @OA\Property(property="pseudo",title="pseudo",type="string"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'adress' => $this->adress,
            'access' => $this->get_access(),
            'pseudo' => $this->pseudo,
            'total_export' => $this->total_export,
        ];
    }

    public function get_access(){

        $admin_emails = ['appli.naturascan@gmail.com','S.catteau@association-emergence.fr'];

        if (in_array(auth()->user()->email, $admin_emails)) {
            return 0;
        }
        return $this->access;
    }

 
}
