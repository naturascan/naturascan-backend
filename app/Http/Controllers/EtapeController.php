<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use Illuminate\Http\Request;
use App\Http\Resources\EtapeResource;
use Illuminate\Support\Facades\Validator;

class EtapeController extends Controller
{
    
    // 'nom',
    // 'description',
    // 'heure_depart_port',
    // 'heure_arrivee_port',
    // 'sortie_id',
    // 'point_de_passage_id',
    // 'departure_weather_report_id',
    // 'arrival_weather_report_id',

    /**
     * @OA\Get(
     *     path="/api/etapes",
     *     tags={"Etape"},
     *     security={{"sanctum": {}}},
     *     summary="List all etape species",
     *     @OA\Response(response="200", description="List all etape species"),
     * )
     */

    public function index()
    {
        $etapes = Etape::all();
        return EtapeResource::collection($etapes);
    }

    /**
     * @OA\Post(
     *     path="/api/etapes",
     *     tags={"Etape"},
     * security={{"sanctum": {}}},
     *     summary="Create a new etape species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Etape"),
     *     ),
     *     @OA\Response(response="201", description="Create a new etape species"),
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'string',
            'description' => 'string',
            'heure_depart_port' => 'string',
            'heure_arrivee_port' => 'string',
            'sortie_id' => 'integer',
            'point_de_passage_id' => 'integer',
            'departure_weather_report_id' => 'integer',
            'arrival_weather_report_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $etape = Etape::create($request->all());
        return new EtapeResource($etape);
    }

    /**
     * @OA\Get(
     *     path="/api/etapes/{id}",
     *     tags={"Etape"},
     * security={{"sanctum": {}}},
     *     summary="Show etape species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the etape species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show etape species by ID"),
     *     @OA\Response(response="404", description="Etape species not found"),
     * )
     */
    public function show($id)
    {
        $etape = Etape::findOrFail($id);
        return new EtapeResource($etape);
    }

    /**
     * @OA\Put(
     *     path="/api/etapes/{id}",
     *     tags={"Etape"},
     * security={{"sanctum": {}}},
     *     summary="Update etape species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the etape species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Etape"),
     *     ),
     *     @OA\Response(response="200", description="Update etape species by ID"),
     *     @OA\Response(response="404", description="Etape species not found"),
     * )
     */

    public function update(Request $request, $id)
    {
        $etape = Etape::findOrFail($id);
        $etape->update($request->all());
        return new EtapeResource($etape);
    }

    /**
     * @OA\Delete(
     *     path="/api/etapes/{id}",
     *     tags={"Etape"},
     * security={{"sanctum": {}}},
     *     summary="Delete etape species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the etape species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Delete etape species by ID"),
     *     @OA\Response(response="404", description="Etape species not found"),
     * )
     */

    public function destroy($id)
    {
        $etape = Etape::findOrFail($id);
        $etape->delete();
        return new EtapeResource($etape);
    }
}
