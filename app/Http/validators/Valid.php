<?php

namespace App\Http\Validators;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Exception;



class Valid
{

    public static function store(Request $request, array $rules, array $response, string $model, array $fk): JsonResponse
    {

        $validator = Facades\Validator::make(
            $request->all(),
            $rules,
            [
                "numeric" => "The :attribute field must be a number"
            ]
        );


        if ($validator->fails()) {
            throw new ValidationException($validator, null);
        } else {


            if (!empty($request->password)) {
                Hash::make($request->password);
            }


            if (!empty($fk)) {

                $x = 0;

                while ($x < count($fk)) {

                    $o = explode("\\", $fk[$x]);
                    $fkm = end($o);
                    $fkm = lcfirst($fkm);

                    if (is_null($request->input($fkm)) === false) {

                        $fko = new $fk[$x];
                        if (is_null($fko::find($request->$fkm))) throw new Exception("Foreign Key {$fkm}  Not Found");
                    }

                    $x++;
                }
            }

            $co =  new $model;
            $co->create($request->all());

            return response()->json(
                ["status" => true, "messages" => $validator->errors(), "payload" => $request->only($response)],
                200,
                ["Content-Type" => "application/json"]
            );
        }
    }


    public static function updateById($id, Request $request, array $rules, array $response, string $model, array $fk): JsonResponse
    {

        $validator = Facades\Validator::make(
            $request->all(),
            $rules,
            [
                "numeric" => "The :attribute field must be a number"
            ]
        );


        if ($validator->fails()) {
            throw new ValidationException($validator, null);
        } else {


            if (!empty($fk)) {

                $x = 0;

                while ($x < count($fk)) {

                    $o = explode("\\", $fk[$x]);
                    $fkm = end($o);
                    $fkm = lcfirst($fkm);

                    if (is_null($request->input($fkm)) === false) {

                        $fko = new $fk[$x];
                        if (is_null($fko::find($request->$fkm))) throw new Exception("Foreign Key {$fkm}  Not Found");
                    }

                    $x++;
                }
            }

            $uo =  new $model;
            $uo->where('id', $id)->update($request->all());
            return response()->json(
                ["status" => true, "messages" => $validator->errors(), "payload" => $request->only($response)],
                200,
                ["Content-Type" => "application/json"]
            );
        }
    }
}
