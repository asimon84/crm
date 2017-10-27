<?php

namespace App\Portal\Response;

/**
 * Class Response
 *
 * This class handles a generic response format
 *
 * @package App\Portal\Response
 */
class Response
{
    /**
     * Format Response
     *
     * Format a generic response array, including success, response code, message, and data array
     *
     * @param bool $success
     * @param int $code
     * @param string $message
     * @param array $data
     * @return array
     */
    public static function formatResponse( bool $success = false, int $code = 500, string $message = '', array $data = [] ) :array
    {
        $response = [];

        $response['success'] = $success;
        $response['code'] = $code;
        $response['message'] = $message;
        $response['data'] = $data;

        return $response;
    }
}