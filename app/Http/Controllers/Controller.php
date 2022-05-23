<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel Test Documentation",
     *      description="Documentation",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )

     *
     *
     */


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($error, $errorMessages = [], $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = (is_null($errorMessages)) ? "Server Error!" : $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * return unauthorized response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendUnauthorized($error, $errorMessages = [], $code = 401)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = 'Unauthorized';
        }

        return response()->json($response, $code);
    }

    /**
     * return bad request response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendBadRequest($error, $errorMessages = [], $code = 422)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
