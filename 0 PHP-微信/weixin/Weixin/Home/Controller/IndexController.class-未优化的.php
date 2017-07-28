<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

    public function index()
    {
        //获得参数 signature nonce token timestamp echostr
        $nonce = $_GET['nonce'];
        $token = 'ipuxin';
        $timestamp = $_GET['timestamp'];
        $echostr = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
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
            echo 'nihao1';
        }
    }

    public function reponseMsg()
    {
        //1.获取到微信推送过来post数据（xml格式）
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        /*
         * 接收来的用户信息格式:
         * <xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
</xml>*/
        //把xml转化为对象
        $postObj = simplexml_load_string($postArr);
        //$postObj->ToUserName = '';
        //$postObj->FromUserName = '';
        //$postObj->CreateTime = '';
        //$postObj->MsgType = '';
        //$postObj->Event = '';

        // gh_e79a177814ed
        //判断该数据包是否是订阅的事件推送
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注 subscribe 事件
            if (strtolower($postObj->Event == 'subscribe')) {
                //回复用户消息(纯文本格式)
                $toUser = $postObj->FromUserName;
                //发送者:开发者公众账号
                $fromUser = $postObj->ToUserName;
                $time = time();
                //回复内容
                $msgType = 'text';
                $content = '公众账号 ToUserName: ' . $postObj->ToUserName . '- \n
                            微信用户 FromUserName: ' . $postObj->FromUserName . '- \n
                            转化前的xml: ' . $postObj . '- \n
                            转化后的xml是对象: ' . $postArr;
//                $content = '公众账号 ToUserName: ' . $postObj->ToUserName;

                $template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
                //sprintf 按照模板解析变量
                $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
                echo 'nihao';
                /*
                 * 发送格式:
                 * <xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>12345678</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[你好]]></Content>
                </xml>*/
            }

        } elseif (trim($postObj->Content) == 't') {
            //单文本回复
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $arr = [
                [
                    'title' => 'ipuxin',
                    'description' => "ipuxin is very cool",
                    'picUrl' => 'http://www.ipuxin.com/images/zdql.jpg',
                    'url' => 'http://www.ipuxin.com',
                ],
//                [
//                    'title' => 'hao123',
//                    'description' => "hao123 is very cool",
//                    'picUrl' => 'https://www.baidu.com/img/bdlogo.png',
//                    'url' => 'http://www.hao123.com',
//                ],
//                [
//                    'title' => 'qq',
//                    'description' => "qq is very cool",
//                    'picUrl' => 'http://mat1.gtimg.com/www/images/qq2012/qqlogo_1x.png',
//                    'url' => 'http://www.qq.com',
//                ],
            ];
            $template = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<ArticleCount>" . count($arr) . "</ArticleCount>
						<Articles>";
            foreach ($arr as $k => $v) {
                $template .= "<item>
							<Title><![CDATA[" . $v['title'] . "]]></Title> 
							<Description><![CDATA[" . $v['description'] . "]]></Description>
							<PicUrl><![CDATA[" . $v['picUrl'] . "]]></PicUrl>
							<Url><![CDATA[" . $v['url'] . "]]></Url>
							</item>";
            }

            $template .= "</Articles>
						</xml> ";
            echo sprintf($template, $toUser, $fromUser, time(), 'news');

            //注意：进行多图文发送时，子图文个数不能超过10个
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

            $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>";

            //注意模板中的中括号 不能少 也不能多
            $fromUser = $postObj->ToUserName;
            $toUser = $postObj->FromUserName;
            $time = time();
            $msgType = 'text';
            echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
            ///纯文本回复
        }
    }

    //PHP很强大的采集工具
    function http_curl()
    {
        //获取imooc
        //1.初始化curl
        $ch = curl_init();
        $url = 'http://www.baidu.com';

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
}