<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dechet;
use App\Http\Resources\DechetResource;
use Illuminate\Support\Facades\Validator;

class DechetController extends Controller
{
    // 'name',
    

    /**
     * @OA\Get(
     *     path="/api/dechets",
     *     tags={"Dechet"},
     *     security={{"sanctum": {}}},
     *     summary="List all dechets",
     *     @OA\Response(response="200", description="List all dechets"),
     * )
     */
    public function index()
    {
        $dechets = Dechet::all();
        return DechetResource::collection($dechets);
    }

    /**
     * @OA\Post(
     *     path="/api/dechets",
     *     tags={"Dechet"},
     * security={{"sanctum": {}}},
     *     summary="Create a new dechet",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Dechet"),
     *     ),
     *     @OA\Response(response="201", description="Create a new dechet"),
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $dechet = Dechet::create($request->all());
        return new DechetResource($dechet);
    }

    /**
     * @OA\Get(
     *     path="/api/dechets/{id}",
     *     tags={"Dechet"},
     * security={{"sanctum": {}}},
     *     summary="Show dechet by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of dechet to return",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Show dechet by ID"),
     * )
     */

    public function show($id)

    {
        $dechet = Dechet::find($id);
        if ($dechet) {
            return new DechetResource($dechet);
        } else {
            return response()->json(['message' => 'Dechet not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/dechets/{id}",
     *     tags={"Dechet"},
     * security={{"sanctum": {}}},
     *     summary="Update dechet by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of dechet to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Dechet"),
     *     ),
     *     @OA\Response(response="200", description="Update dechet by ID"),
     * )
     */
    public function update(Request $request, $id)
    {
        $dechet = Dechet::findOrFail($id);
        $dechet->update($request->all());
        return new DechetResource($dechet);
    }

    /**
     * @OA\Delete(
     *     path="/api/dechets/{id}",
     *     tags={"Dechet"},
     * security={{"sanctum": {}}},
     *     summary="Delete dechet by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of dechet to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Delete dechet by ID"),
     * )
     */

    public function destroy($id)
    {
        $dechet = Dechet::findOrFail($id);
        $dechet->delete();
        return new DechetResource($dechet);
    }

}
