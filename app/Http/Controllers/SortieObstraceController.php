<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SortieObstrace;
use App\Http\Resources\SortieObstraceResource;
use Illuminate\Support\Facades\Validator;

class SortieObstraceController extends Controller
{
    // 'plage',
    // 'nbre_observateurs',
    // 'suivi',
    // 'prospection_heure_debut',
    // 'prospection_heure_fin',
    // 'remark',
    // 'type_bateau',
    // 'nom_bateau',
    // 'hauteur_bateau',
    // 'sortie_id',
    // 'weather_report_id',

    /**
     * @OA\Get(
     *     path="/api/sortie_obstrace",
     *     tags={"SortieObstrace"},
     *     security={{"sanctum": {}}},
     *     summary="List all sortie_obstrace species",
     *     @OA\Response(response="200", description="List all sortie_obstrace species"),
     * )
     */
    public function index()
    {
        $sortie_obstrace = SortieObstrace::all();
        return SortieObstraceResource::collection($sortie_obstrace);
    }

    /**
     * @OA\Post(
     *     path="/api/sortie_obstrace",
     *     tags={"SortieObstrace"},
     * security={{"sanctum": {}}},
     *     summary="Create a new sortie_obstrace species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SortieObstrace"),
     *     ),
     *     @OA\Response(response="201", description="Create a new sortie_obstrace species"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plage' => 'string',
            'nbre_observateurs' => 'integer',
            'suivi' => 'string',
            'prospection_heure_debut' => 'string',
            'prospection_heure_fin' => 'string',
            'remark' => 'string',
            'type_bateau' => 'string',
            'nom_bateau' => 'string',
            'hauteur_bateau' => 'string',
            'sortie_id' => 'integer',
            'weather_report_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $sortie_obstrace = SortieObstrace::create($request->all());
        return new SortieObstraceResource($sortie_obstrace);
    }

    /**
     * @OA\Get(
     *     path="/api/sortie_obstrace/{id}",
     *     tags={"SortieObstrace"},
     * security={{"sanctum": {}}},
     *     summary="Show sortie_obstrace species by ID",
     *    @OA\Parameter(
     *        name="id",
     *       in="path",
     *       description="ID of the sortie_obstrace species",
     *      required=true,
     *     @OA\Schema(type="integer")
     * ),
     *    @OA\Response(response="200", description="Show sortie_obstrace species by ID"),
     *   @OA\Response(response="404", description="SortieObstrace species not found"),
     * )
     */
    public function show($id)
    {
        $sortie_obstrace = SortieObstrace::find($id);
        if ($sortie_obstrace == null) {
            return response()->json('SortieObstrace not found', 404);
        }
        return new SortieObstraceResource($sortie_obstrace);
    }

    /**
     * @OA\Put(
     *     path="/api/sortie_obstrace/{id}",
     *     tags={"SortieObstrace"},
     * security={{"sanctum": {}}},
     *     summary="Update sortie_obstrace species by ID",
     *   @OA\Parameter(
     *       name="id",
     *      in="path",
     *     description="ID of the sortie_obstrace species",
     *   required=true,
     * @OA\Schema(type="integer")
     * ),
     *  @OA\RequestBody(
     *     required=true,
     *   @OA\JsonContent(ref="#/components/schemas/SortieObstrace"),
     * ),
     * @OA\Response(response="200", description="Update sortie_obstrace species by ID"),
     * @OA\Response(response="404", description="SortieObstrace species not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $sortie_obstrace = SortieObstrace::find($id);
        if ($sortie_obstrace == null) {
            return response()->json('SortieObstrace not found', 404);
        }
        $sortie_obstrace->update($request->all());
        return new SortieObstraceResource($sortie_obstrace);
    }


    /**
     * @OA\Delete(
     *     path="/api/sortie_obstrace/{id}",
     *     tags={"SortieObstrace"},
     * security={{"sanctum": {}}},
     *     summary="Delete sortie_obstrace species by ID",
     *   @OA\Parameter(
     *       name="id",
     *      in="path",
     *     description="ID of the sortie_obstrace species",
     *   required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(response="200", description="Delete sortie_obstrace species by ID"),
     * @OA\Response(response="404", description="SortieObstrace species not found"),
     * )
     */
    public function destroy($id)
    {
        $sortie_obstrace = SortieObstrace::find($id);
        if ($sortie_obstrace == null) {
            return response()->json('SortieObstrace not found', 404);
        }
        $sortie_obstrace->delete();
        return response()->json(null, 204);
    }
}
