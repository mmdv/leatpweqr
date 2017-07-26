<?php

    namespace app\model\controller;

    class Index {
//        回复多图文
        public function responseNews($postObj,$arr) {
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;

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
        }

//      回复单图文
        public function responseText($postObj,$content){
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
            $MsgType = 'text';
            echo sprintf($template,$toUser,$fromUser,$time,$MsgType,$content);
        }

//        回复用户的关注事件
        public function  responseSubscribe($postObj,$arr){
          /*  $toUser = $postObj->FromUserName;
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

            echo $info;*/

            $this->responseNews($postObj,$arr);

        }

    }