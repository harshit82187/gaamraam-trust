<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        \Log::error('Exception caught in render', [
            'exception' => $exception,
            'url' => $request->fullUrl(),
            'input' => $request->all(),
        ]);

        if ($exception instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            return redirect()->back()->with('rate_limit_error', 'आप बहुत बार प्रयास कर चुके हैं। कृपया कुछ समय बाद पुनः प्रयास करें।');
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return response()->view('errors.403', ['message' => $exception->getMessage()], 403);
        }

        if ($request->expectsJson() || $request->is('api/*')) {

            // Handle method not found
            if ($exception instanceof \BadMethodCallException) {
                return response()->json([
                    'status' => false,
                    'message' => 'API method does not exist: ' . $exception->getMessage()
                ], 500);
            }

            // Handle Model not found
            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resource not found.'
                ], 404);
            }

            // Handle unauthorized
            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated (Invalid or missing token).'
                ], 401);
            }

            // Handle any other exception
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

        return parent::render($request, $exception);
    }

}
