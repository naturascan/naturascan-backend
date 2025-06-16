<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 
class GpsTrackResource extends JsonResource
{   

    //  modele GpsTrack resource  with swagger documentation
    /**
     * @OA\Schema(
     *     schema="GpsTrack",
     *     title="GpsTrack",
     *     description="GpsTrack",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="longitude",title="longitude",type="string"),
     *     @OA\Property(property="shipping_id",title="shipping_id",type="integer"),
     *     @OA\Property(property="latitude",title="latitude",type="string"),
     *     @OA\Property(property="timestamp",title="timestamp",type="string"),
     *     @OA\Property(property="device",title="device",type="string"),
     *     @OA\Property(property="inObservation",title="inObservation",type="boolean"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'longitude' => $this->longitude,
            'shipping_id' => $this->shipping_id,
            'latitude' => $this->latitude,
            'timestamp' => $this->timestamp,
            'device' => $this->device,
            'inObservation' => $this->inObservation,
        ];
    }
}
