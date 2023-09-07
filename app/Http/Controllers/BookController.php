<?php

namespace App\Http\Controllers;

use App\Http\Validators\Valid;
use App\Models\Book;
use App\Models\BookImage;
use App\Models\BookPortableDocFormat;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BookController extends Controller
{

    public function getAll(): JsonResponse
    {
        $books = Book::paginate();

        return response()->json($books, 200, ["Content-Type" => "application/json"]);
    }

    public function getById($id): JsonResponse
    {
        $book =  Book::find($id);
        if (empty($book)) throw new NotFoundHttpException();

        return response()->json($book, 200, ["Content-Type" => "application/json"]);
    }

    public function getByUserId($id): JsonResponse
    {

        $books = Book::where('user', '=', $id)->paginate();

        return response()->json($books, 200, ["Content-Type" => "application/json"]);
    }

    public function getByCategoryId($id): JsonResponse
    {

        $books = Book::where('category', '=', $id)->paginate();

        return response()->json($books, 200, ["Content-Type" => "application/json"]);
    }


    public function store(Request $request): JsonResponse
    {
        return Valid::store(
            $request,
            [
                'title' => 'required | string | min:3 | max:40',
                'description' => 'required | string | min:10 | max:100',
                'category' => 'required | Numeric',
                'bookImage' => 'required | Numeric',
                'user' => 'required | Numeric',
                'bookPortableDocFormat' => 'required | Numeric',
                'amount' => 'required | Numeric',
            ],
            ["title", "description", "category", "bookImage", "amount", "bookPortableDocFormat", "user"],
            Book::class,
            [BookImage::class, Category::class, BookPortableDocFormat::class, User::class]
        );
    }


    public function updateById($id, Request $request): JsonResponse
    {
        $book =  Book::find($id);
        if (empty($book)) throw new NotFoundHttpException();

        return Valid::updateById(
            $id,
            $request,
            [
                'title' => 'string | min:3 | max:40',
                'description' => 'string | min:10 | max:100',
                'category' => 'Numeric',
                'bookImage' => 'Numeric',
                'amount' => 'Numeric',
                'user' => 'Numeric',
                'bookPortableDocFormat' => 'Numeric'
            ],
            ["title", "description", "category", "bookImage", "amount", "bookPortableDocFormat", "user"],
            Book::class,
            [BookImage::class, Category::class, User::class, BookPortableDocFormat::class]
        );
    }


    public function deleteById($id): JsonResponse
    {
        $book =  Book::find($id);
        if (empty($book)) throw new NotFoundHttpException();

        $book = Book::find($id)->delete();
        return response()->json(["status" => "OK"], 200, ["Content-Type" => "application/json"]);
    }
}
