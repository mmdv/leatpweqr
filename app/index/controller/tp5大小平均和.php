<?php

    namespace app\index\controller;
    use app\index\model\User;

    class Index
    {
        public function index()
        {
//            $data = [];
//            for($i=1;$i<=10;$i++) {
//                $data[] = [
//                    'nickname' =>"hello$i",
//                    'num' => $i + 10
//                ];
//            }
//
//            $user = new User;
//            $res = $user->saveAll($data);
//            var_dump($res);

//            $res = User::count();   //计数
//            $res = User::where('openid','>',4)
//                ->count();

//            $res = User::max('num');
//            $res = User::where("openid","<",4)
//                ->max('num');

//            计算数据和
//            $res = User::sum('num');
//                $res = User::where('openid','>',4)
//                    ->sum('num');

//            获取平均值

//            $res = User::avg('num');
            $res = User::where('openid','>',5)
                ->avg('num');

//            最小值
//            $res = User::min('num');
            $res = User::where('openid','>',4)
                ->min('num');
            var_dump($res);
        }
    }