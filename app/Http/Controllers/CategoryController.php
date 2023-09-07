<?php

namespace App\Http\Controllers;

use App\Http\Validators\Valid;
use App\Models\Category;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{

    public function getAll(): JsonResponse
    {
        $categories = Category::paginate();
        return response()->json($categories, 200, ["Content-Type" => "application/json"]);
    }

    public function getById($id): JsonResponse
    {
        $category =  Category::find($id);
        if (empty($category)) throw new NotFoundHttpException();

        return response()->json($category, 200, ["Content-Type" => "application/json"]);
    }


    public function store(Request $request): JsonResponse
    {
        return Valid::store(
            $request,
            ['name' => 'required | string | min:3 | max:20'],
            ["name"],
            Category::class,
            []
        );
    }


    public function updateById($id, Request $request): JsonResponse
    {
        $category =  Category::find($id);
        if (empty($category)) throw new NotFoundHttpException();

        return Valid::updateById(
            $id,
            $request,
            ['name' => 'required | string | min:3 | max:20'],
            ["name"],
            Category::class,
            []
        );
    }


    public function deleteById($id): JsonResponse
    {
        $category =  Category::find($id);
        if (empty($category)) throw new NotFoundHttpException();
        $category = Category::find($id)->delete();
        return response()->json(["status" => "OK"], 200, ["Content-Type" => "application/json"]);
    }
}
