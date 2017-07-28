<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./Weixin/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单


//1.获得参数 signature, nonce, token,形成数组，然后按字典序排序
//$signature = $_GET['signature'];
//$nonce     = $_GET['nonce'];
//$timestamp = $_GET['timestamp'];
//$token     = 'ipuxin';
//$arrJoin = array($nonce, $timestamp, $token);
//sort($arrJoin);
////2.拼接成字符串,sha1加密 ，然后与signature进行校验,判断是否来自微信
//$strSha = sha1( implode( $arrJoin ) );
//echo 'out';
//if( $strSha  == $signature){
//    //第一次接入weixin api接口的时候
//    echo  $_GET['echostr'];
//    echo 'ok';
//    exit;
//}

////1.获得参数 signature nonce, token, timestamp echostr
//$nonce     = $_GET['nonce'];
//$token     = 'imooc';
//$timestamp = $_GET['timestamp'];
//$echostr   = $_GET['echostr'];
//$signature = $_GET['signature'];
////形成数组，然后按字典序排序
//$array = array();
//$array = array($nonce, $timestamp, $token);
//sort($array);
////拼接成字符串,sha1加密 ，然后与signature进行校验
//$str = sha1( implode( $array ) );
//if( $str  == $signature && $echostr ){
//    //第一次接入weixin api接口的时候
//    echo  $echostr;
//    exit;
//}