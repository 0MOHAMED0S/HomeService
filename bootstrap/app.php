<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.provider' => \App\Http\Middleware\CheckProvider::class,
            'check.admin' => \App\Http\Middleware\CheckAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                $code = 500;
                $message = 'حدث خطأ غير متوقع.';
                $data = null;

                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    $code = 422;
                    $message = 'يوجد خطأ في البيانات المدخلة.';
                    $data = $e->errors();
                } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    $code = 401;
                    $message = 'غير مصرح لك بالدخول.';
                } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    $code = 404;
                    $message = 'الرابط المطلوب غير موجود.';
                } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    $code = $e->getStatusCode();
                    $message = $e->getMessage() ?: 'حدث خطأ في الطلب.';
                } else {
                    // Include raw error if in debug mode, otherwise generic message
                    $message = env('APP_DEBUG') ? $e->getMessage() : 'حدث خطأ في الخادم.';
                }

                return response()->json([
                    'status' => 'Error',
                    'message' => $message,
                    'data' => $data
                ], $code);
            }
        });
    })->create();
