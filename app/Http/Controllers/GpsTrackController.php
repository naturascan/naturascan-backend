<?php

namespace App\Http\Controllers;

use App\Models\GpsTrack;
use Illuminate\Http\Request;
use App\Http\Resources\GpsTrackResource;
use Illuminate\Support\Facades\Validator;

class GpsTrackController extends Controller
{
    // 'longitude',
    // 'latitude',
    // 'timestamp',
    // 'device',
    // 'inObservation',
    // 'sortie_id',

    /**
     * @OA\Get(
     *     path="/api/gps_tracks",
     *     tags={"GpsTrack"},
     *     security={{"sanctum": {}}},
     *     summary="List all gps_track species",
     *     @OA\Response(response="200", description="List all gps_track species"),
     * )
     */
    public function index()
    {
        $gps_tracks = GpsTrack::all();
        return GpsTrackResource::collection($gps_tracks);
    }

    /**
     * @OA\Post(
     *     path="/api/gps_tracks",
     *     tags={"GpsTrack"},
     * security={{"sanctum": {}}},
     *     summary="Create a new gps_track species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GpsTrack"),
     *     ),
     *     @OA\Response(response="201", description="Create a new gps_track species"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'longitude' => 'string',
            'latitude' => 'string',
            'timestamp' => 'string',
            'device' => 'string',
            'inObservation' => 'string',
            'sortie_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $gps_track = GpsTrack::create($request->all());
        return new GpsTrackResource($gps_track);
    }

    /**
     * @OA\Get(
     *     path="/api/gps_tracks/{id}",
     *     tags={"GpsTrack"},
     * security={{"sanctum": {}}},
     *     summary="Show gps_track species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the gps_track species",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Show gps_track species by ID"),
     * )
     */
    public function show($id)
    {
        $gps_track = GpsTrack::findOrFail($id);
        return new GpsTrackResource($gps_track);
    }

    /**
     * @OA\Put(
     *     path="/api/gps_tracks/{id}",
     *     tags={"GpsTrack"},
     * security={{"sanctum": {}}},
     *     summary="Update gps_track species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the gps_track species",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GpsTrack"),
     *     ),
     *     @OA\Response(response="200", description="Update gps_track species by ID"),
     * )
     */
    public function update(Request $request, $id)
    {
        $gps_track = GpsTrack::findOrFail($id);
        $gps_track->update($request->all());
        return new GpsTrackResource($gps_track);
    }

    /**
     * @OA\Delete(
     *     path="/api/gps_tracks/{id}",
     *     tags={"GpsTrack"},
     * security={{"sanctum": {}}},
     *     summary="Delete gps_track species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the gps_track species",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Delete gps_track species by ID"),
     * )
     */
    public function destroy($id)
    {
        $gps_track = GpsTrack::findOrFail($id);
        $gps_track->delete();
        return new GpsTrackResource($gps_track);
    }

}
