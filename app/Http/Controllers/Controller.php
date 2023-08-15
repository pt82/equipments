<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return JsonResponse
     */

    public function sendResponse($result, $message)
    {

        $response = [

            'success' => true,
            'message' => $message,
            'data'    => $result,


        ];

        return response()->json($response, 200);

    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);

    }

    /**
     * @param boolean $result
     * @param $message
     * @return JsonResponse
     */
    public function sendBollean($result, $message = '')
    {
        if($result) {
            $status = 200;
            $response = [
                'success' => true,
                'message' => $message
            ];
        } else
        {
            $status = 400;
            $response = [
            'success' => false,
            'message' => $message
        ];
        }
        return response()->json($response, $status);

    }
}
