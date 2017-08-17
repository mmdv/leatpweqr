<?php
	use think\Env;
	return [
		'app_status' => Env::get('status','dev'),
        'db_config01' => [
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
        ]
	];