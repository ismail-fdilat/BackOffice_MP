<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Exception;
use Illuminate\Http\Response;

use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Routing\Exceptions\UrlGenerationException as UrlGenerationException;
use Illuminate\Routing\Exceptions\ValidationException as ValidationException;

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
    public function handleException($request, Exception $exception)
    {
        //  if ($exception instanceof ModelNotFoundException) {
        return response('The specified Model cannot be  found.', 404);
        //}
    }
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (Exception $e, $request) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return response('The specified Model cannot be  found.', 404);
            }
            // if ($e instanceof UrlGenerationException) {
            //     return response(
            //         ['message'=>'unauthenticated. or something else',
            //          'exception'=> $e
            //         ],
            //         401
            //     );
            // }

            // return get_class($e);
        });
    }
}
