<?php

    namespace app\index\controller;

    use think\Request;

    class Index {
        public function  index(Request $request) {
//            获取浏览器输入框的值
//            dump($request->domain());
//            dump($request->pathinfo());  //包含文件后缀  5.html
//            dump($request->path());//没有文件后缀
////            判断请求类型
//            dump($request->method());//获取请求方式/get/post
//            dump($request->isGet());
//            dump($request->isPost());
//            dump($request->isAjax());
//
////            请求参数
//            dump($request->get());//获取参数数组
//            dump($request->param());//获取参数数组
//            dump($request->post());//获取post参数组
//
//            session('name','hello');
//            dump($request->session());//获取session
//            cookie('email','12345678');
//            dump($request->cookie());
//
//            dump($request->param('type'));
//            dump($request->cookie('email'));
//
////            获取当前的模块 控制器 操作
//            dump($request->module());
//            dump($request->controller());
//            dump($request->action());
//
//            dump($request->url());
//            dump($request->baseUrl());

            $res = input('get.id',100,'intval');  //对应 $request->get('id');  若无返回默认100  第三个参数表示强制过滤:intval表示整形,如果不是返回0
            $res = input('post.id',100); //对应 $request->post('id');  默认100
            dump($res);
            dump($request->post('post.id',100,'intval'));
            dump(input('session.email','若无返回的默认值'));
            echo '<hr>';
            dump($res);

        }
    }