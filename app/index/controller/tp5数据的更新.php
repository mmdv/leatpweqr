<?php

namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function  index()
    {
        $db = Db::name('user');

        #update  返回影响的函数
//        $res = $db->where(
//            ['openid' =>30]
//        )->update([
//            'nickname' => '22222',
//            'time' =>time()
//        ]);

        # setField   返回影响行数 ,每次更新一个字段
//        $res = $db ->where([
//            'openid' => 33
//        ])->setField('nickname','jump');

        #setInc  自增 没有第二个参数自增1,有第二个参数自增参数值  返回影响数据的行数
//        $res = $db->where([
//            'openid' => 30
//        ])->setInc('num',3);

        #setDec 自减 没有第二个参数自减1,有第二个参数自减参数值  返回影响数据的行数
        #设计数据表,无符号表示没有负数值
        $res = $db->where([
            'openid' => 35
        ])->setDec('num',3);

        var_dump($res);
    }
}

