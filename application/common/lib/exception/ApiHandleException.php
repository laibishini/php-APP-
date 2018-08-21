<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/15
 * Time: 15:17
 */

namespace app\common\lib\exception;


use think\exception\Handle;


/**
 * Class ApiHandleException
 * @package app\common\lib\exception
 * 给客户端返回错误json格式提示信息因为APP客户端有可能识别不了错误提示会导致应用崩溃。
 * 我们重写了render这个错误渲染机制。使用它我们需要配置文件中exception_handle改成我们指定的类如果不改就走指定默认的渲染错误机制
 */
class ApiHandleException extends Handle{

    public $httpCode = 500;

    public function render(\Exception $e)
    {

        //这个是给我们程序员看的如果配置文件里面它的调试模式打开了，并且它等于true那么就使用它父级的渲染错误方法
        if(config('app_debug') == true){
            return parent::render($e);
        }

        //这个是内部输出异常解决方案如果它内部异常是apiException那么我们就把它传过来的数据返回给客户端
        if($e instanceof ApiException){
            $this->httpCode = $e->httpCode;
        }
        return show(0,$e->getMessage(),[],$this->httpCode);
    }

}