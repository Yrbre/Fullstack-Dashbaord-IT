<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
            $this->logFormError($e);
        });
    }

    /**
     * Convert a validation exception into a response (web redirect).
     * Override untuk menangkap validation errors dan log ke custom error.log.
     */
    protected function invalid($request, ValidationException $exception)
    {
        $this->logFormError($exception);

        return parent::invalid($request, $exception);
    }

    /**
     * Log data form input dan error detail ke custom channel 'form_error'.
     */
    protected function logFormError(Throwable $e): void
    {
        $request = request();

        if (!$request) {
            return;
        }

        // Hanya log jika request adalah form submission (POST, PUT, PATCH)
        if (!in_array(strtoupper($request->method()), ['POST', 'PUT', 'PATCH'])) {
            return;
        }

        // Sembunyikan data sensitif
        $inputData = $request->except([
            'password',
            'password_confirmation',
            'current_password',
            '_token',
            '_method',
        ]);

        $logData = [
            'timestamp'  => now()->toDateTimeString(),
            'url'        => $request->fullUrl(),
            'method'     => $request->method(),
            'route'      => $request->route()?->getName() ?? $request->path(),
            'user_id'    => $request->user()?->id ?? 'guest',
            'user_name'  => $request->user()?->name ?? 'guest',
            'ip'         => $request->ip(),
            'input_data' => $inputData,
            'error_type' => class_basename($e),
            'error'      => $e->getMessage(),
            'file'       => $e->getFile(),
            'line'       => $e->getLine(),
        ];

        // Jika validation error, tambahkan detail validation errors
        if ($e instanceof ValidationException) {
            $logData['validation_errors'] = $e->errors();
        }

        Log::channel('form_error')->error('FORM ERROR: ' . class_basename($e), $logData);
    }
}
