<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/15
 * Time: 15:53
 */

namespace app\common\lib\exception;

use think\Exception;
use Throwable;

class ApiException extends Exception{

    public $message = '';
    public $httpCode = 500;
    public $code = 0; //这个内部状态码

    public function __construct($message = "", $httpCode = 0, $code = 0)
    {
       $this->httpCode = $httpCode;
       $this->message = $message;
       $this->code = $code;
    }
}