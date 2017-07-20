<?php

    namespace app\admin\controller;

    class Index
    {
        public function index()
        {
            dump(config());  //tp的助手函数config返回应用当前的所有配置
        }
    }  