<?php

    namespace app\index\controller;
    use app\index\Model\User;//引入类
//    use think\Loader;

    class Index
    {
        public function index()
        {
            $res = User::get(1);      //通过继承的方法查询数据库,引入类,建议使用

//            $user = new User;
//            $res = $user::get(3);

            #loader方式,引入Loader
//            $user = Loader::model('User');
//            $res = $user::get(4);

            #助手函数
//            $user = model('User');
//            $res = $user::get(6);


            $res = $res->toArray();
            var_dump($res);
        }
    }