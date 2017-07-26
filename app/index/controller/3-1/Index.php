<?php
namespace app\index\controller;
use think\Config;
use think\Env;

// 就是不好用
class Index
{
    public function index()
    {
        $timestamp = $_GET['timestamp'];  //时间戳
        $nonce = $_GET['nonce'];    //随机字串
        $token = 'findjoy';         //微信公众号填写的token
        $signature =   $_GET['signature'];  //微信公众平台加密好的一个字串
        $echostr = isset($_GET['echostr'])?$_GET['echostr']:'';
        $array = array($timestamp,$nonce,$token);    //参数放入数组排序
        sort($array);   //PHP自带排序
        //2.将排序后的三个参数拼接之后用sha1加密
        $tmpstr = implode('',$array);//或者join拼接字符串
        $tmpstr = sha1($tmpstr);  //加密
        //3.将加密后的字符串与signature进行对比,判断该请求是否来自微信
        if($tmpstr == $signature && $echostr) {
            // 第一次接入微信 api接口的时候
            echo $echostr;  //从微信传递来的参数
            exit;
        } else {
            $this->reponseMsg();
        }
    }

    // 接收事件推送并回复

    public function reponseMsg()
    {
        // 1.获取到微信推送过来的数据(xml格式)
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $tmpstr  = $postArr;
        // file_get_contents('php://input');
        // 处理消息类型并设置回复类型和内容
        /*<xml>
        <ToUserName><![CDATA[toUser]]></ToUserName>
        <FromUserName><![CDATA[FromUser]]></FromUserName>
        <CreateTime>123456789</CreateTime>
        <MsgType><![CDATA[event]]></MsgType>
        <Event><![CDATA[subscribe]]></Event>
        </xml>*/

        $postObj = simplexml_load_string($postArr);   //xml解析
        // $postObj -> ToUserName = '';
        // $postObj -> FromUserName = '';
        // $postObj -> CreateTime = '';
        // $postObj -> MsgType = '';
        // $postObj -> Event = '';

        // 判断该数据包是否是订阅事件推送
        if( strtolower($postObj->MsgType) == 'event') {
            //如果是 subscribe关注事件
            if( strtolower($postObj->Event) =='subscribe') {   //小写函数
                //回复用户消息
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();              //时间函数
                $MsgType = 'text';
                $Content = '公众账号'.$postObj->ToUserName.'\n微信用户的openid'.$postObj->FromUserName.'\n消息格式:'.$tmpstr;
                $template = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";

                $info = sprintf($template,$toUser,$fromUser,$time,$MsgType,$Content); // 按照模板解析变量

                echo $info;


                /*<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>12345678</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[你好]]></Content>
                </xml>
*/            }
        }

        /*  if(strtolower($postObj->MsgType)=='text') {
                 switch( trim($postObj->Content) ) {
                     case 1:
                         $Content = '输入的数字是1';
                     break;
                     case 2:
                         $Content = '输入的数字是2';
                     break;
                     case 3:
                         $Content = '输入的数字是3';
                     break;
                     case '英文':
                         $Content = 'nice to meet you';
                     break;
                     case 4:
                         $Content = '<a href="https://www.baidu.com/">百度</a>';
                     break;
                 }

                 $template = '<xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName>
                 <CreateTime>%s</CreateTime>
                 <MsgType><![CDATA[%s]]></MsgType>
                 <Content><![CDATA[%s]]></Content>
                 </xml>';
                 $fromUser = $postObj->ToUserName;
                 $toUser = $postObj->FromUserName;
                 $time = time();
                 // $Content = 'imooc is very good';
                 $MsgType = 'text';
                 echo sprintf($template,$toUser,$fromUser,$time,$MsgType,$Content);
              }*/

        // 用户发送图文关键字的时候,回复一个单图文
        if( strtolower($postObj->MsgType) == 'text' && trim($postObj->Content) == 'tuwen' ) {
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $arr = array(
                array(
                    'title'=>'imooc',
                    'descripition'=>'imooc is very cool',
                    'picUrl'=>'http://img.netbian.com/file/2017/0718/b93ec99b9cf275ebe7bf52932f5d5493.jpg',
                    'url'=>'https://www.imooc.com',
                ),array(
                    'title'=>'imooc',
                    'descripition'=>'imooc is very cool',
                    'picUrl'=>'http://img.netbian.com/file/2017/0718/b93ec99b9cf275ebe7bf52932f5d5493.jpg',
                    'url'=>'https://www.baidu.com',
                ),array(
                    'title'=>'imooc',
                    'descripition'=>'imooc is very cool',
                    'picUrl'=>'http://img.netbian.com/file/2017/0718/b93ec99b9cf275ebe7bf52932f5d5493.jpg',
                    'url'=>'https://www.taobao.com',
                ),
                    );
            $template = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <ArticleCount>".count($arr)."</ArticleCount>
                <Articles>";

            foreach($arr as $k=>$v) {
                $template .= "<item>
                    <Title><![CDATA[".$v['title']."]></Title> 
                    <Description><![CDATA[".$v['descripition']."]]></Description>
                    <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                    <Url><![CDATA[".$v['url']."]]></Url>
                    </item>";
                }

            $template .="</Articles>
                </xml>";

            echo sprintf($template,$toUser,$fromUser,time(),'news');
        } else {
            switch( trim($postObj->Content) ) {
                     case 1:
                         $Content = '输入的数字是1';
                     break;
                     case 2:
                         $Content = '输入的数字是2';
                     break;
                     case 3:
                         $Content = '输入的数字是3';
                     break;
                     case '英文':
                         $Content = 'nice to meet you';
                     break;
                     case 4:
                         $Content = '<a href="https://www.baidu.com/">百度</a>';
                     break;
                 }

                 $template = "<xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName>
                 <CreateTime>%s</CreateTime>
                 <MsgType><![CDATA[%s]]></MsgType>
                 <Content><![CDATA[%s]]></Content>
                 </xml>";
                 $fromUser = $postObj->ToUserName;
                 $toUser = $postObj->FromUserName;
                 $time = time();
                 // $Content = 'imooc is very good';
                 $MsgType = 'text';
                 echo sprintf($template,$toUser,$fromUser,$time,$MsgType,$Content);
        }

    }

    function http_curl(){
        //获取imooc
        //1.初始化crul
        $ch = curl_init();
        $url =  'http://www.imooc.com';
        //2.设置curl参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        var_dump($output);
    }

    public function demo()
    {
        echo "hell0";
    }

//  获取微信AccessToken
    function getWxAccessToken() {
        $appid = 'wx54a47c7c3653b78b';
        $appsecret = 'c41bda30275763d736a1cb7eed32e1e8';
        //1.请求url地址,开发手册获取
        $ch = curl_init();
        $url =  'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        //2.设置curl参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //3.采集
        $res = curl_exec($ch);

//      关闭一个curl会话并且释放所有资源，curl句柄ch也会被释放，后面再使用$ch时就会报错。
//      所以curl_errno($ch),curl_error($ch)需要在curl_close($ch)之前（测试后可行）
        if(curl_errno($ch))
        {
            echo 'Curl error: ' . curl_error($ch);
        }

        //4.关闭
        curl_close($ch);

        $arr = json_decode($res,true);
        var_dump($arr);
    }

//   获取服务器地址
    function getWxServerIp() {

        $accessToken = '-th2JpAk8pCXJ4STkT64wfUJss9yNcxeHuhlBRqaLiq39gXU6mMCjCvT-T6UuBig6Cuar5oHu6bCQZYZOl8DQp4ee0JlHUZ62vMsBJAFtW0b7ggPxXSVWbGKtiNACe7ZDMGhAEAIRL';
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token='.$accessToken;

        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        $arr = json_decode($res,true);
        echo '<pre>';
        var_dump($arr);
        echo '</pre>';

    }

}
