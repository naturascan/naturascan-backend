<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SortieNaturascan;
use App\Http\Resources\SortieNaturascanResource;
use Illuminate\Support\Facades\Validator;

class SortieNaturascanController extends Controller
{
    // 'structure',
    // 'port_depart',
    // 'port_arrivee',
    // 'heure_depart_port',
    // 'heure_arrivee_port',
    // 'duree_sortie',
    // 'nbre_observateurs',
    // 'type_bateau',
    // 'nom_bateau',
    // 'hauteur_bateau',
    // 'heure_utc',
    // 'distance_parcourue',
    // 'superficie_echantillonnee',
    //  'remarque_depart',
    //  'remarque_arrivee',
    //  'sortie_id',
    //  'departure_weather_report_id',
    //  'arrival_weather_report_id',

    /**
     * @OA\Get(
     *     path="/api/sortie_naturascan",
     *     tags={"SortieNaturascan"},
     *     security={{"sanctum": {}}},
     *     summary="List all sortie_naturascan species",
     *     @OA\Response(response="200", description="List all sortie_naturascan species"),
     * )
     */

    public function index()
    {
        $sortie_naturascan = SortieNaturascan::all();
        return SortieNaturascanResource::collection($sortie_naturascan);
    }

    /**
     * @OA\Post(
     *     path="/api/sortie_naturascan",
     *     tags={"SortieNaturascan"},
     * security={{"sanctum": {}}},
     *     summary="Create a new sortie_naturascan species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SortieNaturascan"),
     *     ),
     *     @OA\Response(response="201", description="Create a new sortie_naturascan species"),
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'structure' => 'string',
            'port_depart' => 'string',
            'port_arrivee' => 'string',
            'heure_depart_port' => 'string',
            'heure_arrivee_port' => 'string',
            'duree_sortie' => 'string',
            'nbre_observateurs' => 'integer',
            'type_bateau' => 'string',
            'nom_bateau' => 'string',
            'hauteur_bateau' => 'string',
            'heure_utc' => 'string',
            'distance_parcourue' => 'string',
            'superficie_echantillonnee' => 'string',
            'remarque_depart' => 'string',
            'remarque_arrivee' => 'string',
            'sortie_id' => 'integer',
            'departure_weather_report_id' => 'integer',
            'arrival_weather_report_id' => 'integer',
            'zone_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $sortie_naturascan = SortieNaturascan::create($request->all());
        return new SortieNaturascanResource($sortie_naturascan);
    }

    /**
     * @OA\Get(
     *     path="/api/sortie_naturascan/{id}",
     *     tags={"SortieNaturascan"},
     *     security={{"sanctum": {}}},
     *     summary="Show sortie_naturascan species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sortie_naturascan species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show sortie_naturascan species by ID"),
     *     @OA\Response(response="404", description="SortieNaturascan species not found"),
     * )
     */
    public function show($id)
    {
        $sortie_naturascan = SortieNaturascan::find($id);
        if ($sortie_naturascan) {
            return new SortieNaturascanResource($sortie_naturascan);
        } else {
            return response()->json(['message' => 'SortieNaturascan species not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/sortie_naturascan/{id}",
     *     tags={"SortieNaturascan"},
     *     security={{"sanctum": {}}},
     *     summary="Update sortie_naturascan species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sortie_naturascan species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SortieNaturascan"),
     *     ),
     *     @OA\Response(response="200", description="Update sortie_naturascan species by ID"),
     *     @OA\Response(response="404", description="SortieNaturascan species not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $sortie_naturascan = SortieNaturascan::findOrFail($id);
        $sortie_naturascan->update($request->all());
        return new SortieNaturascanResource($sortie_naturascan);
    }

    /**
     * @OA\Delete(
     *     path="/api/sortie_naturascan/{id}",
     *     tags={"SortieNaturascan"},
     *     security={{"sanctum": {}}},
     *     summary="Delete sortie_naturascan species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sortie_naturascan species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete sortie_naturascan species by ID"),
     *     @OA\Response(response="404", description="SortieNaturascan species not found"),
     * )
     */

    public function destroy($id)
    {
        $sortie_naturascan = SortieNaturascan::findOrFail($id);
        $sortie_naturascan->delete();
        return response()->json(null, 204);
    }
}
