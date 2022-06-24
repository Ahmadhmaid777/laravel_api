<?php

namespace App\Exceptions;
use Illuminate\Database\QueryException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json(["errors"=>'incorrect route'],Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (MissingScopeException  $e, $request) {
            return response()->json(["errors"=>'this user can not access this route'],Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (QueryException  $e, $request) {

            if (str_contains($e->getMessage(),'Duplicate entry')){
                return response()->json(["errors"=>"Duplicate unique entry "],Response::HTTP_NOT_FOUND);

            }
        });


        $this->reportable(function (Exception $e) {

        });
    }
}
