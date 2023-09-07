<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function auth(Request $request): JsonResponse
    {
        $key = 'hfu58588ywehgddhr8r7488hgrig2996e3rd1w4gydh4h8t85921hdbve33w132as1425sv3dvud09h70jn948bf5s7dbcjnkmzoaolskkdeu6490i92';
        $payload = [
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'iat' => time(),
            'exp' => time() + 604800
        ];


        if (Auth::Attempt(["email" => $request->email, "password" => $request->password])) {

            $token = JWT::encode($payload, $key, 'HS256');

            $user = DB::table('users')->where('email', $request->email)->update(['jwt_token' => $token]);

            return response()->json(["token" => $token], 200, ["Content-Type" => "application/json"]);
        }

        throw new AuthenticationException();
    }


    public function out(Request $request): JsonResponse
    {
        $header = $request->header("authorization");
        $token = explode(" ", $header);

        DB::table('users')
            ->where('jwt_token', end($token))
            ->update(['jwt_token' => "  "]);

        return response()->json(["status" => "OK"], 200, ["Content-Type" => "application/json"]);
    }
}
