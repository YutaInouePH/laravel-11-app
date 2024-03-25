<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $exception, Request $request) {
            if ($request->expectsJson()) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;

                if (method_exists($exception, 'getStatusCode')) {
                    $status = $exception->getStatusCode();
                } elseif ($exception instanceof AuthenticationException) {
                    $status = Response::HTTP_UNAUTHORIZED;
                } elseif ($exception instanceof AuthorizationException) {
                    $status = Response::HTTP_FORBIDDEN;
                } elseif ($exception instanceof ModelNotFoundException) {
                    $status = Response::HTTP_NOT_FOUND;
                } elseif ($exception instanceof ValidationException) {
                    $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                }

                if ($status === Response::HTTP_UNPROCESSABLE_ENTITY) {
                    // 422 だけ特別。FormRequestでのレスポンスとフォーマットを合わせる。
                    return response()->json([
                        'errors' => $exception->errors(), /** @phpstan-ignore-line */
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $response_json = [
                    'message' => "{$exception->getMessage()}",
                ];

                if (! app()->environment('production')) {
                    $response_json['stacktrace'] = $exception->getTraceAsString();
                }

                return response()->json(
                    $response_json,
                    $status
                );
            }
        });
    })->create();
