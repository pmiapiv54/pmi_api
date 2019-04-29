<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;

        if (env('APP_DEBUG')) {

          // return parent::render($request, $e);
          $code = Response::HTTP_INTERNAL_SERVER_ERROR;            
            return response()
            ->json([
                    'response' => [
                        'status' => false,
                        'message' => $e->getMessage(),
                    ],
                    'code' => $code,
                ], 
            $code);
        }else{

          if ($e instanceof HttpResponseException) {
  
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
  
          } elseif ($e instanceof MethodNotAllowedHttpException) {
  
            $code = Response::HTTP_METHOD_NOT_ALLOWED;
            $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);
  
          } elseif ($e instanceof NotFoundHttpException) {
  
            $code = Response::HTTP_NOT_FOUND;
            $e = new NotFoundHttpException('HTTP_NOT_FOUND', $e);
  
          } elseif ($e instanceof AuthorizationException) {
  
            $code = Response::HTTP_FORBIDDEN;
            $e = new AuthorizationException('HTTP_FORBIDDEN', $code);
  
          } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
            
            $code = Response::HTTP_BAD_REQUEST;
            $e = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $code, $e);
  
          } elseif ($e) {
  
            $e = new HttpException($code, 'HTTP_INTERNAL_SERVER_ERROR');
  
          }
  
          return response()
                  ->json([
                          'response' => [
                              'status' => false,
                              'message' => $e->getMessage(),
                          ],
                          'code' => $code,
                      ], 
                  $code);
          
        }        
    }
}
