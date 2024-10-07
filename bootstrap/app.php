<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $errors = [];
            $validationErrors = $e->errors();

            foreach ($validationErrors as $key => $values) {
                $errors[] = [
                    'error' => 'Validation error',
                    'detail' => implode(' ', $values),
                    'source' => [
                        'parameter' => $key,
                    ],
                ];
            }

            return response()->json(['errors' => $errors], $statusCode);
        });
    })->create();
