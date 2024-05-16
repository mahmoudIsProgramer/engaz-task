<?php
namespace app\traits;

trait ResponseTrait
{
    /**
     * Send a JSON response.
     *
     * @param mixed $data The data to send.
     * @param int $statusCode The HTTP status code.
     * @return void
     */
    private function sendJsonResponse($data, $statusCode)
    {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Send a successful response.
     *
     * @param mixed $result The result data.
     * @param string $message The success message.
     * @return void
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        $this->sendJsonResponse($response, 200);
    }

    /**
     * Send an error response.
     *
     * @param string $error The error message.
     * @param array $errorMessages Additional error messages.
     * @param int $code The HTTP status code.
     * @return void
     */
    public function sendError($error, $errorMessages = [], $code = 401)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        $this->sendJsonResponse($response, $code);
    }
}
