<?php

    namespace app\index\controller;

    use think\Controller;

    class Index extends Controller
    {
        public function  index() {
//            默认模板地址
//            app/index/view/index/index.html
//            若改地址不存在报错
//            传递第一个参数修改模板目录
//            eg:'upload'  app/index/view/index/upload.html
//             eg:'public/upload' app/index/view/public/upload.html
//             eg:'./'开头表示找到入口文件同级开始的模板文件

            /*
             * 第二个参数传递数据*/

            /*
             * 第三个参数页面内替换 类似于Ctrl+H 不推荐这种方式*/
//            return view('index',[
//                'email'=>'123@qq.com',
//                'user'=>'hello'
//            ],[
//                'static'=>'当前是static的替换内容'
//            ]);

//            fetch()第一,二,三个参数和view()相同 ,同时还可以使用$->assign
//             $this->assign('assign','assign');
//            return $this->fetch('index',[
//                'email'=>'12@qq.com',
//                'user'=>'hello'
//            ],[
//                'static'=>'这是全局替换'
//            ]);

            $this->assign('user','usr');
            return $this->display('这是一个{$email}字符串{$user}',[
                'email'=>'22@qq.com'
            ]);//直接字符串替换模板输出
        }
    }