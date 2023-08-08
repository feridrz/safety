<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function respondWithToken($token)
    {
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 'Operation successful', 200);
    }

    protected function successResponse($data, $message = '', $code = 200) {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    protected function errorResponse($message, $errors = [], $code = 400) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }


    protected function validateInput($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors(), 422);
        }

        return null; // Return null to indicate validation passed
    }

}
