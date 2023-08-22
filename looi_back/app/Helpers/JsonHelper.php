<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class JsonHelper
{
    /**
     * Api JSON SUCCESS response
     *
     * @return void
     */
    public static function success(array $data = [], int $status = Response::HTTP_OK): JsonResponse
    {
        $dataDefault = ['success' => true];

        return response()->json(array_merge($dataDefault, $data), $status);
    }

    /**
     * Api JSON FAIL response
     *
     * @param  int  $status
     * @param  string  $channel
     * @return void
     */
    public static function error(Exception $e, $status = null, string $customMessage = '', string $channel = null): JsonResponse
    {
        $message = $e->getMessage();
        if ($e instanceof RequestException) {
            $response = $e->response->json();
            $message = $response['title'] ?? json_encode($response);
        }

        $status = self::getStatus($e, $status);

        // add validations error to message response
        if ($e instanceof ValidationException) {
            $message .= $e->validator->errors();
        }
        $data = [
            'success' => false,
            'message' => empty($customMessage) ? "An error has occurred. {$message}" : $customMessage,
        ];
        if (config('app.debug')) {
            $data['exception'] = $message;
            $data['exception_type'] = get_class($e);
            $data['authenticated'] = optional(auth())->user();
            $data['code_error'] = $e->getCode();
            if ($e instanceof NotFoundHttpException && $data['code_error'] === 0) {
                $data['code_error'] = Response::HTTP_NOT_FOUND;
                $status = Response::HTTP_NOT_FOUND;
            }
            $data['request'] = request()->all();
            $data['url'] = request()->fullUrl();
            if ($e instanceof ValidationException) {
                $data['validation_errors'] = $e->validator->errors();
            }
        }

        return response()->json($data, $status);
    }

    private static function getStatus(Exception $e, int $status = null): int
    {
        if (! is_null($status)) {
            return $status;
        }
        if ($e instanceof ValidationException) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        if (is_null($status) || ! is_int($e->getCode()) || $e->getCode() < Response::HTTP_CONTINUE || $e->getCode() > Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED) {
            return Response::HTTP_BAD_REQUEST;
        }

        return $status;
    }

    public static function errorInfo(array $data = [], int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $dataDefault = ['success' => false];

        return response()->json(array_merge($dataDefault, $data), $status);
    }
}
