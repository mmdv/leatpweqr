<?php

    namespace app\index\controller;
    use app\index\model\User;

    class Index
    {
        public function index()
        {
//            $res = User::destroy(1);
//            $res = User::destroy(['openid'=>2]);
//            $res = User::destroy(function ($query){
//                $query->where('openid','lt',5);
//            });

//            $userModel = User::get(7);
//            $res = $userModel->delete();

            $res = User::where('openid','<',10) //wherer(1=1) 删除全部数据
                ->delete();
            var_dump($res);
        }
    }