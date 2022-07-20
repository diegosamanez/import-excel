<?php

namespace Agregalel\ImportExcel\Exceptions;

use Exception;
use Illuminate\Http\Request;

class ExcelImageException extends Exception
{
    protected $response;
    public function __construct($response = null)
    {
        parent::__construct('Error processing image');
        if(!is_null($response))
        {
            $this->response = $response;
        }
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        return $this->response;
    }

    /**
     * Get the HTTP response status code.
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->response->getStatusCode();
    }
}
