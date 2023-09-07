<?php

namespace App\Http\Controllers;

use App\Http\Validators\Valid;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        return Valid::store(
            $request,
            [
                'name' => 'required | string | min:3 | max:20',
                'email' => 'required | string | min:13 | max:20',
                'password' => 'required | string | min:3 | max:20',
                'role' => [
                    'required',
                    "uppercase",
                    Rule::in(['ADMIN', 'USER']),
                ],
            ],
            ['name', 'email', 'password', "role"],
            User::class,
            []
        );
    }


    public function get(Request $request): JsonResponse
    {
        $header = $request->header("authorization");
        $token = explode(" ", $header);

        $user = User::where('jwt_token', end($token))->get()->first();


        if (empty($user) === false) return response()->json($user, 200, ["Content-Type" => "application/json"]);


        throw new AuthenticationException();
    }
}
