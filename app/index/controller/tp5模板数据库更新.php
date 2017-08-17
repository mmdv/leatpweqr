<?php

    namespace app\index\controller;
    use app\index\model\User;
    use think\Controller;

    class Index extends Controller
    {
        public function index()
        {
            #插入数据
//            $data = [];
//            for($i=1;$i<=20;$i++){
//                $data[] = [
//                    'nickname' => "hello$i",
//                    'time' => time(),
//                    'num' => $i,
//                    'group' => $i
//                ];
//            }
//            $userModel = new User;
//            $res = $userModel ->saveAll($data);

//            $res = User::update([
//                'nickname' => 'jumpHi'
//            ],function($query){
//                $query->where("openid","LT",5);
//            });  //第二个参数可以是数组['openid'=>'3']/或者使用function过滤

            #构造筛选条件 ,常用
//            $res = User::where("openid","lt",10)
//                ->update([
//                    'nickname'=>'ok'
//                ]);

            #User::get()方式
//            $userModel = User::get(1);
//            $userModel->nickname = '123';
//            $userModel->num = 200;
//            $res = $userModel->save();

            #new User 常用
//            $userModel = new User;
//            $res = $userModel->save([
//                'nickname' =>'good'
//            ],function($query){
//                $query->where("openid","lt",4);
//            });   //可以使用数组,['openid' => 6],同样可以使用function

            #批量更新
            $userModel = new User;
            $res = $userModel->saveAll([
                ['openid'=>1,'nickname'=>1],
                ['openid'=>2,'nickname'=>2]
            ]);
            var_dump($res);
        }
    }
