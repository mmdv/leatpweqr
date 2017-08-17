<?php

namespace app\index\controller;
use app\index\Model\User;//引入类

class Index
{
    public function index()
    {
        #User::get();
        $res = User::get(function($query){
            $query->where("nickname","eq","hello10")
                ->field('nickname,num');
        });      //参数可以使用函数构造条件

        #find
//        $res = User::where("openid",12)
//            ->field('nickname,openid')
//            ->find();

        #User::All()
//        $res = User::all(function($query){//使用函数构造条件
//            $query->where("openid","<",5)
//            ->field('nickname,openid');
//        });  //[4,5,6]  或者"1,2,3"
//        foreach ($res as $value){
//            var_dump($value->toArray());
//        }
        #select,返回数组
//        $res = User::where("openid",">","10")
//            ->field('nickname,openid')
//            ->limit(3,3)
//            ->order("openid desc")
//            ->select();
//        foreach ($res as $re) {
//            var_dump($re->toArray());
//        }

        #User::value()获取单独字段
//        $res = User::where("openid","10")->value('nickname');

        #User::column()
        $res = User::column('nickname','openid'); //第二个参数openid作为key,第一个参数nickname作为值
        var_dump($res);
//        $res = $res->toArray();
//        var_dump($res);
    }
}