<?php

namespace App\Traits;

/**
 * Response Trait
 */
trait ResponseTrait
{
  private $successStatus = true;
  private $failedStatus = false;

  /**
     * Success Response
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = [], $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => $this->successStatus,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Failure Response (Client Errors)
     *
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedResponse($message = 'Failed', $errors = [], $status = 400)
    {
        return response()->json([
            'status' => $this->failedStatus,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }



  /**
     * Error Response (Server Errors)
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = 'Something went wrong', $status = 500)
    {
        return response()->json([
            'status' => $this->failedStatus,
            'message' => $message
        ], $status);
    }
}
