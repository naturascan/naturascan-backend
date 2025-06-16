<?php

namespace App\Exceptions;
use App\Notifications\ExceptionNotification;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Mail;
use App\Mail\ExceptionMail;

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
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        // Send email for all exceptions
        $this->sendExceptionEmail($exception);
    }

     /**
     * Send the exception details via email.
     *
     * @param \Throwable $exception
     * @return void
     */
    protected function sendExceptionEmail(Throwable $exception)
    {
       
        // Define your recipient email here
        $email = 'gillesakakpo01@gmail.com';
        Mail::to($email)->send(new ExceptionMail($exception));

            
    }

}
