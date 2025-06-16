<?php

namespace App\Http\Controllers;

use App\Models\WeatherReport;
use Illuminate\Http\Request;
use App\Http\Resources\WeatherReportResource;
use Illuminate\Support\Facades\Validator;

class WeatherReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/weather-reports",
     *     tags={"WeatherReports"},
     * security={{"sanctum": {}}},
     *     summary="List all weather reports",
     *     @OA\Response(response="200", description="List all weather reports"),
     * )
     */
    public function index()
    {
        $weatherReports = WeatherReport::all();
        return WeatherReportResource::collection($weatherReports);
    }

    /**
     * @OA\Post(
     *     path="/api/weather-reports",
     *     tags={"WeatherReports"},
     * security={{"sanctum": {}}},
     *     summary="Create a new weather report",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WeatherReport"),
     *     ),
     *     @OA\Response(response="201", description="Create a new weather report"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sea_state' => 'string',
            'cloud_cover' => 'string',
            'visibility' => 'string',
            'wind_force' => 'string',
            'wind_direction' => 'string',
            'wind_speed' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $report = WeatherReport::create($request->all());
        return new WeatherReportResource($report);
    }

    /**
     * @OA\Get(
     *     path="/api/weather-reports/{id}",
     *     tags={"WeatherReports"},
     * security={{"sanctum": {}}},
     *     summary="Show weather report by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weather report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show weather report by ID"),
     *     @OA\Response(response="404", description="Weather report not found"),
     * )
     */
    public function show($id)
    {
        $report = WeatherReport::findOrFail($id);
        return new WeatherReportResource($report);
    }

    /**
     * @OA\Put(
     *     path="/api/weather-reports/{id}",
     *     tags={"WeatherReports"},
     * security={{"sanctum": {}}},
     *     summary="Update weather report by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weather report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WeatherReport"),
     *     ),
     *     @OA\Response(response="200", description="Update weather report by ID"),
     *     @OA\Response(response="404", description="Weather report not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $report = WeatherReport::findOrFail($id);
        $report->update($request->all());
        return new WeatherReportResource($report);
    }

    /**
     * @OA\Delete(
     *     path="/api/weather-reports/{id}",
     *     tags={"WeatherReports"},
     * security={{"sanctum": {}}},
     *     summary="Delete weather report by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weather report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete weather report by ID"),
     *     @OA\Response(response="404", description="Weather report not found"),
     * )
     */
    public function destroy($id)
    {
        $report = WeatherReport::findOrFail($id);
        $report->delete();
        return response()->json(null, 204);
    }
}