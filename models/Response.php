<?php

namespace app\models;

abstract class Response
{
    public static function error($message, $data = null)
    {
        $response = ['status' => 'error', 'message' => $message];
        if($data) {
            $response['data'] = $data;
        }
        return $response;
    }

    public static function success($message = null, $data = null)
    {
        $response = ['status' => 'ok'];
        if($message) {
            $response['message'] = $message;
        }
        if($data || is_array($data)) {
            $response['data'] = $data;
        }
        return $response;
    }

}