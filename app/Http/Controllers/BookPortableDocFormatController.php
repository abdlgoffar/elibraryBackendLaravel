<?php

namespace App\Http\Controllers;

use App\Models\BookPortableDocFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

use Symfony\Component\HttpFoundation\StreamedResponse;

class BookPortableDocFormatController extends Controller
{
    public function upload(Request $request)
    {

        $validator = Facades\Validator::make(
            $request->all(),
            [
                'pdf' => [
                    'required',
                    // File::image()->min(10)->max(50)->dimensions(Rule::dimensions()->maxWidth(3000)->maxHeight(3000)->minHeight(1000)->minWidth(1000)),
                    FIle::types(['pdf'])
                ]
            ]
        );
        if ($validator->fails()) {
            throw new ValidationException($validator, null);
        }

        $path = 'public/PDF/document/Book';
        $file = $request->file('pdf');
        $name = time() . $file->getClientOriginalName();
        $file->storeAs($path, $name);

        $bookPortableDocFormat =  new BookPortableDocFormat();
        $bookPortableDocFormat->name = $name;
        $bookPortableDocFormat->path = $path;
        $bookPortableDocFormat->save();
        return response()->json(["status" => "OK", "id" => $bookPortableDocFormat->id], 200, ["Content-Type" => "application/json"]);
    }

    public function download($name): StreamedResponse
    {
        $path = 'public/PDF/document/Book';

        return Storage::download($path . "/{$name}", "this is default name", ['Content-Type: application/pdf']);
    }
}
