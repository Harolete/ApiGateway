<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponder
{
    /**
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, int $code = Response::HTTP_OK)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    /**
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function validResponse($data, int $code = Response::HTTP_OK)
    {

        return \response()->json(['data' => $data], $code );
    }

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, int $code)
    {
        return \response()->json(['error' => $message, 'code' => $code ], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorMessage(string $message, int $code)
    {
        return \response($message, $code)->header('Content-Type', 'application/json');
    }
}