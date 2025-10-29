<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 404 Not Found
        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->view('errors.404', [], 404);
        });

        // Handle 403 Forbidden (Spatie Permission)
        $exceptions->render(function (UnauthorizedException $e) {
            return response()->view('errors.403', [], 403);
        });

        // Handle 403 Access Denied
        $exceptions->render(function (AccessDeniedHttpException $e) {
            return response()->view('errors.403', [], 403);
        });

        // Handle 401 Unauthorized
        $exceptions->render(function (AuthenticationException $e) {
            return response()->view('errors.401', [], 401);
        });
    })->create();
