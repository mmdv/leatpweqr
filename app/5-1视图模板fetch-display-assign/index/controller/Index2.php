<?php
namespace app\index\controller;
use think\Config;
use think\Env;
use app\model\controller\Index as IndexModel;

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
                //回复用户消息 ,单图文格式
                $arr = array(
                    array(
                        'title'=>'imooc,程序猿的天堂',
                        'descripition'=>'欢迎来到慕课学习',
                        'picUrl'=>'http://img.netbian.com/file/2017/0718/b93ec99b9cf275ebe7bf52932f5d5493.jpg',
                        'url'=>'https://www.imooc.com',
                    )
                );
                 $indexModel = new IndexModel();
                 $indexModel->responseSubscribe($postObj,$arr);
            }
        }


        // 用户发送图文关键字的时候,回复一个单图文
        if( strtolower($postObj->MsgType) == 'text' && trim($postObj->Content) == 'tuwen' ) {
//          从数据库中获取
            $arr = array(
                array(
                    'title'=>'imooc',
                    'descripition'=>'imooc is very cool',
                    'picUrl'=>'http://img.netbian.com/file/2017/0718/b93ec99b9cf275ebe7bf52932f5d5493.jpg',
                    'url'=>'https://www.imooc.com',
                )
            );
//            实例化模型
            $indexModel = new IndexModel();
            $indexModel-> responseNews($postObj,$arr);
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
                    case 5:
                        $Content = '微信sdk is very useful';
                        break;
                default :
                        $Content = '没有找到相关信息';
                    break;
                 }
//          实例化模型
            $indexModel = new IndexModel();
            $indexModel->responseText($postObj,$Content);
        }

    }



/*
 * $url 接口url string
 * $type 请求类型
 *  $res 返回数据类型
 * $arr post请求参数
 * */

    function http_curl($url,$type='get',$res='json',$arr=''){
        //1.初始化curl
        $ch = curl_init();
        //2.设置curl参数
//        curl_setopt($ch,CURLOPT_URL,$url);
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//        if($type == 'post'){
//            curl_setopt($ch,CURLOPT_POST,true);
//            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
//        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($type == 'post'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        //3.采集
        $output = curl_exec($ch);

        if($res == 'json'){
            if(curl_errno($ch)) {
//                请求失败返回错误信息
                return curl_error($ch);
            } else {
//                请求成功
                return json_decode($output,true);
            }
        }
        //4.关闭
        curl_close($ch);
    }

