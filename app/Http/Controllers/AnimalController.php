<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use App\Http\Resources\AnimalResource;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    // modele animal controller with swagger documentation

    /**
     * @OA\Get(
     *     path="/api/animals",
     *     tags={"Animal"},
     *     security={{"sanctum": {}}},
     *     summary="List all animals",
     *     @OA\Response(response="200", description="List all animals"),
     * )
     */
    public function index()
    {
        $animals = Animal::all();
        return AnimalResource::collection($animals);
    }

    /**
     * @OA\Post(
     *     path="/api/animals",
     *     tags={"Animal"},
     * security={{"sanctum": {}}},
     *     summary="Create a new animal",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Animal"),
     *     ),
     *     @OA\Response(response="201", description="Create a new animal"),
     * )
     */ 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'taille' => 'string',
            'nbre_estime' => 'integer',
            'nbre_mini' => 'integer',
            'nbre_maxi' => 'integer',
            'nbre_jeunes' => 'integer',
            'nbre_nouveau_ne' => 'integer',
            'structure_groupe' => 'string',
            'sous_group' => 'string',
            'nbre_sous_groupes' => 'integer',
            'nbre_indiv_sous_groupe' => 'integer',
            'comportement_surface' => 'string',
            'vitesse' => 'string',
            'reaction_bateau' => 'string',
            'distance_estimee' => 'string',
            'gisement' => 'string',
            'element_detection' => 'string',
            'especes_associees' => 'string',
            'heure_debut' => 'string',
            'heure_fin' => 'string',
            'location_d_latitude_deg_min_sec' => 'string',
            'location_d_latitude_deg_dec' => 'string',
            'location_d_longitude_deg_min_sec' => 'string',
            'location_d_longitude_deg_dec' => 'string',
            'location_f_latitude_deg_min_sec' => 'string',
            'location_f_latitude_deg_dec' => 'string',
            'location_f_longitude_deg_min_sec' => 'string',
            'location_f_longitude_deg_dec' => 'string',
            'vitesse_navire' => 'string',
            'activites_humaines_associees' => 'string',
            'effort' => 'string',
            'commentaires' => 'string',
            'espece_id' => 'integer',
            'weather_report_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $animal = Animal::create($request->all());
        return new AnimalResource($animal);
    }

    /**
     * @OA\Get(
     *     path="/api/animals/{id}",
     *     tags={"Animal"},
     * security={{"sanctum": {}}},
     *     summary="Show animal by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the animal",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show animal by ID"),
     *     @OA\Response(response="404", description="Animal not found"),
     * )
     */
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return new AnimalResource($animal);
    }

    /**
     * @OA\Put(
     *     path="/api/animals/{id}",
     *     tags={"Animal"},
     * security={{"sanctum": {}}},
     *     summary="Update animal by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the animal",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Animal"),
     *     ),
     *     @OA\Response(response="200", description="Update animal by ID"),
     *     @OA\Response(response="404", description="Animal not found"),
     * )
     */

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);
        $animal->update($request->all());
        return new AnimalResource($animal);
    }

    /**
     * @OA\Delete(
     *     path="/api/animals/{id}",
     *     tags={"Animal"},
     * security={{"sanctum": {}}},
     *     summary="Delete animal by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the animal",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Delete animal by ID"),
     *     @OA\Response(response="404", description="Animal not found"),
     * )
     */
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();
        return response()->json(null, 204);
    }

    

    
    
    
    
}
