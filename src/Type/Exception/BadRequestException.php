<?php

namespace App\Type\Exception;

use App;
use Exception;

class BadRequestException extends Exception
{
    /**
     * @var int
     */
    public $statusCode;
    /**
     * @var string
     */
    public $message;
    public  $additionData;

    public function __construct($message, $appErrorCode = 400, $statusCode = 400, $additionData = null)
    {

        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->appErrorCode = $appErrorCode;
        $this->additionData = $additionData;
        parent::__construct($message);
    }
    public function toArray()
    {
        $ret =  [
            "code" => $this->appErrorCode,
            "message" => $this->message,
        ];
        if(!is_null($this->additionData)){
            $ret["data"] = $this->additionData;
        }
        return $ret;
    }
}
