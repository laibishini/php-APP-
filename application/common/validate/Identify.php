<?php
namespace app\common\validate;

use think\Validate;

class Identify extends Validate{
    //定义规则

    protected $rule = [

        'id' => 'require|number|length:11',



    ];


}


