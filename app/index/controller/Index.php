<?php

    namespace app\index\controller;

    class Index
    {
        public function index()
        {
            echo 'hello word';
//            获取参数 signature nonce token timestamp
            $nonce  = $_GET['nonce'];
            $token = 'findjoy';
            $timestamp = $_GET['timestamp'];
            $echostr = $_GET['echostr'];
            //形成数组,按字典排序
            $array = array();
            $array =  array($nonce,$timestamp,$token);
            sort($array);
            //拼接成字符串,加密    然后与signature校验
            $str = sha1( implode($array) );
            if( $str == $signature ) {
                echo $echostr;
                exit;
            }
        }
    }