<?php

namespace App\Common;

trait CustomResponse{
    /**
     * @param $data
     * @param null $message
     * @param $user
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = null, $user, $code = 200)
    {
        return response()->json([
            'status'=> true,
            'message' => $message,
            'data' => $data,
            'user' => $user,
        ], $code);
    }

    /**
     * @param null $message
     * @param $user
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null, $user,$code)
    {
        return response()->json([
            'status'=> false,
            'message' => $message,
            'data' => null,
            'user' => $user
        ], $code);
    }
}
