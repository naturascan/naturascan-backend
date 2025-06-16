<?php

namespace App\Http\Controllers;

use App\Models\Bird;
use Illuminate\Http\Request;
use App\Http\Resources\BirdResource;
use Illuminate\Support\Facades\Validator;

class BirdController extends Controller
{
    // modele bird controller with swagger documentation

    /**
     * @OA\Get(
     *     path="/api/birds",
     *     tags={"Bird"},
     *     security={{"sanctum": {}}},
     *     summary="List all birds",
     *     @OA\Response(response="200", description="List all birds"),
     * )
     */
    public function index()
    {
        $birds = Bird::all();
        return BirdResource::collection($birds);
    }

    /**
     * @OA\Post(
     *     path="/api/birds",
     *     tags={"Bird"},
     * security={{"sanctum": {}}},
     *     summary="Create a new bird",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Bird"),
     *     ),
     *     @OA\Response(response="201", description="Create a new bird"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nbre_estime' => 'integer',
            'presence_jeune' => 'string',
            'etat_groupe' => 'string',
            'comportement' => 'string',
            'reaction_bateau' => 'string',
            'distance_estimee' => 'string',
            'especes_associees' => 'string',
            'heure_debut' => 'string',
            'heure_fin' => 'string',
            'vitesse_navire' => 'string',
            'activites_humaines_associees' => 'string',
            'effort' => 'string',
            'commentaires' => 'string',
            'location_d_latitude_deg_min_sec' => 'string',
            'location_d_latitude_deg_dec' => 'string',
            'location_d_longitude_deg_min_sec' => 'string',
            'location_d_longitude_deg_dec' => 'string',
            'location_f_latitude_deg_min_sec' => 'string',
            'location_f_latitude_deg_dec' => 'string',
            'location_f_longitude_deg_min_sec' => 'string',
            'location_f_longitude_deg_dec' => 'string',
            'espece_id' => 'integer',
            'weather_report_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $bird = Bird::create($request->all());
        return new BirdResource($bird);
    }

    /**
     * @OA\Get(
     *     path="/api/birds/{id}",
     *     tags={"Bird"},
     * security={{"sanctum": {}}},
     *     summary="Show bird by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the bird",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show bird by ID"),
     *     @OA\Response(response="404", description="Bird not found"),
     * )
     */
    public function show($id)
    {
        $bird = Bird::findOrFail($id);
        return new BirdResource($bird);
    }

    /**
     * @OA\Put(
     *     path="/api/birds/{id}",
     *     tags={"Bird"},
     * security={{"sanctum": {}}},
     *     summary="Update bird by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the bird",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Bird"),
     *     ),
     *     @OA\Response(response="200", description="Update bird by ID"),
     *     @OA\Response(response="404", description="Bird not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $bird = Bird::findOrFail($id);
        $bird->update($request->all());
        return new BirdResource($bird);
    }

    /**
     * @OA\Delete(
     *     path="/api/birds/{id}",
     *     tags={"Bird"},
     * security={{"sanctum": {}}},
     *     summary="Delete bird by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the bird",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Delete bird by ID"),
     *     @OA\Response(response="404", description="Bird not found"),
     * )
     */
    public function destroy($id)
    {
        $bird = Bird::findOrFail($id);
        $bird->delete();
        return response()->json(null, 204);
    }

    
    
    
    
    
}
