<?php

    namespace app\index\controller;

    class Index
    {
        public function index()
        {
            $filename = '1.php.html';
            $res = strtolower(pathinfo($filename,PATHINFO_EXTENSION));//pathinfo_extension返回拓展
            return $res;
        }
    }