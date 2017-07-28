<?php
//$url  接口url string
//$type 请求类型string
//$res  返回类型string
//$arr= 请求参数stringpublic
public function http_curl($url,$type='get',$res='json',$arr=''){

    //1.初始化curl
    $ch  =curl_init();
    //2.设置curl的参数
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    if($type == 'post'){
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
    }
    //3.采集
    $output =curl_exec($ch);

    //4.关闭
    curl_close($ch);
    if($res=='json'){
        if(curl_error($ch)){
            //请求失败，返回错误信息
            return curl_error($ch);
        }else{
            //请求成功，返回错误信息

            return json_decode($output,true);
        }
    }
    echo var_dump( $output );
}

//返回access_token *session解决办法 存mysql memcache
public function  getWxAccessToken(){
    if( $_SESSION['access_token'] && $_SESSION['expire_time']>time()){
        //如果access_token在session没有过期
        echo "111";
        echo $_SESSION['access_token'];;
        return $_SESSION['access_token'];
    }
    else{
        //如果access_token比存在或者已经过期，重新取access_token
        //1 请求url地址
        $AppId='wx6636f00cafe25cc0';
        $AppSecret='4e67418c1a2f5a1780235e3115eb2b77';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$AppId."&secret=".$AppSecret;
        $res=$this->http_curl($url,'get','json');
        echo "res";
        echo $res;
        $access_token =$res['access_token'];
        //将重新获取到的aceess_token存到session
        $_SESSION['access_token']=$access_token;
        $_SESSION['expire_time']=time()+7000;
        echo "2222";
        echo $access_token;
        return $access_token;
    }
}
//define('ROOT', str_replace('\\', '/', realpath(dirname(__FILE__) . '/')) . "/");
//$wx_url = 'https://api.weixin.qq.com/cgi-bin';
//
//function curl($url, $postFields = NULL)
//{
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_FAILONERROR, FALSE);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//https 请求
//if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == 'https') {
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
//    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
//}
//
//    if (is_array($postFields) && 0 < count($postFields)) {
//        $postBodyString = '';
//        $postMultipart = FALSE;
//        foreach ($postFields as $k => $v) {
//            if ('@' != substr($v, 0, 1)) //判断是不是文件上传
//            {
//                $postBodyString .= "$k=" . urlencode($v) . "&";
//            } else {
//                //文件上传用multipart/form-data，否则用www-form-urlencoded
//                $postMultipart = TRUE;
//            }
//        }
//        $postFields = trim($postBodyString, '&');
//        unset($k, $v);
//        curl_setopt($ch, CURLOPT_POST, TRUE);
//        if ($postMultipart) {
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
//        } else {
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
//        }
//    }
//
//    $reponse = curl_exec($ch);
//    curl_close($ch);
//    return $reponse;
//}
//
////获取微信token
////远程获取 微信token
//function curl_get_weixin_token()
//{
//    //去微信获取，然后保存
//    $TOKEN = curl('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=你的appid&secret=你的secret');
//    $TOKEN_json = json_decode($TOKEN, true);
//    $TOKEN_json['get_token_time'] = time();
//    file_put_contents(weixin_token_file(), json_encode($TOKEN_json));//保存到本地
//    return $TOKEN_json;
//}
//
////本地获取 微信token（如果不成功或者超时，就去远程获取）
//function file_get_weixin_token($now_time)
//{
//    //去微信获取，然后保存
//    $get_local_token = file_get_contents(weixin_token_file());
//    $token_array = json_decode($get_local_token, true);
//
//    //判断本地的weixin_token是否存在
//    if (!is_array($token_array) || !isset($token_array['get_token_time'])) {
//        //去微信获取，然后保存
//        $token_array = curl_get_weixin_token();
//    } else {
//        //判断 当前时间 减去 本地获取微信token的时间 大于7000秒 ,就要重新获取
//        if ($now_time - $token_array['get_token_time'] > 7000) {
//            $token_array = curl_get_weixin_token();
//        }
//    }
//    return $token_array;
//}
//
//function weixin_token_file()
//{
//    return ROOT . 'log/weixin/get_token.txt';
//}
//
//
//$now_time = time();
//$token_array = file_get_weixin_token($now_time);
//$access_token = $token_array['access_token'];