<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function restResponse($oResponse, $body = null)
    {
        return response()->json(
            array("header" => $oResponse->getHeader(), "body" => $body)
        );
    }

    protected function restResponseArray($oResponse, $body = null)
    {
        return array("header" => $oResponse->getHeader(), "body" => $body);
        
    }
}
