<?php

    namespace app\index\controller;
    use think\Controller;
    use think\Db;
    use think\Config;

    class Index extends Controller
    {
        public function  index()
        {
//            var_dump(config('database')); //查看数据库配置,可以在database.php下配置
            $res = Db::connect();
//            var_dump($res); //能打印参数认为链接已经连接上

//            在model中配置数据库
           /* Db::connect( [
                // 数据库类型
                'type'            => 'mysql',
                // 数据库连接DSN配置
                'dsn'             => '',
                // 服务器地址
                'hostname'        => '127.0.0.1',
                // 数据库名
//        'database'        => Env::get('database.dbname','wechat'),
                'database'        => 'wechat',
                // 数据库用户名
//        'username'        => Env::get('database.username','root'),
                'username'        => 'root',
                // 数据库密码
//        'password'        => Env::get('database.username',''),
                'password'        => '',
                // 数据库连接端口
                'hostport'        => '',
                // 数据库连接参数
                'params'          => [],
                // 数据库编码默认采用utf8
                'charset'         => 'utf8',
                // 数据库表前缀
                'prefix'          => ''
                // 数据库调试模式
//            ]);*/


//           使用dsn配置方式链接数据库;mysql=数据库类型,
//            $res = Db::connect("mysql://root:@127.0.0.1:3306/dbname#utf-8");
//            var_dump($res);

        $res = Db::connect('db_config01');
        var_dump($res);

        }
    }