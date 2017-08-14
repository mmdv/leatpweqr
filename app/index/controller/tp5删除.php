<?php

namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function  index()
    {
        $db = Db::name('user');

//        $res = $db->where([
//            'openid' => 33
//    ])->delete();

//        $res = $db->delete(36);   //直接传入主键值

//        $res = $db->delete();     //不允许无条件删除

        $res = $db->where("1=1")->delete();     //删除全部数据  不是"1==1"

        var_dump($res);
    }
}

