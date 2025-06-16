<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class WeatherReportResource extends JsonResource
{
    //  modele WeatherReport resource  with swagger documentation 
    /**
     * @OA\Schema(
     *     schema="WeatherReport",
     *     title="WeatherReport",
     *     description="WeatherReport",
     *     @OA\Property(property="id",title="id",type="integer"),
     *     @OA\Property(property="city",title="city",type="string"),
     *     @OA\Property(property="temperature",title="temperature",type="string"),
     *     @OA\Property(property="humidity",title="humidity",type="string"),
     *     @OA\Property(property="weather",title="weather",type="string"),
     *     @OA\Property(property="wind_speed",title="wind_speed",type="string"),
     *     @OA\Property(property="wind_direction",title="wind_direction",type="string"),
     *     @OA\Property(property="created_at",title="created_at",type="string"),
     *     @OA\Property(property="updated_at",title="updated_at",type="string"),
     * )
    */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'temperature' => $this->temperature,
            'humidity' => $this->humidity,
            'weather' => $this->weather,
            'wind_speed' => $this->wind_speed,
            'wind_direction' => $this->wind_direction,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
     
    
    
     
    
}
