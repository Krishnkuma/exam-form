<?php

use App\Http\Middleware\CheckToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware as MiddlewareConfigurator;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (MiddlewareConfigurator $middleware) {
        // ✅ Define middleware alias for route use
        $middleware->alias([
            'check.token' => CheckToken::class,
        ]);

        // Optional: Add it globally to 'web' group
        // $middleware->appendToGroup('web', [ CheckToken::class ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // (you can leave this empty or add custom exception handling)
    })
    ->create();
