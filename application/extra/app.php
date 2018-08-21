<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/10
 * Time: 21:52
 */

return [

    'password_pre_halt' =>'_#sing_ty', //密码加密盐水

    'aeskey' => 'sgg45747ss223455',//加密定义密钥AES加解密 服务端和客户端必须保持一致。

    'apptypes' =>[
        'ios',
        'android',
    ],
    'app_sign_time' => 10000000,
    'app_sign_cachetime' => 200,

];