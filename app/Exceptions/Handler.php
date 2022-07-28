<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    // /**
    //  * Override default method - render the given HttpException.
    //  *
    //  * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
    //  * @return \Symfony\Component\HttpFoundation\Response
    //  */
    // protected function renderHttpException(HttpExceptionInterface $e)
    // {
    //     $status = $e->getStatusCode();
    //     // routeが管理側の時は別のエラー画面を表示
    //     if (preg_match('/admin/', url()->current())) {
    //         return response()->view('admin.errors.common', ['status' => $status], $status);
    //     }
    //     return response()->view('errors.common', ['status' => $status], $status); // viewを指定する
    // }
}
