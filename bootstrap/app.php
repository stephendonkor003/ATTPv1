<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckPermission;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    // ✅ REGISTER MIDDLEWARE ALIASES HERE (LARAVEL 11)
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'permission' => CheckPermission::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();