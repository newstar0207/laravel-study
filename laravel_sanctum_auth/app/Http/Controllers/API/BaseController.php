<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //success response method.
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    // error response method.
    public function sendError($error, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!$errorMessage) {
            $response['data'] = $errorMessage;
        };

        return response()->json($response, $code);
    }
}
