<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//引用路由
use think\Route;
//get

Route::get('test','api/test/index');
Route::put('test/:id','api/test/update');

Route::resource('test','api/test');

//第二个参数模api是模块 cat 控制器 read方法

//有时候我们开发的时候可能会遇到版本升级的情况我们可以根据栏目来创建不同的目录比如v1目录下的cat目录版本如果我们版本升级我们在建一个版本v2版本利于维护
//http://localhost/public/index.php/api/v1/cat get方式获取
Route::get('api/:ver/cat','api/:ver.cat/read');

//新闻搜索 http://localhost/public/index.php/api/v1/news?title=海塑
//文章详情页 http://localhost/public/index.php/api/v1/news/1 要传个id
//新闻列表页 http://localhost/public/index.php/api/v1/news?catid=2

Route::resource('api/:ver/news','api/:ver.news');

 //首页头图 http://localhost/public/index.php/api/v1/index  get方式
Route::get('api/:ver/index','api/:ver.index/index');


//版本控制 http://localhost/public/index.php/api/v1/init

Route::get('api/:ver/init','api/:ver.index/init');


//推荐排行
//http://localhost/public/index.php/api/v1/rank get方式
Route::get('api/:ver/rank','api/:ver.rank/index');

//短信验证码路由

Route::resource('api/:ver/identify','api/:ver.identify');


//验证码发送 http://localhost/public/index.php/api/v1/Identify body id 手机号18634084350

//验证码手机号登陆http://localhost/public/index.php/api/v1/login  body phone 手机号18634084350 code 发送手机的四个数
//登陆路由

//用户手机号密码方式登录系统 http://localhost/public/index.php/api/v1/login body 写 phone 18634084350 password wa2527099 在login中已经做了判断
Route::post('api/:ver/login','api/:ver.login/save');

//

//用户信息敏感加密处理http://localhost/public/index.php/api/v1/user/1 put 方式请求有传一个id随便取

//用户更改个人中心信息http://localhost/public/index.php/api/v1/user/2 id随便写 body 要传输你更改的用户名、密码图片地址、postman
Route::resource('api/:ver/user','api/:ver.user');

//图片上传

//http://localhost/public/index.php/api/v1/image body里面传 图片文件如果是postman改成file形式然后 取消header不能保存有content类型要不获取不到数据
Route::post('api/:ver/image','api/:ver.image/save');

//点赞

//http://localhost/public/index.php/api/v1/upvote 传递新闻的id 1 然后点赞
Route::post('api/:ver/upvote','api/:ver.upvote/save');

//取消点赞
Route::delete('api/:ver/upvote','api/:ver.upvote/delete');


//查询文章是不是被点赞了
Route::get('api/:ver/upvote/:id','api/:ver.upvote/read');

//评论接口
Route::post('api/:ver/comment','api/:ver.comment/save');

//评论列表关联表查询 //http://localhost/public/index.php/api/v1/comment/7 get请求

//http://localhost/public/index.php/api/v1/comment/7 7号新闻有哪些用户评论了它的头像是什么内容是什么
Route::get('api/:ver/comment/:id','api/:ver.comment/read');


