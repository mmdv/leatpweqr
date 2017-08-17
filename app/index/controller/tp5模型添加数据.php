<?php

namespace app\index\controller;
use app\index\Model\User;//引入类

class Index
{
    public function index()
    {
        #排除数据表不存在字段
        /*$res = User::create([
            'nickname' => 'hello',
            'time' => time(),
            'num' => 100,
            'demo' => 'go' //例如将$_POST写入数据库
        ],true); //true排除不存在字段*/

        #写入指定字段 create返回userModel模型
        /*$res = User::create([
            'nickname' => 'hello',
            'time' => time(),
            'num' => 100,
            'demo' => 'go' //例如将$_POST写入数据库
        ],['num']); //数组内数据表示只能写入的数据*/

        #save() 私有函数
//        $userModel = new User;
//        $userModel->nickname = '3333';
//        $userModel->num = 200;
//        $userModel->save();//私有函数

        #sava数组方式,allowField保证存在字段插入/true表示有的全部,写数组只插入数组内数据
//        $userModel = new User;
//        $res = $userModel->allowField(true)->save([
//            'nickname' => 'hell',
//            'num' =>00,
//            'time' => time(),
//            'demo' => 'hahah'
//        ]);

        #多条数据添加 返回数组
        $userModel = new User;
        $res = $userModel->saveAll([
            ['nickname'=>'122222'],
            ['nickname'=>'2222222']
        ]);
        foreach ($res as $re) {
            var_dump($re->openid);
            var_dump($re->toArray());
        }
    }
}