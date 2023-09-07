<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];



    public function register(): void
    {

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'BAD REQUEST'
                ], 400);
            }
        });


        $this->renderable(function (ValidationException $e) {
            return response()->json([
                'message' => $e->validator->errors()->all()
            ], 403);
        });


        $this->renderable(function (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        });

        $this->renderable(function (AuthenticationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        });
    }
}
