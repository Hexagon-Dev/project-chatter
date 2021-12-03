<?php

namespace App\Exceptions;

use Firebase\JWT\BeforeValidException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (BeforeValidException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        });
        $this->renderable(function (RoleDoesNotExist $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        });
        $this->renderable(function (ValidationException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });
        $this->renderable(function (UnprocessableEntityHttpException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });
        $this->renderable(function (ItemNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        });

    }
}
