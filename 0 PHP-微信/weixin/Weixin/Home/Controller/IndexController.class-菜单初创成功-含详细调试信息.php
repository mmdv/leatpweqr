<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    //获取access_token的两个参数
    public $appid = 'wx6fab4429311cbc75';
    public $appsecret = '42c72922b0141a66be625a88ff3ed11e';

    public function __construct()
    {
    }

    public function index()
    {
        //获得参数 signature nonce token timestamp echostr
        $nonce = $_GET['nonce'];
        $token = 'ipuxin';
        $timestamp = $_GET['timestamp'];
        $echostr = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1(implode($array));
        if ($str == $signature && $echostr) {
            //第一次接入weixin api接口的时候
            echo $echostr;
            exit;
        } else {
            $this->reponseMsg();
        }
    }

    public function reponseMsg()
    {
        //1.获取到微信推送过来post数据（xml格式）
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];

        //把xml转化为对象
        $postObj = simplexml_load_string($postArr);

        //判断该数据包是否是订阅的事件推送
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注 subscribe 事件
            if (strtolower($postObj->Event == 'subscribe')) {
                //回复用户消息(纯文本格式)
                $content = '公众账号 ToUserName: ' . $postObj->ToUserName . "- \n
                            微信用户 FromUserName: " . $postObj->FromUserName . "- \n
                            转化前的xml: " . $postObj . "- \n
                            转化后的xml是对象: " . $postArr;

                D('Index')->responseSubscribe($postObj, $content);
            }

        } elseif (trim($postObj->Content)) {
            $ch = curl_init();
            $url = 'http://apis.baidu.com/apistore/weatherservice/weather?cityname=' . urlencode($postObj->Content);
            $header = array(
                'apikey:a03dcf32a42724d6d51b634472b290b9',
            );
            // 添加apikey到header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // 执行HTTP请求
            curl_setopt($ch, CURLOPT_URL, $url);
            $res = curl_exec($ch);

            $arr = json_decode($res, true);
            $content = '城市: ' . $arr['retData']['city'] . "\r" . '海拔: ' . $arr['retData']['altitude'] . "\n" .
                '天气情况: ' . $arr['retData']['weather'] . "\n" .
                '平均气温: ' . $arr['retData']['temp'] . "\n" .
                '日出时间: ' . $arr['retData']['sunrise'] . "\n" .
                '日落时间: ' . $arr['retData']['sunset'] . "\n" .
                '发布时间: ' . $arr['retData']['time'];

            D('Index')->responseMsgText($postObj, $content);

        } elseif (trim($postObj->Content) == 't') {
            //单文本回复
            //回复的文本内容,从数据库中配置
            $arr = [
                [
                    'title' => 'ipuxin',
                    'description' => "ipuxin is very cool",
                    'picUrl' => 'http://www.ipuxin.com/images/zdql.jpg',
                    'url' => 'http://www.ipuxin.com',
                ],
                [
                    'title' => 'hao123',
                    'description' => "hao123 is very cool",
                    'picUrl' => 'https://www.baidu.com/img/bdlogo.png',
                    'url' => 'http://www.hao123.com',
                ],
                [
                    'title' => 'qq',
                    'description' => "qq is very cool",
                    'picUrl' => 'http://mat1.gtimg.com/www/images/qq2012/qqlogo_1x.png',
                    'url' => 'http://www.qq.com',
                ],
            ];
            D('Index')->responseMsgImg($postObj, $arr);
            ///单文本回复

        } elseif (strtolower($postObj->MsgType) == 'text') {
            //纯文本回复
            switch (trim($postObj->Content)) {
                case 1:
                    $content = '您输入的数字是1';
                    break;
                case 2:
                    $content = '您输入的数字是2';
                    break;
                case 3:
                    $content = '您输入的数字是3';
                    break;
                case 4:
                    $content = "欢迎访问<a href='http://www.ipuxin.com'>壹朴心</a>";
                    break;
                case '英文':
                    $content = '您输入的是: 英文';
                    break;
                default:
                    $content = '请输入数字:1 2 3 4 或 英文 字样';
            }
            D('Index')->responseMsgText($postObj, $content);
        }
    }

    /*
     * $url 接口url string
     * $type 请求类型 string
     * $res 返回数据类型 string
     * $arr post请求参数 string
     */
    public function http_curl($url,$type='get',$res='json',$arr=''){

        //1.初始化curl
        $ch  =curl_init();
        //2.设置curl的参数
        if($type == 'post'){
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }else{
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        }
        //3.采集
        $output =curl_exec($ch);

        echo '<hr>this is $url;<br>';
        var_dump($url);
        echo '<hr>';

        echo '<hr>this is $ch;<br>';
        var_dump($ch);
        echo '<hr>';

        echo '<hr>this is curl_error($ch);<br>';
        var_dump(curl_error($ch));
        echo '<hr>';

        echo '<hr>this is curl_errno($ch);<br>';
        var_dump(curl_errno($ch));
        echo '<hr>';

        //4.关闭
        curl_close($ch);
        if($res=='json'){
            if(curl_errno($ch)){
                //请求失败，返回错误信息
                return curl_error($ch);
            }else{
                //请求成功，返回信息
                echo '<hr>this is $output;<br>';
                var_dump($output);
                echo '<hr>';
                echo '<hr>this is json_decode($output,true);<br>';
                var_dump(json_decode($output,true));
                echo '<hr>';
                return json_decode($output,true);
            }
        }
        echo var_dump( $output );
    }

    //创建微信菜单
    public function definedItem()
    {
        header('content-type:text/html;charset=utf-8');
        //目前微信接口调用是通过curl post/get
        $access_token = $this->getWxAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token;

        //菜单
        $postArr = [
            'button' => [
                [
                    'type' => 'click',
                    'name' => urlencode('第一个主菜单'),
                    'key' => 'temp1',
                ],
                [
                    'type' => 'click',
                    'name' => urlencode('第二个主菜单'),
                    'key' => 'temp2',
                ],
                [
                    'name' => urlencode('含子菜单'),
                    'sub_button' => [
                        [
                            'type' => 'click',
                            'name' => urlencode('第一个二级菜单'),
                            'key' => 'temp3',
                        ],
                        [
                            'type' => 'view',
                            'name' => urlencode('百度'),
                            'url' => 'http://www.baidu.com',
                        ],
                        [
                            'type' => 'view',
                            'name' => urlencode('壹朴心'),
                            'url' => 'http://www.ipuxin.com',
                        ],
                    ],
                ],

            ]
        ];

        $postJson = urldecode(json_encode($postArr));

        echo '<hr>this is $access_token;<br>';
        var_dump($access_token);
        echo '<hr>';

        echo '<hr>this is $postArr;<br>';
        var_dump($postArr);
        echo '<hr>';

        //这种json是被包裹在双引号中的字符
        echo '<hr>this is $postJson;<br>';
        var_dump($postJson);
        echo '<hr>';

        $res = $this->http_curl($url, 'post', 'json', $postJson);
        echo '<hr>this is $res = $this->http_curl($url, \'post\', \'json\', $postJson)<br>';
        var_dump($res);
        echo '<hr>';
    }

    //获取微信accesstoken
    function getWxAccessToken()
    {
        //将access_token 存在seeion中
        if ($_SESSION['access_token'] && $_SESSION['expire_time'] > time()) {
            //如果session中存在access_token,而且过期时间大于当前时间,从session中取得
            return $_SESSION['access_token'];

        } else {
            //session中不存在,或者已过期
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appid . "&secret=" . $this->appsecret;
            $res = $this->http_curl($url, 'get', 'json');
            $access_token = $res['access_token'];
            //将重新获得的access_tooken存到session中
            $_SESSION['access_token'] = $access_token;
            $_SESSION['expire_time'] = time() + 7000;
            return $access_token;
        }
    }

    //获取微信服务器地址,用来判断信息是否是微信发来的
    function getWxServerIp()
    {
        $accessToken = "_PNQ_iDNg-E8x34dkEOdqJuBDeK7_liXYw2eHyM7rVMzxzYfGAsw1l5iVriZ4T5ny29qi_cVZwci7acpi843Y7bFpzN9Tkw5b2qWemwyqCHtzhyCdmap9DC30Z25ymf7OEYfAAAZPJ";
        //1
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=" . $accessToken;
        //2
        $ch = curl_init();
        //3
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //4
        $res = curl_exec($ch);
        //5
        curl_close($ch);

        if (curl_errno($ch)) {
            var_dump(curl_error($ch));
        }

        $arr = json_decode($res, true);

        echo "<pre>";
        var_dump($arr);
        echo "</pre>";
    }

}