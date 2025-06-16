<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointDePassage;
use App\Http\Resources\PointDePassageResource;
use Illuminate\Support\Facades\Validator;

class PointDePassageController extends Controller
{
    // 'nom',
    // 'latitude_deg_min_sec',
    // 'latitude_deg_dec',
    // 'longitude_deg_min_sec',
    // 'longitude_deg_dec',
    // 'description',
    // 'zone_id',

    /**
     * @OA\Get(
     *     path="/api/point_de_passages",
     *     tags={"PointDePassage"},
     *     security={{"sanctum": {}}},
     *     summary="List all point_de_passages",
     *     @OA\Response(response="200", description="List all point_de_passages"),
     * )
     */
    public function index()
    {
        $point_de_passages = PointDePassage::all();
        return PointDePassageResource::collection($point_de_passages);
    }

    /**
     * @OA\Post(
     *     path="/api/point_de_passages",
     *     tags={"PointDePassage"},
     * security={{"sanctum": {}}},
     *     summary="Create a new point_de_passage",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PointDePassage"),
     *     ),
     *     @OA\Response(response="201", description="Create a new point_de_passage"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'string',
            'latitude_deg_min_sec' => 'string',
            'latitude_deg_dec' => 'string',
            'longitude_deg_min_sec' => 'string',
            'longitude_deg_dec' => 'string',
            'description' => 'string',
            'zone_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $point_de_passage = PointDePassage::create($request->all());
        return new PointDePassageResource($point_de_passage);
    }

    /**
     * @OA\Get(
     *     path="/api/point_de_passages/{id}",
     *     tags={"PointDePassage"},
     *     security={{"sanctum": {}}},
     *     summary="Show point_de_passage by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the point_de_passage",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show point_de_passage by ID"),
     * )
     */

    public function show($id)
    {
        $point_de_passage = PointDePassage::find($id);
        if ($point_de_passage) {
            return new PointDePassageResource($point_de_passage);
        } else {
            return response()->json(['message' => 'PointDePassage not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/point_de_passages/{id}",
     *     tags={"PointDePassage"},
     *     security={{"sanctum": {}}},
     *     summary="Update point_de_passage by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the point_de_passage",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PointDePassage"),
     *     ),
     *     @OA\Response(response="200", description="Update point_de_passage by ID"),
     * )
     */
    public function update(Request $request, $id)
    {
        $point_de_passage = PointDePassage::find($id);
        if ($point_de_passage) {
            $point_de_passage->update($request->all());
            return new PointDePassageResource($point_de_passage);
        } else {
            return response()->json(['message' => 'PointDePassage not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/point_de_passages/{id}",
     *     tags={"PointDePassage"},
     *     security={{"sanctum": {}}},
     *     summary="Delete point_de_passage by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the point_de_passage",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Delete point_de_passage by ID"),
     * )
     */
    public function destroy($id)
    {
        $point_de_passage = PointDePassage::find($id);
        if ($point_de_passage) {
            $point_de_passage->delete();
            return new PointDePassageResource($point_de_passage);
        } else {
            return response()->json(['message' => 'PointDePassage not found'], 404);
        }
    }
}