//  获取微信AccessToken
    function getWxAccessToken() {
        $appid = 'wxbc312a582bccb32e';
        $appsecret = '9ffbd473b9c54dda8697791dba6dff14';
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

//  返回access_token,*session解决办法,存mysql,memcache
    public function getAccessToken(){
//        session_start();
        if( isset($_SESSION['access_token']) && $_SESSION['expire_time']>time() ){//检测session是否已经存在
//            如果access_token存在并未过期
            return $_SESSION['access_token'];
        } else{
//          如果access_token不存在或则已过期,重新去access_token
            $appid = 'wxbc312a582bccb32e';
            $appsecret = '9ffbd473b9c54dda8697791dba6dff14';
            $url =  'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
            $res = $this->http_curl($url,'get','json');
            $access_token = $res['access_token'];
//            将重新获取到的access_token存储到session
            $_SESSION['access_token'] = $access_token;
            $_SESSION['expire_time'] = time()+ 7000;   //
            return $access_token;
        }
    }

    public function defineItem(){
//        创建微信菜单
//        目前微信接口的调用方式都是通过curl post/get
        header('content-type:text/html;charset=utf-8');
        echo $accessToken = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$accessToken;
        $postArr = array(
            'button'=>array(
                array(
                    'name'=>urlencode('菜单一'),
                    'type'=>'click',
                    'key'=>'item1'
                ),//第一个一级菜单
                array(
                    'name'=>urlencode('菜单二'),
                    'sub_button'=>array(
                        array(
                            'name'=>urlencode('歌曲'),
                            'type'=>'click',
                            'key'=>'songs'
                        ),//第一个二级菜单
                        array(
                            'name'=>urlencode('电影'),
                            'type'=>'click',
                            'key'=>'hello'
                        )//第二个二级菜单
                    )
                ),//第二个一级菜单
                array(
                    'name'=>urlencode('菜单三'),
                    'type'=>'click',
                    'key'=>'hell'
                )//第三个一级菜单
            )
        );

        echo '<hr>';
        var_dump($postArr);
        echo '<hr>';
        $postJson = urldecode(json_encode($postArr));
        var_dump($postJson);

        $res = $this->http_curl($url,'post','json',$postJson);
        var_dump($res);
    }

//  获取用户的openid
    function getBaseInfo(){
//        1.获取到code
        $appid = "wxbc312a582bccb32e";
        $redirect_uri = urlencode("http://www.yxgonce.xin/index.php/index/index/getUserOpenId"); //将会重定向的uri(是自己在公众号绑定js的域名)
//        appid=wxf0e81c3bee622d60&redirect_uri=http%3A%2F%2Fnba.bluewebgame.com%2Foauth_response.php&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri".$redirect_uri."&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        header('location:'.$url);
    }
    function getUserOpenId(){
//        2.获取到网页授权的access_token
        $appid = "wxbc312a582bccb32e";
        $appsecret = "9ffbd473b9c54dda8697791dba6dff14";
        $code=$_GET['code'];

        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";

        //3,拉取用户的详细信息openid
        $res=$this->http_curl($url,'get');
        var_dump($res);
        $openid =  $res['openid'];
//        time();
//        1,2,3

//        页面index.tpl
//        $this->display('idnex.tpl');
//        http://yxgonce.xin/index.php/index/getBaseInfo
    }

    function getUserDetail(){
        //        1.获取到code
        $appid = "wxbc312a582bccb32e";
        $redirect_uri = urlencode("http://www.yxgonce.xin/index.php/index/index/getUserInfo"); //将会重定向的uri(是自己在公众号绑定js的域名)

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri".$redirect_uri."&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        header('location:'.$url);
    }

    function getUserInfo(){
//        2.获取到网页授权的access_token
        $appid = "wxbc312a582bccb32e";
        $appsecret = "9ffbd473b9c54dda8697791dba6dff14";
        header('content-type:text/html;charset=utf-8');
        //2.获取网页授权access_token
        $code = $_GET['code'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid
            . '&secret=' . $appsecret
            . '&code=' . $code . '&grant_type=authorization_code';
        $res = $this->http_curl($url, 'get');
        $openid = $res['openid'];
        $access_token = $res['access_token'];
        //3.拉取用户详细信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='
            . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $res = $this->http_curl($url);
        echo '<hr>getUserInfo<br>';
        var_dump($res);
        echo '<hr>';
    }
    public function demo()
    {
        echo "hell0";
    }

//    获取jsapi_ticket全局票据
    function getJsApiTicket(){
        session_start();
//        如果session保存有效的jsapi_ticket
        if( isset($_SESSION['jsapi_ticket']) && $_SESSION['jsapi_ticket_expire_time'] > time()){
            echo '00';
            return  $jsapi_ticket = $_SESSION['jsapi_ticket'];
        } else {
            $access_token = $this->getWxAccessToken();
            echo '11';
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
//            $res = $this->http_curl($url);
            /*
             *
             * */
            $ch = curl_init();
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

            /*
             *
             *
             * */
            echo $arr['ticket'];
            $jsapi_ticket = $arr['ticket'];
            $_SESSION['jsapi_ticket'] = $jsapi_ticket;
            $_SESSION['jsapi_ticket_expire_time'] = time() + 7000;
        }
        echo '22';
        return $jsapi_ticket;
    }
//获取16位随机码
    function getRandCode($num = 16) {
        $array = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p',
            'q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9'
        );
        $tmpstr = '';
        $max = count($array);
        for( $i=1;$i<=16;$i++ ){
            $key = rand(0,$max - 1);
            $tmpstr .= $array[$key];
        }
        echo "888".$tmpstr;
        return $tmpstr;
    }
//分享朋友圈
    function shareWx(){
//        1.获取jsapi_ticket票据
        $jsapi_ticket = $this->getJsApiTicket();
        echo '33';
        $timestamp = time();
        $noncestr = $this->getRandCode();
        $url = 'http://yxgonce.xin/index.php/index/index/shareWx'; //访问路径
//        获取signature算法
        echo '44';
        $signature = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$url;
        $signature = sha1($signature);
        $this->assgin('name','imooc');
        $this->assign('timestamp',$timestamp);
        $this->assign('noncestr',$noncestr);
        $this->assign('signature',$signature);
        $this->display('Index/share');
        echo '55';
    }

}
