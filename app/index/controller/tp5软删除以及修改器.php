<?php

    namespace app\index\controller;
    use app\index\model\User;
    use Think\Model;

    class Index
    {
        public function index()
        {

//            修改时间戳,配置数据库auto_timestamp为true,一般不建议,如果不存在时间字段会报错
//            在model下更改
//            $res = User::create([
//                'name' => 'imooc',
//                'password' => md5('imooc')
//            ]);

            #时间自动更新
//            $user = User::get(1);
//            $user ->name = '2222';
//            $res = $user->save();

            #数据软删除
//            $res = User::destroy(2);

//            $res = User::get(2);
//            获取包含软删除的数据
//            $res = User::withTrashed(true)->find(2);

            #获取垃圾箱中被删除数据
//            $res = User::onlyTrashed(true)->select();
//            foreach ($res as $re) {
//                    var_dump($re->getData());
//                }

//            $res = User::destroy(2);  //配合User软删除

//            $res = User::destroy(3,true);//直接删除非软删
            $user = User::get(4);
            $res = $user->delete(true); //直接非软删除
            var_dump($res);
        }
    }