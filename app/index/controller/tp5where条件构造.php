<?php

namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function  index()
    {
        $db = Db::name('user');

        #备注信息
        #EQ =
        #NEQ  <>  不等于
        #LT <
        #ElT <=
        #GT >
        #EGT >=
        #BETWEEN   BETWEEN  * AND *
        #NOTBETWEEN   NOTBETWEEN  *  AND *
        #IN   IN (*,*)
        #NOTIN  NOT IN (*,*)
       /* $sql = $db->where([        //where("40")  或者 where("openid","40")
            'openid' => 40
        ])->buildSql();*/

//        $sql = $db->where("openid","EQ",42)->buildSql();//不区分大小写   与  =符号功能等价

//        $sql = $db->where("openid","between","1,5")->buildSql();//不区分大小写   与  =符号功能等价
//        $sql = $db->where("openid","notbetween",[1,20])->buildSql();//不区分大小写   数组参数与 ,字符串方式参数功能相同 BETWEEN只前两个参数有效
//        $sql = $db->where("openid","in",[1,10,20])->buildSql();//不区分大小写   in可以是多个数据
//        $sql = $db->where("openid","in","1,10,20")->buildSql();//不区分大小写 数组参数与 ,字符串方式参数功能相同

        /*$sql = $db->where([
            'openid' => 44
        ])->buildSql();*/

        /*$sql = $db->where([
           'openid' => ['egt',4]   //数组内改变条件
       ])->buildSql();*/

//        where内数组改变条件
//        $sql = $db->where([
//            'openid' => ['in',[1,2,3,8,7]],   //数组内改变条件
//            'nickname' => 'hello'
//        ])->buildSql();

//        条件表达式 EXP
//        $sql = $db->where("openid","exp","not in (1,2,3)")->buildSql();

//        连续使用where 构造and关系
         /*$sql = $db
        ->where("openid","in","1,2,3")
        ->where("nickname","onceagain")
        ->buildSql();*/

//         whereOr 产生or条件
        $sql = $db
            ->where("openid","in","1,2,3")
            ->whereOr("nickname","onceagain")
            ->whereOr("num","lt","10") //参数1 列键值  参数2 表达式 参数3 数据
            ->where('time',2222)
            ->buildSql();

        var_dump($sql);
    }
}

