<?php

namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function  index()
    {
//        $db = Db::name('user');
//        插入数据
//        $data = [];
//        for($i=0; $i<21; $i++) {
//            $data[] = [
//                'openid' => "$i",
//                'nickname' => "hello{$i}",
//                'time' => time(),
//                'num' => $i + 100
//            ];
//        }
//
//        $res = $db->insertAll($data);

        /*
         * 链式操作,Db类会返回一个Db类,类似于jquery*/
       /* $res = Db::table('imooc_user')
            ->where("openid",">",10)
            ->field('nickname','openid')
            ->order('openid desc')   //order('openid','desc')
//            ->limit(3) //判断选取逇区域,返回选中数据的前3条
//            ->limit(3,5) //从第3条开始取,取5条
//            ->page(2,5)    //分页  limit((3-1) *5 ,5)  从第二页开始每页5条
            ->group("'group'")//gruop是字段 加单引号变为字符串
            ->select();*/

         $res = Db::table('imooc_user')
             ->field('nickname,openid,group')
             ->group("'group'")//gruop是字段 加单引号变为字符串
             ->select();



        var_dump($res);
    }
}

