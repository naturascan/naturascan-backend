<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;
use App\Http\Resources\WasteResource;
use Illuminate\Support\Facades\Validator;

class WasteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/wastes",
     *     tags={"Wastes"},
     * security={{"sanctum": {}}},
     *     summary="List all wastes",
     *     @OA\Response(response="200", description="List all wastes"),
     * )
     */
    public function index()
    {
        $wastes = Waste::all();
        return WasteResource::collection($wastes);
    }

    /**
     * @OA\Post(
     *     path="/api/wastes",
     *         tags={"Wastes"},
     * security={{"sanctum": {}}},
     *     summary="Create a new waste",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Waste"),
     *     ),
     *     @OA\Response(response="201", description="Create a new waste"),
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $waste = Waste::create($request->all());
        return new WasteResource($waste);
    }

    /**
     * @OA\Get(
     *     path="/api/wastes/{id}",
     *     tags={"Wastes"},
     * security={{"sanctum": {}}},
     *     summary="Show waste by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the waste",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show waste by ID"),
     *     @OA\Response(response="404", description="Waste not found"),
     * )
     */
    public function show($id)
    {
        $waste = Waste::findOrFail($id);
        return new WasteResource($waste);
    }

    /**
     * @OA\Put(
     *     path="/api/wastes/{id}",
     *     tags={"Wastes"},
     * security={{"sanctum": {}}},
     *     summary="Update waste by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the waste",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Waste"),
     *     ),
     *     @OA\Response(response="200", description="Update waste by ID"),
     *     @OA\Response(response="404", description="Waste not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $waste = Waste::findOrFail($id);
        $waste->update($request->all());
        return new WasteResource($waste);
    }

    /**
     * @OA\Delete(
     *     path="/api/wastes/{id}",
     *     tags={"Wastes"},
     * security={{"sanctum": {}}},
     *     summary="Delete waste by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the waste",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete waste by ID"),
     *     @OA\Response(response="404", description="Waste not found"),
     * )
     */
    public function destroy($id)
    {
        $waste = Waste::findOrFail($id);
        $waste->delete();
        return response()->json(null, 204);
    }
}
