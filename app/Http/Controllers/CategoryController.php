<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Category"},
     *     security={{"sanctum": {}}},
     *     summary="List all category species",
     *     @OA\Response(response="200", description="List all category species"),
     * )
     */
    public function index()
    {
        // $categories = Category::all();
        // get categories that have espece
        $categories = Category::has('especes')->get();
        return CategoryResource::collection($categories);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Category"},
     * security={{"sanctum": {}}},
     *     summary="Create a new category species",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category"),
     *     ),
     *     @OA\Response(response="201", description="Create a new category species"),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category = Category::create($request->all());
        return new CategoryResource($category);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     * security={{"sanctum": {}}},
     *     summary="Show category species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show category species by ID"),
     *     @OA\Response(response="404", description="Category species not found"),
     * )
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return new CategoryResource($category);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     * security={{"sanctum": {}}},
     *     summary="Update category species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category"),
     *     ),
     *     @OA\Response(response="200", description="Update category species by ID"),
     *     @OA\Response(response="404", description="Category species not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return new CategoryResource($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     tags={"Category"},
     * security={{"sanctum": {}}},
     *     summary="Delete category species by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category species",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Delete category species by ID"),
     *     @OA\Response(response="404", description="Category species not found"),
     * )
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
}
