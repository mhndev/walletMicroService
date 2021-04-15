<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation Error',
                'status' => 422,
                'appErrorCode' => 'Validation_Error'
            ], 422);
        }

        elseif($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Model Not Found',
                'appErrorCode' => 'Model_Not_Found',
                'status' => 404,
            ], 404);
        }

        elseif($e instanceof WalletBalanceCantBeNegativeException) {
            return response()->json([
                'message' => "Wallet balance can't be negative",
                'appErrorCode' => 'WALLET_BALANCE_CANT_BE_NEGATIVE',
                'status' => 400,
            ], 400);
        }

        elseif($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => "Route Not Found",
                'appErrorCode' => 'ROUTE_NOT_FOUND',
                'status' => 404,
            ], 404);
        }

        else {
            dd($e);
            return response()->json([
                'message' => "Server Error",
                'appErrorCode' => 'Server_Error',
                'status' => 500,
            ], 500);
        }

    }
}