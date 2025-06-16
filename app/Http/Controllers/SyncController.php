<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SyncController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/sync",
     *     tags={"Sync"},
     *     security={{"sanctum": {}}},
     *     summary="Sync data", 
    *      @OA\RequestBody(
     *         description="Sortie",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", example="data"),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Sync data"),
     * )
     */
    public function sync(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        return response()->json(['message' => 'Synchronisation effectué'], 200);

    }




 
}
