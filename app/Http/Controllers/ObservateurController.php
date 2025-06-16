<?php

namespace App\Http\Controllers;

use App\Models\Observateur;
use Illuminate\Http\Request;
use App\Http\Resources\ObservateurResource;
use Illuminate\Support\Facades\Validator;

class ObservateurController extends Controller
{
    // modele observateur controller with swagger documentation

    /**
     * @OA\Get(
     *     path="/api/observateurs",
     *     tags={"Observateur"},
     *     security={{"sanctum": {}}},
     *     summary="List all observateurs",
     *     @OA\Response(response="200", description="List all observateurs"),
     * )
     */
    public function index()
    {
        $observateurs = Observateur::all();
        return ObservateurResource::collection($observateurs);
    }

    /**
     * @OA\Post(
     *     path="/api/observateurs",
     *     tags={"Observateur"},
     * security={{"sanctum": {}}},
     *     summary="Create a new observateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Observateur"),
     *     ),
     *     @OA\Response(response="201", description="Create a new observateur"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'string',
            'prenom' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $observateur = Observateur::create($request->all());
        return new ObservateurResource($observateur);
    }

    /**
     * @OA\Get(
     *     path="/api/observateurs/{id}",
     *     tags={"Observateur"},
     *     security={{"sanctum": {}}},
     *     summary="Display a specific observateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of observateur to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Display a specific observateur"),
     * )
     */
    public function show($id)
    {
        $observateur = Observateur::findOrFail($id);
        return new ObservateurResource($observateur);
    }

    /**
     * @OA\Put(
     *     path="/api/observateurs/{id}",
     *     tags={"Observateur"},
     *     security={{"sanctum": {}}},
     *     summary="Update a specific observateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of observateur to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Observateur"),
     *     ),
     *     @OA\Response(response="200", description="Update a specific observateur"),
     * )
     */
    public function update(Request $request, $id)
    {
        $observateur = Observateur::findOrFail($id);
        $observateur->update($request->all());
        return new ObservateurResource($observateur);
    }

    /**
     * @OA\Delete(
     *     path="/api/observateurs/{id}",
     *     tags={"Observateur"},
     *     security={{"sanctum": {}}},
     *     summary="Delete a specific observateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of observateur to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Delete a specific observateur"),
     * )
     */
    public function destroy($id)
    {
        $observateur = Observateur::findOrFail($id);
        $observateur->delete();
        return new ObservateurResource($observateur);
    }

    
}
