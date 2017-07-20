<?php

    namespace app\index\controller;

    use \think\Config;
    use \think\Env;
    class Index
    {
        public function index()
        {
//            dump($_ENV);
            $res = Env::get('email');
            dump($res);
        }
    }