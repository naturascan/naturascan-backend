<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use App\Http\Resources\ZoneResource;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    // 'name',
    // 'nbre_points',

    /**
     * @OA\Get(
     *     path="/api/zones",
     *     tags={"Zone"},
     *     security={{"sanctum": {}}},
     *     summary="List all zones",
     *     @OA\Response(response="200", description="List all zones"),
     * )
     */
    public function index()
    {
        $zones = Zone::all();
        // return 're';
        return ZoneResource::collection($zones);
    }

    /**
     * @OA\Post(
     *     path="/api/zones",
     *     tags={"Zone"},
     * security={{"sanctum": {}}},
     *     summary="Create a new zone",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Zone"),
     *     ),
     *     @OA\Response(response="201", description="Create a new zone"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'nbre_points' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $zone = Zone::create($request->all());
        return new ZoneResource($zone);
    }

    /**
     * @OA\Get(
     *     path="/api/zones/{id}",
     *     tags={"Zone"},
     * security={{"sanctum": {}}},
     *     summary="Show zone by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the zone",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="200", description="Show zone by ID"),
     * )
     */
    public function show($id)

    {
        $zone = Zone::find($id);
        if ($zone) {
            return new ZoneResource($zone);
        } else {
            return response()->json(['error' => 'Zone not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/zones/{id}",
     *     tags={"Zone"},
     * security={{"sanctum": {}}},
     *     summary="Update zone by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the zone",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Zone"),
     *     ),
     *     @OA\Response(response="200", description="Update zone by ID"),
     *     @OA\Response(response="404", description="Zone not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $zone = Zone::find($id);
        if ($zone) {
            $zone->update($request->all());
            return new ZoneResource($zone);
        } else {
            return response()->json(['error' => 'Zone not found'], 404);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/zones/{id}",
     *     tags={"Zone"},
     * security={{"sanctum": {}}},
     *     summary="Delete zone by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the zone",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="204", description="Delete zone by ID"),
     *     @OA\Response(response="404", description="Zone not found"),
     * )
     */

    public function destroy($id)
    {
        $zone = Zone::find($id);
        if ($zone) {
            $zone->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Zone not found'], 404);
        }
    }

}
