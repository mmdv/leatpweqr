<?php

namespace app\index\controller;

//应用配置测试代码
//    class Index
//    {
//        public function index()
//        {
////            dump(config());  //tp的助手函数config返回应用当前的所有配置
//
//            $conf1 = [
//                'username' => 'yxg'
//            ];
//
//            $conf2 = [
//                'usernames' =>   'along'
//            ];
//            dump( array_merge($conf1,$conf2) );
//            }
//        }

//  模块配置,动态配置代码
//class Index
//{
//    public function __construct()
//    {
////        当前模块所有函数出现配置,诸如下面的demo
//        config('before','beforeAction');
//    }
//
//    public function index()
//    {
////        只有index可以出现在配置
//        config('indexAction','index');
//        dump(config());
//    }
//
//    public function demo()
//    {
//        dump(config());
//    }
//}

//获取方法二
use think\Config;
class Index
{
    public function index()
    {
//        获取方法1
//        $res = \think\config::get();
//对应方法2
//          $res = config::get();

//        对应方法3
        $res = config();

//        获取
//        $res = Config::get('app_namespace');
//        $res = config('app_namespace');
//          dump($res);

//        设置参数
//        Config::set('username','alone');
//        config('user','alone me');
//        dump(Config::get('username'));

//设置作用域
//        Config::set('username','alone','index'); //index 定义作用域
//        config('username','index_config','index');
//        dump(Config::get('username','index'));

//        has函数检测是否有此配置
        Config::set('username','123');
//        $res = Config::has('username');

        $res = config('?username');//第一位必须?号
        dump($res);
    }
}