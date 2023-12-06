<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

//    public function render($request, Throwable $e)
//    {
//        if ($this->isHttpException($e)) {
//            if ($e->getStatusCode() == 404) {
////                return Redirect::route('/')->with('error', '페이지를 찾을 수 없습니다.');
//                return redirect('/')->with('error', '페이지를 찾을 수 없습니다.');
//            }
//        }
//
//        return parent::render($request, $e);
//    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
//            return response()->view('errors.404', [], 404);
            return redirect('/')->with('error', '접속량이 많아 일시적인 오류가 발생했습니다.');
        }

        return parent::render($request, $e);
    }
}
