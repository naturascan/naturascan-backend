<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Observation;
use App\Http\Resources\ObservationResource;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
{
    // 'type',
    // 'sortie_id' ,
    // 'animal_id',
    // 'bird_id',  
    // 'waste_id',


    /**
     * @OA\Get(
     *     path="/api/observations",
     *     tags={"Observation"},
     *     security={{"sanctum": {}}},
     *     summary="List all observation species",
     *     @OA\Response(response="200", description="List all observation species"),
     * )
     */
    public function index()
    {
        $observations = Observation::all();
        return ObservationResource::collection($observations);
    }

    /**
     * @OA\Post(
     *     path="/api/observations",
     *     tags={"Observation"},
     * security={{"sanctum": {}}},
     *     summary="Create a new observation species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Observation"),
     *     ),
     *     @OA\Response(response="201", description="Create a new observation species"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'string',
            'sortie_id' => 'integer',
            'animal_id' => 'integer',
            'bird_id' => 'integer',
            'waste_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $observation = Observation::create($request->all());
        return new ObservationResource($observation);
    }

    /**
     * @OA\Get(
     *     path="/api/observations/{id}",
     *     tags={"Observation"},
     * security={{"sanctum": {}}},
     *     summary="Show observation species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the observation species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show observation species by ID"),
     * )
     */
    public function show($id)
    {
        $observation = Observation::find($id);
        if ($observation) {
            return new ObservationResource($observation);
        } else {
            return response()->json(['message' => 'Observation species not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/observations/{id}",
     *     tags={"Observation"},
     * security={{"sanctum": {}}},
     *     summary="Update observation species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the observation species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Observation"),
     *     ),
     *     @OA\Response(response="200", description="Update observation species by ID"),
     *     @OA\Response(response="404", description="Observation species not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $observation = Observation::find($id);
        if ($observation) {
            $observation->update($request->all());
            return new ObservationResource($observation);
        } else {
            return response()->json(['message' => 'Observation species not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/observations/{id}",
     *     tags={"Observation"},
     * security={{"sanctum": {}}},
     *     summary="Delete observation species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the observation species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete observation species by ID"),
     *     @OA\Response(response="404", description="Observation species not found"),
     * )
     */
    public function destroy($id)
    {
        $observation = Observation::find($id);
        if ($observation) {
            $observation->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Observation species not found'], 404);
        }
    }
}
