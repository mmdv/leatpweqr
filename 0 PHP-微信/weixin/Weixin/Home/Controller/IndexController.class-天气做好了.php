<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
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
            //天气查询
            /*
             *
{
errNum: 0,
errMsg: "success",
retData: {
   city: "北京", //城市
   pinyin: "beijing", //城市拼音
   citycode: "101010100",  //城市编码
   date: "15-02-11", //日期
   time: "11:00", //发布时间
   postCode: "100000", //邮编
   longitude: 116.391, //经度
   latitude: 39.904, //维度
   altitude: "33", //海拔
   weather: "晴",  //天气情况
   temp: "10", //气温
   l_tmp: "-4", //最低气温
   h_tmp: "10", //最高气温
   WD: "无持续风向",	 //风向
   WS: "微风(<10m/h)", //风力
   sunrise: "07:12", //日出时间
   sunset: "17:44" //日落时间
  }
}*/
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

    //PHP很强大的采集工具
    function http_curl($url='http://www.baidu.com')
    {
        //获取imooc
        //1.初始化curl
        $ch = curl_init();

        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //3.采集
        $output = curl_exec($ch);

        //4.关闭
        curl_close($ch);
        var_dump($output);
    }

    //获取微信accesstoken
    function getWxAccessToken()
    {
        //1.请求url地址
        $appid = 'wx565c39b5d7389e54';
        $appsecret = 'bb7fe2b77bdd041257e65bab3e141dd3';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;

        //2初始化
        $ch = curl_init();

        //3.设置参数
        //CURLOPT_URL 需要获取的URL地址，也可以在curl_init()函数中设置。
        curl_setopt($ch, CURLOPT_URL, $url);
        //CURLOPT_RETURNTRANSFER 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //4.调用接口(采集)
        //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
        $res = curl_exec($ch);

        //5.关闭curl
        curl_close($ch);

        //如果有错误就打印看一下
        if (curl_errno($ch)) {
            var_dump(curl_error($ch));
        }
        //返回的为json,这里转化为数组
        $arr = json_decode($res, true);
        var_dump($arr);
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

    function getQrCode()
    {
        /*
         * 票据类型:
         * 全局票据:access_token
         * 网页授权:access_token
         * 微信js-sdk:jsapi_ticket
         */

        //临时URL
        //获取微信accesstoken
        $access_token = $this->getWxAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        //POST数据例子：{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
        $postArr = [
            //该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
            //24*60*60*7q    一周
            'expire_seconds' => 604800,
            //二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
            'action_name' => 'QR_SCENE',
            //二维码详细信息
            'action_info' => ['scene' => ['scene_id' => 2000]]
        ];
        //转为json
        $postJson  = json_encode($postArr);
        $res = $this->http_curl();
        var_dump($res);
    }
}