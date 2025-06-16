<?php

namespace App\Http\Controllers;

use App\Models\Espece;
use Illuminate\Http\Request;
use App\Http\Resources\EspeceResource;
use Illuminate\Support\Facades\Validator;

class EspeceController extends Controller
{
    // modele espece controller with swagger documentation
    /**
     * @OA\Get(
     *     path="/api/especes",
     *     tags={"Espece"},
     *     security={{"sanctum": {}}},
     *     summary="List all espece species",
     *     @OA\Response(response="200", description="List all espece species"),
     * )
     */
    public function index()
    {
        $especes = Espece::all();
        return EspeceResource::collection($especes);
    }

    /**
     * @OA\Post(
     *     path="/api/especes",
     *     tags={"Espece"},
     * security={{"sanctum": {}}},
     *     summary="Create a new espece species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Espece"),
     *     ),
     *     @OA\Response(response="201", description="Create a new espece species"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'common_name' => 'string',
            'scientific_name' => 'string',
            'description' => 'string',
            'category_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $espece = Espece::create($request->all());
        return new EspeceResource($espece);
    }

    /**
     * @OA\Get(
     *     path="/api/especes/{id}",
     *     tags={"Espece"},
     * security={{"sanctum": {}}},
     *     summary="Show espece species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the espece species",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="Show espece species by ID"),
     * )
     */
    public function show($id)
    {
        $espece = Espece::findOrFail($id);
        return new EspeceResource($espece);
    }

    /**
     * @OA\Put(
     *     path="/api/especes/{id}",
     *     tags={"Espece"},
     * security={{"sanctum": {}}},
     *     summary="Update espece species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the espece species",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Espece"),
     *     ),
     *     @OA\Response(response="200", description="Update espece species by ID"),
     * )
     */
    public function update(Request $request, $id)
    {
        $espece = Espece::findOrFail($id);
        $espece->update($request->all());
        return new EspeceResource($espece);
    }

    /**
     * @OA\Delete(
     *     path="/api/especes/{id}",
     *     tags={"Espece"},
     * security={{"sanctum": {}}},
     *     summary="Delete espece species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the espece species",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="Delete espece species by ID"),
     * )
     */

    public function destroy($id)
    {
        $espece = Espece::findOrFail($id);
        $espece->delete();
        return response()->json(null, 204);
    }
}
