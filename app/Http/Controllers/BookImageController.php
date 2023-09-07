<?php

namespace App\Http\Controllers;

use App\Models\BookImage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookImageController extends Controller
{
    public function getById($id): JsonResponse
    {
        $image =  BookImage::find($id);
        if (empty($image)) throw new NotFoundHttpException();

        return response()->json($image, 200, ["Content-Type" => "application/json"]);
    }


    public function upload(Request $request)
    {


        $validator = Facades\Validator::make(
            $request->all(),
            [
                'img' => [
                    'required',
                    // File::image()->min(10)->max(50)->dimensions(Rule::dimensions()->maxWidth(3000)->maxHeight(3000)->minHeight(1000)->minWidth(1000)),
                    FIle::types(['jpeg', 'png'])
                ]
            ]
        );
        if ($validator->fails()) {
            throw new ValidationException($validator, null);
        }

        $path = 'public/Images/Cover/Book';
        $file = $request->file('img');
        $name = time() . $file->getClientOriginalName();
        $file->storeAs($path, $name);

        $bookImage =  new BookImage();
        $bookImage->name = $name;
        $bookImage->path = $path;
        $bookImage->save();
        return response()->json(["status" => "OK", "id" => $bookImage->id], 200, ["Content-Type" => "application/json"]);
    }

    public function download($name): StreamedResponse
    {
        $path = 'public/Images/Cover/Book';

        return Storage::download($path . "/{$name}", "this is default name", ['Content-Type: image/jpeg']);
    }
}
