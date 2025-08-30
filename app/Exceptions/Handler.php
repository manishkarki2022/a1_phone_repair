<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 404) {
                return response()->view('errors.404', [], 404);
            }
        });

        // You can add more custom error handlers here
        $this->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 500) {
                return response()->view('errors.500', [], 500);
            }
        });
    }
}
