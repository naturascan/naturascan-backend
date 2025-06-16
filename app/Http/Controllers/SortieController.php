<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sortie;
use App\Http\Resources\SortieResource;
use Illuminate\Support\Facades\Validator;

class SortieController extends Controller
{
    // 'type',
    // 'finished',
    // 'synchronised',
    // 'user_id',

    /**
     * @OA\Get(
     *     path="/api/sorties",
     *     tags={"Sortie"},
     *     security={{"sanctum": {}}},
     *     summary="List all sorties",
     *     @OA\Response(response="200", description="List all sorties"),
     * )
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $sorties = Sortie::where('user_id', $user_id)->get();
        return SortieResource::collection($sorties);
    }

    /**
     * @OA\Post(
     *     path="/api/sorties",
     *     tags={"Sortie"},
     * security={{"sanctum": {}}},
     *     summary="Create a new sortie",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Sortie"),
     *     ),
     *     @OA\Response(response="201", description="Create a new sortie"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'string',
            'finished' => 'boolean',
            'synchronised' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_id = auth()->user()->id;
        $request->merge(['user_id' => $user_id]);
        $sortie = Sortie::create($request->all());
        return new SortieResource($sortie);
    }

    /**
     * @OA\Get(
     *     path="/api/sorties/{id}",
     *     tags={"Sortie"},
     * security={{"sanctum": {}}},
     *     summary="Show sortie by ID",
     *     @OA\Response(response="200", description="Show sortie by ID"),
     * )
     */
    public function show($id)
    {
        $sortie = Sortie::findOrFail($id);
        return new SortieResource($sortie);
    }

    /**
     * @OA\Put(
     *     path="/api/sorties/{id}",
     *     tags={"Sortie"},
     * security={{"sanctum": {}}},
     *     summary="Update sortie by ID",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Sortie"),
     *     ),
     *     @OA\Response(response="200", description="Update sortie by ID"),
     * )
     */
    public function update(Request $request, $id)
    {
        $sortie = Sortie::findOrFail($id);
        $sortie->update($request->all());
        return new SortieResource($sortie);
    }

    /**
     * @OA\Delete(
     *     path="/api/sorties/{id}",
     *     tags={"Sortie"},
     * security={{"sanctum": {}}},
     *     summary="Delete sortie by ID",
     *     @OA\Response(response="200", description="Delete sortie by ID"),
     * )
     */

    public function destroy($id)
    {
        $sortie = Sortie::findOrFail($id);
        $sortie->delete();
        return response()->json(null, 204);
    }
}
