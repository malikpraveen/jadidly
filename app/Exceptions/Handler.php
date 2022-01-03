<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

// use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use \Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

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
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $guard = Array($exception->guards(), 0);
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'M0048',
                'error' => 'Unauthorized access for this request.',
                'error_code' => 'unauthorized',
                'status_code' => '401'
            ], 401);
        }

        switch ($guard[0][0]) {
            case 'web':{
                if($request->ajax()){
                    return response()->json([
                        'status' => 401,
                        'message' => 'M0048',
                        'error' => 'Unauthorized access for this request.',
                        'error_code' => 'unauthorized',
                        'status_code' => '401'
                    ], 401);
                }
                break;
            }

            case 'api':{
                return response()->json([
                    'status' => false,
                    'message' => 'M0048',
                    'error' => 'Unauthorized access for this request.',
                    'error_code' => 'unauthorized',
                    'status_code' => '401'
                ], 401);
                break;
            }
        }

        return redirect()->guest('login');
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */

    /* api response for QueryException */
    public function render($request, Throwable $exception)
    {   
        if ($request->wantsJson() && $exception instanceof QueryException) {

            return response()->json([
                'status'   => false,
                'status_code' => 500,
                'data'      => [],
                'error'      => $exception->getMessage(),
                'errors'    => new \stdClass(),
                'message'   => 'invalid input'
            ]);
        }
        return parent::render($request, $exception);
    }
}
