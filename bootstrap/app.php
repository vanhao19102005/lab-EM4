<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(App\Http\Middleware\AttachRequestId::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->context(fn () => array_filter([
            'request_id' => request()->attributes->get('request_id'),
        ], fn ($value) => $value !== null));

        $exceptions->respond(function (Response $response) {
            $requestId = request()->attributes->get('request_id');

            if ($requestId !== null) {
                $response->headers->set('X-Request-Id', $requestId);
            }

            return $response;
        });
    })->create();
