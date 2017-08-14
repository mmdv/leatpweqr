<?php

    namespace app\index\controller;
    use think\Controller;
    use think\Db;

    class Index extends Controller
    {
        public function  index()
        {
//            var_dump(config('database'));
//            var_dump(Db::connect()); //查看配置

//            使用sql语句的方式查询数据库
//            $res = Db::query("select * from imooc_user where openid=?",[1]);

//            插入数据库
            /*$res = Db::execute("insert into  imooc_user set nickname=?,time=?",[
                md5('imooc'),
                time()
            ]);*/

//            table表选择数据表,select 返回所有记录,返回结果是一个二维数组
//            如果结果不存在返回空数组
//            $res = Db::table('imooc_user')->select();

//            column  返回一个一维数组 数组中的value值就是我们要获取的列值
//            如果存在第二个参数,就返回这个数组并且用第二个参数的值作为数组的Key值
//            如果结果不存在,返回空数组
            $res = Db::table('imooc_user')->where([
                'openid' => 20
            ])->column('nickname','time');

//            返回一条记录,返回结果是一个一维数组
//            如果结果不存咋返回null值
//            $res = Db::table('imooc_user')->where([
//                'openid' => 6
//            ])->find();

//           value  返回一条记录,并且是这条记录的某个字段值
//            如果是一个不存在的值结果返回null
/*            $res = Db::table('imooc_user')->where([
                'openid' => 20
            ])->value('nickname');*/

//          不写表前缀
//            $res = Db::name('user')->select();

//            助手函数
            $res = db('user',[],false)->find();  //select()
            var_dump($res);

        }
    }

