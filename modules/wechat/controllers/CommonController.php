<?php
header("Content-type:text/html;charset=utf-8");
class CommonController extends Controller
{

    public function actionTime(){
        $openid= $_GET['openid'];
        $state = $_GET['state'];
        // $code = $_GET['code'];
        //echo $code;die();
        $cp = Wxbox::model()->find("number='$openid'");
//        if($cp['cp'] == 1){
//            echo "<script>window.location.href='http://www.phpweb100.com/test1.html'</script>";
//        }elseif($cp['cp'] == 2){
//            echo "<script>window.location.href='http://www.phpweb100.com/test2.html'</script>";
//        }
        //print_r($cp);die();
//        if($cp['cp'] != '' || $cp['cp'] !='8'){
//            $cp = $cp['cp'];
//        }else{
//            $cp = '8';
//        }
        if(!empty($cp['cp']) && $cp['cp'] !='8'){
            $cps = $cp['cp'];
        }else{
            $cps = '8';
        }
        // print_r($cps);die();
        $menu = WxMenu::model()->find("state = '$state'");
        $menu = $menu['title'];
        //echo 111;die();
        $url = WxUrl::model()->find("menu = '$menu' and cp = '$cps'");// and cp = '$cp'
        // print_r($url);die();
        $url = $url['url'];
        if(!empty($url)){
            // echo $url;
            // echo "<script>window.location.href='".$url."/code/{$code}'</script>";
            echo "<script>window.location.href='".$url."'</script>";
            // echo "<script>window.location.href='http://baidu.com'</script>";
        }


    }



    //获取token
    public function getToken(){
        //趣萌
//        $appid = "wxa2fc0cbf5fb2cbf0";
//        $appsecret = "d5232b1c344e68135a47764ead03356f";
        //魔百合
        $appid = "wx3f9bb59f5ba78010";
        $appsecret = "5f17728db47200477af5b2d9943211b0";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        //$output=file_get_contents($url);
        $jsoninfo = json_decode($output, true);
         //print_r($jsoninfo);die;
        $access_token = $jsoninfo["access_token"];
        return $access_token;
    }

    //同步微信素
    public function actionSyncAllList(){

        /*$Material = M('Wechat_material');
        $where['data_status'] = 1;
        $data['data_status'] = 0;
        $Material->where($where)->save($data);
        */
        //$material = WxMaterial::model()->findAll("data_status = 1");
        //$material -> data_status = 0;
        //$material -> save();
        //$count =WxMaterial::model()->updateAll(array('data_status'=>'1'),'data_status=:data_status',array(':data_status'=>'0'));
        $connection = Yii::app()->db;
        $sql = "update yd_wx_material set data_status=0 where data_status=1";
        $command = $connection->createCommand($sql);
        $result = $command->execute();
        $image = WxMaterial::model()->count("data_type = 'image'");
        $video = WxMaterial::model()->count("data_type = 'video'");
        $voice = WxMaterial::model()->count("data_type = 'voice'");
        $news = WxMaterial::model()->count("data_type = 'news'");

//        //删除素材图文（文章）表
//        $sql = "delete from yd_wechat_atricles";
//        $command = $connection->createCommand($sql);
//        $result = $command->execute();
//
//        //删除素材表
//        $sql = "delete from yd_wx_material where data_status=0";
//        $command = $connection->createCommand($sql);
//        $result = $command->execute();
        $this->Sync('image',$image);
        $this->Sync('video',$video);
        $this->Sync('voice',$voice);
        //$this->Sync('news');
        $this->atricles('news',$news);
        //WxMaterial::model()->deleteAll('data_status=:data_status',array(':data_status'=>'1'));
        //$map['data_status'] = 0;
        //$Material->where($map)->delete();
        //WxMaterial::model()->deleteAll('data_status =:data_status',[':data_status' => 0]);


        //echo "完成";
        //  $this->success("同步完成",U('Material/index'),3);

        //$this->redirect($this->get_url('material','index'));
        echo "<script>alert('同步完成');history.go(-1);</script>";

    }

    //文章消息
    public function atricles($type='news',$offset=0){

        $image = $this->getMediaList($type,$offset);
        if(isset($image['errcode'])) throw new ExceptionEx("获去图文素材错误！错误代码：$image[errcode], 错误信息：$image[errmsg]");
        $media_id=$image['item'][0]['media_id'];
        $title=$image['item'][0]['content']['news_item'][0]['title'];
        $creat_time=$image['item'][0]['update_time'];
        $nowtiem=time();
        $connection = Yii::app()->db;
        $sqll = "insert into yd_wx_material (media_id,title,create_time,update_time,data_type,data_status) VALUE ('$media_id','$title','$creat_time','$nowtiem','news','1')";
        $command = $connection->createCommand($sqll);
        $result = $command->execute();

        $atricles = new WechatAtricles();

        foreach($image['item'][0]['content']['news_item'] as $kel=> $val) {
            /* echo $val['title'];
             $atricles -> title =$val['title'];
             $atricles -> digest =$val['digest'];
             $atricles -> thumb_media_id =$val['thumb_media_id'];
             $atricles -> author =$val['author'];
             $atricles -> show_cover_pic =$val['show_cover_pic'];
             $atricles -> content =$val['content'];
             $atricles -> content_source_url =$val['content_source_url'];
             $atricles -> thumb_url =$val['thumb_url'];
             $atricles -> create_time =time();
             $atricles -> update_time =time();
             $res = $atricles -> save();
            */
            $nowtiem=time();
            $connection = Yii::app()->db;
            $sql = "insert into yd_wechat_atricles (media_id,title,digest,thumb_media_id,author,show_cover_pic,content,content_source_url,thumb_url,create_time,update_time,url) VALUE ('$media_id','$val[title]','$val[digest]','$val[thumb_media_id]','$val[author]','$val[show_cover_pic]','$val[content]','$val[content_source_url]','$val[thumb_url]','$nowtiem','$nowtiem','$val[url]')";
            $command = $connection->createCommand($sql);
            $result = $command->execute();
        }
        $offset =$offset+$image['item_count'];

        if($offset < $image['total_count']){
            $this->atricles($type,$offset);
        }

        return true;
    }

    /* 递归取出所有列表*/
    public function Sync($type='image',$offset=0) {


//        $Material = M('Wechat_material');
//        $image = $this->getMediaList($type,$offset);
//        if(isset($image['errcode'])) $this->error("获去图文素材错误！错误代码：".$image['errcode'].", 错误信息：".$image['errmsg'],'',3);

        $material = new WxMaterial();
        $image = $this->getMediaList($type,$offset);
        if(isset($image['errcode'])) throw new ExceptionEx("获去图文素材错误！错误代码：$image[errcode], 错误信息：$image[errmsg]");
        //print_r($image);
        //die();
        foreach($image['item'] as $val) {
            //$info = WxMaterial::model()->find("media_id ='$val[media_id]'");
            $material -> media_id = $val['media_id'];
            $material -> title = $val['name'];
            $material -> create_time = $val['update_time'];
            $material -> url =  isset($val['url']) ? $val['url'] :'';
            $material -> data_type = $type;
            $material -> data_status = 1;
            $material -> update_time = time();
            //$material -> title = $info['title'];
            //$material -> introduction = $info['introduction'];
            //$material -> atricles_id = $info['atricles_id'];
            //$material -> local_path = $info['local_path'];
            // $res = $Material->add($data,$options=array(),$replace=true);
            $res = $material -> save();
        }


//        foreach($image['item'] as $val) {
//            $where['media_id'] = $val['media_id'];
//            $info = $Material->where($where)->find();
//
//            $data = array(
//                'media_id' => $val['media_id'],
//                'update_time' => time(),
//                'title' => $info['title'],
//                'introduction' => $info['introduction'],
//                'create_time' => $val['update_time'],
//                'atricles_id' => $info['atricles_id'],
//                'local_path' => $info['local_path'],
//                'url'  => $val['url'],
//                'data_type' => $type,
//                'data_status' =>1,
//            );
//            if($type=='video') {
//                $data['title'] = $val['name'];
//                $data['introduction']= $val['introduction'];
//            }
//
//            if($type=='news'){
//                $data['title'] =$val['content']['news_item'][0]['title'];
//                if(count($val['content']['news_item']) == 1){
//                    $data['data_type'] = 'atricles';
//                }
//            }
//
//            $res = $Material->add($data,$options=array(),$replace=true);
//            //echo $Material->_sql();exit;
//
//        }
        $offset =$offset+$image['item_count'];

        if($offset < $image['total_count']){
            $this->Sync($type,$offset);
        }

        return true;

    }
    /*获取永久素材列表*/
    public function getMediaList($type='news',$offset=0) {//

        $offset = WxMaterial::model()->count("data_type = '$type'");

        $token = $this->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$token;
        //$data = '{"type":"'.$type.'","offset":"'.$offset.'","count":"1"}';
        $data = '{"type":"'.$type.'","offset":"'.$offset.'","count":"1"}';
        $result_json = $this->curlPost($url,$data);
        return (json_decode($result_json,true));
        //echo   $result_json;die();

    }
    /*curl 模拟POST提交*/
    public function curlPost($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $output = curl_exec($curl);
        curl_close($curl); // 关闭CURL会话
        return $output;
    }


    public function actionGetWeixin(){
        if (empty($_REQUEST['stbid']))           throw new ExceptionEx('序列号不能为空');
//        $appid = "wx3f9bb59f5ba78010";
//        $appsecret = "5f17728db47200477af5b2d9943211b0";
//        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//        curl_close($ch);
//        $jsoninfo = json_decode($output, true);
//        $access_token = $jsoninfo["access_token"];
        $access_token = $this->getToken();
//var_dump($access_token);die;
        $id = Bdtmp::model()->find("stbid = '".$_REQUEST['stbid']."'");
        if(!$id){
            $tmp = new Bdtmp();
            $tmp->stbid = $_REQUEST['stbid'];
            $tmp->save();
            $id = $tmp->attributes['id'];
        }else{
            //$id = $id->attributes['id'];
            $id = $id['id'];
        }
        //临时
        $qrcode='{"expire_seconds": 1800,"action_name": "QR_SCENE","action_info": {"scene": {"scene_id": '.$id.'}}}';

        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        $result=$this ->https_post($url,$qrcode);
        $jsoninfo=json_decode($result,true);
        $ticket=$jsoninfo["ticket"];

        $tpurl="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";

        $this->redirect($tpurl);
    }


    function https_post($url,$data=null){
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
        if(!empty($data)){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $output=curl_exec($curl);
        curl_close($curl);
        return $output;
    }


    function downloadImageFromWeiXin($url){
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_NOBODY,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $package=curl_exec($ch);
        $httpinfo=curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body'=>$package,array('header'=>$httpinfo)));
    }
    public function actionGetParameter(){
        $this->valid(); //这个位置
        //$this->responseMsg();

    }
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //验证签名
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    public function responseMsg()
    {
        //微信发送的数据 这里接收
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //提取数据
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->handleText($postObj);
                    break;
                case "event":
                    $resultStr = $this->handleEvent($postObj);
                    break;
                default:
                    $resultStr = "Unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }
    public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $openid = $object->FromUserName;
                 $cp= Wxbox::model()->find("number='$openid'");
                if(!empty($cp['cp']) && $cp['cp'] !='8'){
                    $cps = $cp['cp'];
                }else{
                    $cps = '8';
                }
                $guanzhu = AutomaticReply::model()->find("msgtype='attention' and cp='$cps'");
                // $guanzhu = AutomaticReply::model()->find("msgtype='attention'");
                $contentStr = "$guanzhu[description]";
                //$contentStr = $object->FromUserName;
                if (isset($object->EventKey)){
                    $con=substr($object->EventKey,8);
                    $openid=$object->FromUserName;
                    //以前的获取token
                    /*$appid = "wx3f9bb59f5ba78010";
                    $appsecret = "5f17728db47200477af5b2d9943211b0";
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $jsoninfo = json_decode($output, true);
                    $access_token = $jsoninfo["access_token"];
                    */
                    $access_token=$this->getToken();//获取token
                    $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    //$this->binding($con,$output);// 放到正式服务器打开
                    $arr = $this->getIds($con,$output);
                    if($arr == 1){
                        $contentStr = "设备绑定成功";
                    }else{
                        $contentStr = "设备绑定失败";
                    }
                }
//                ob_clean();
//                echo '';
//                die();
                break;
            case "SCAN":
                $openid = $object->FromUserName;
                $cp = Wxbox::model()->find("number='$openid'");
                if(!empty($cp['cp']) && $cp['cp'] !='8'){
                    $cps = $cp['cp'];
                }else{
                    $cps = '8';
                }
                $guanzhu = AutomaticReply::model()->find("msgtype='attention' and cp='$cps'");
                // $guanzhu = AutomaticReply::model()->find("msgtype='attention'");
                $contentStr = "$guanzhu[description]";
                //$contentStr = $object->FromUserName;
                if (isset($object->EventKey)){
                    $con=$object->EventKey;
                    $openid=$object->FromUserName;
                    //以前的获取token
                    /*$appid = "wx3f9bb59f5ba78010";
                    $appsecret = "5f17728db47200477af5b2d9943211b0";
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $jsoninfo = json_decode($output, true);
                    $access_token = $jsoninfo["access_token"];
                    */
                    $access_token=$this->getToken();//获取token
                    $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    //$this->binding($con,$output);// 放到正式服务器打开
                    $arr = $this->getIds($con,$output);
                    if($arr == 1){
                        $contentStr = "设备绑定成功";
                    }else{
                        $contentStr = "设备绑定失败";
                    }
                }
//                ob_clean();
//                echo '';
//                die();
                break;
//                $openid = $object->FromUserName;
//                $cp = Wxbox::model()->find("number='$openid'");
//                if(!empty($cp['cp']) && $cp['cp'] !='8'){
//                    $cps = $cp['cp'];
//                }else{
//                    $cps = '8';
//                }
//                $guanzhu = AutomaticReply::model()->find("msgtype='attention' cp='$cps'");
//                // $guanzhu = AutomaticReply::model()->find("msgtype='attention'");
//                $contentStr = "$guanzhu[description]";
//                if (isset($object->EventKey)) {
//                    $con = $object->EventKey;
//                    $openid = $object->FromUserName;
//                    /*$appid = "wx3f9bb59f5ba78010";
//                    $appsecret = "5f17728db47200477af5b2d9943211b0";
//                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
//                    $ch = curl_init();
//                    curl_setopt($ch, CURLOPT_URL, $url);
//                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                    $output = curl_exec($ch);
//                    curl_close($ch);
//                    $jsoninfo = json_decode($output, true);
//                    $access_token = $jsoninfo["access_token"];
//                    */
//                    $access_token=$this->getToken();//获取token
//                    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid";
//                    $ch = curl_init();
//                    curl_setopt($ch, CURLOPT_URL, $url);
//                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                    $output = curl_exec($ch);
//                    curl_close($ch);
//                   // $this->getIds($con,$output);
//                    ob_clean();
//                    echo '';
////                    $arr=$this->getIds($con,$output);
////                    $resultStr = $this->responseText($object, $arr);
////                    return $resultStr;
//
//                }
//
//                break;
            case "CLICK":
                $key=$object->EventKey;
                $click = WxMenu::model()->find("btn_key='$key'");
                // $resultStr = "欢迎进入客服系统";
                if($click['description']=='客服'){
                    $result = $this->transmitService($object);
                    return $result;
                }
                //$contentStr = $click['description'];
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
    }
    public function responseText($object, $content, $flag=0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

    /**
     * @param $postObj
     */
    public function handleText($postObj)
    {
        /*$fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        if(!empty( $keyword ))
        {
            $message = AutomaticReply::model()->find("key_word='$keyword'");
            $msgType = "text";
            if(!empty($message)){
                $contentStr = "$message[description]";
            }else{
                $message = AutomaticReply::model()->find("msgtype='auto'");
                $contentStr ="$message[description]";
            }

            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;

        }else{
            echo "Input something...";
        }*/
        $keyword = trim($postObj->Content);
        if(!empty( $keyword))
        {
            //$openid = $postObj->FromUserName;
            //$cp = Wxbox::model()->find("number='$openid'");
            // $message = AutomaticReply::model()->find("key_word='$keyword' and cp='$cp[cp]'");
            $openid = $postObj->FromUserName;
            $cp = Wxbox::model()->find("number='$openid'");
            if(!empty($cp['cp']) && $cp['cp'] !='8'){
                $cps = $cp['cp'];
            }else{
                $cps = '8';
            }
            $message = AutomaticReply::model()->find("key_word  like '%$keyword%' and cp='$cps'");
            // $message = AutomaticReply::model()->find("key_word  like '%$keyword%'");
            //$message = AutomaticReply::model()->findAllBySql('select * from yd_automatic_reply where key_word like :keyword',array(':keyword' =>$keyword));



//            $connection = Yii::app()->db;
//            $sql="select * from yd_automatic_reply where key_word like '%$keyword%' limit 1";
//            $command = $connection->createCommand($sql);
//            $message = $command->queryAll();



            //如果发送的关键字没有，就回复这个
            if(empty($message)){

                //判断是不是客服
                if($keyword=='客服'){
                    $result = $this->transmitService($postObj);
                    return $result;
                }else{
                    //$message = AutomaticReply::model()->find("msgtype='auto' and cp='$cp[cp]'");
                    $message = AutomaticReply::model()->find("msgtype='auto' and cp='$cps'");
                    $content = "$message[description]";
                    //$content = $postObj->FromUserName;
                    $result = $this->transmitText($postObj, $content);
                }

            }
            if($message['msgtype']=='news'){
                $content = array();
                $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                $result = $this->transmitNews($postObj, $content);
            }
            if($message['msgtype']=='text'){
                //$message = AutomaticReply::model()->find("key_word='$keyword'");
                $content = "$message[description]";
                $result = $this->transmitText($postObj, $content);
            }
            if($message['msgtype']=='video'){
                $result = $this->transmitVideo($postObj, $message);
            }
            if($message['msgtype']=='voice'){
                $result = $this->transmitVoice($postObj, $message);
            }
            if($message['msgtype']=='image'){
                $result = $this->transmitImage($postObj,$message);
            }

        }
    }
    public function transmitService($object){
        $xmlTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
                    </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        echo $result;
    }
    //回复文本消息
    public function transmitText($object, $content){
        if (!isset($content) || empty($content)){
            return "";
        }
        $xmlTpl = "<xml>
         <ToUserName><![CDATA[%s]]></ToUserName>
         <FromUserName><![CDATA[%s]]></FromUserName>
         <CreateTime>%s</CreateTime>
         <MsgType><![CDATA[text]]></MsgType>
         <Content><![CDATA[%s]]></Content>
         </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        echo  $result;
    }
    //回复图文消息
    private function transmitNews($object, $newsArray){
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "        <item>
                 <Title><![CDATA[%s]]></Title>
                 <Description><![CDATA[%s]]></Description>
                 <PicUrl><![CDATA[%s]]></PicUrl>
                 <Url><![CDATA[%s]]></Url>
             </item>
     ";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
         <ToUserName><![CDATA[%s]]></ToUserName>
         <FromUserName><![CDATA[%s]]></FromUserName>
         <CreateTime>%s</CreateTime>
         <MsgType><![CDATA[news]]></MsgType>
         <ArticleCount>%s</ArticleCount>
         <Articles>$item_str</Articles>
         </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        echo $result;
    }
    //回复图片消息
    private function transmitImage($object,$imageArray)
    {
        $itemTpl = "<Image>
         <MediaId><![CDATA[%s]]></MediaId>
     </Image>";

        $item_str = sprintf($itemTpl,$imageArray['media_id']);

        $xmlTpl = "<xml>
     <ToUserName><![CDATA[%s]]></ToUserName>
     <FromUserName><![CDATA[%s]]></FromUserName>
     <CreateTime>%s</CreateTime>
     <MsgType><![CDATA[image]]></MsgType>
     $item_str
 </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        echo  $result;
    }
//回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
         <MediaId><![CDATA[%s]]></MediaId>
     </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['media_id']);
        $xmlTpl = "<xml>
                         <ToUserName><![CDATA[%s]]></ToUserName>
                         <FromUserName><![CDATA[%s]]></FromUserName>
                         <CreateTime>%s</CreateTime>
                         <MsgType><![CDATA[voice]]></MsgType>
                         $item_str
                    </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        echo $result;
    }
    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
         <MediaId><![CDATA[%s]]></MediaId>
         <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
         <Title><![CDATA[%s]]></Title>
         <Description><![CDATA[%s]]></Description>
     </Video>";

        $item_str = sprintf($itemTpl, $videoArray['media_id'], $videoArray['thumb_media_id'], $videoArray['title'], $videoArray['description']);

        $xmlTpl = "<xml>
     <ToUserName><![CDATA[%s]]></ToUserName>
     <FromUserName><![CDATA[%s]]></FromUserName>
     <CreateTime>%s</CreateTime>
     <MsgType><![CDATA[video]]></MsgType>
     $item_str
 </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        echo $result;
    }




    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = "Qumeng";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
//    public function binding($con, $output){
//        $id=$con;
//        $yonghu=$output;
//        $jsoninfo = json_decode($yonghu, true);
//        $openid = $jsoninfo["openid"];
//        $nickname = $jsoninfo["nickname"];
//
//        $stbid = array_map(create_function('$record','return $record->attributes;'), Bdtmp::model()->findAll("id = ".$id));
//        $stbid = isset($stbid[0]['stbid']) ? $stbid[0]['stbid'] : '';
//        $arr =   array_map(create_function('$record','return $record->attributes;'), User::model()->findAll("stbid = '".$stbid."'"));
//        $type = isset($arr[0]['type'])? $arr[0]['type'] : '0';
//        $province = isset($arr[0]['province'])? $arr[0]['province'] : '0';
//        $city = isset($arr[0]['city'])? $arr[0]['city'] : '0';
//        $cp   = isset($arr[0]['cp'])? $arr[0]['cp'] : '0';
//
//        $res = array_map(create_function('$record','return $record->attributes;'), Wxbox::model()->findAll("number = '".$openid."'"));
//        if(!empty($res)){
//            $ids = $res[0]['id'];
//            $dels = Wxbox::model()->deleteByPk($ids);
//            if(!$dels){
//                $this->die_json(array('code'=>404,'msg'=>'删除失败'));
//            }
//        }
//
//        $wxbox = new Wxbox();
//        $wxbox->number   = $openid;
//        $wxbox->name     = $nickname;
//        $wxbox->type     = $type;
//        $wxbox->province = $province;
//        $wxbox->city     = $city;
//        $wxbox->stbid    = $stbid;
//        $wxbox->cp       = $cp;
//        //$wxbox->save();
//        if(!$wxbox->save()){
//            LogWriter::logModelSaveError($wxbox,__METHOD__,$wxbox->attributes);
//            $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
//        }else{
//            echo 1;
//            $del = Bdtmp::model()->deleteByPk($id);
//            if(!$del){
//                $this->die_json(array('code'=>404,'msg'=>'删除失败'));
//            }
//        }
//
//
//    }
    public function die_json($arr = array()){
        if(empty($arr)) $arr = array();
        die(json_encode($arr));
    }
    public function getIds($con,$output){

        $id=$con;
        $yonghu=$output;
        $jsoninfo = json_decode($yonghu, true);
        $openid = $jsoninfo["openid"];
        $nickname = $jsoninfo["nickname"];

//        $id = 1;
//        $openid = 'o2S_xwEVTzw7fpT6_CnO_71xM-34';
//        $nickname='随遇而安';

//        $id=$_POST['id'];
//        $yonghu=$_POST['yonghu'];
//        $jsoninfo = json_decode($yonghu, true);
//        $openid = $jsoninfo["openid"];
//        $nickname = $jsoninfo["nickname"];

//      $id = 43;
//      $openid = 'o2S_xwMXDEwft7CP-eDywP5v2Bto';
//      $nickname = 'Steven';
//file_put_contents("/opt/tmp/test.txt",$_POST);
//$filename = '/opt/tmp/test.txt';
//            $fp = fopen($filename, "w");
//            @fwrite($fp, $id.'//'.$openid);
//            fclose($fp);


        $stbid = array_map(create_function('$record','return $record->attributes;'), Bdtmp::model()->findAll("id = ".$id));
        $stbid = isset($stbid[0]['stbid']) ? $stbid[0]['stbid'] : '';
        /*$arr =   array_map(create_function('$record','return $record->attributes;'), User::model()->findAll("stbid = '".$stbid."'"));
         $type = isset($arr[0]['type'])? $arr[0]['type'] : 'z86';
         $province = isset($arr[0]['province'])? $arr[0]['province'] : '02';
         $city = isset($arr[0]['city'])? $arr[0]['city'] : '02134';
         $cp   = isset($arr[0]['cp'])? $arr[0]['cp'] : '1';*/
        if(!empty($stbid)){
            $data=$this->getStbid($stbid);
            $arr = Wxbox::model()->findAll("number = '".$openid."'");//
            if(!empty($arr)){
                $res = array_map(create_function('$record','return $record->attributes;'),$arr);
                $ids = $res[0]['id'];
                $dels = Wxbox::model()->deleteByPk($ids);
            }

//        if(!empty($data['cp']) && $data['cp'] !='8'){
//            $cps= $data['cp'];
//        }else{
//            $cps = '8';
//        }

            $wxbox = new Wxbox();
            /*$wxbox->number   = $openid;
            $wxbox->name     = $nickname;
            $wxbox->type     = $type;
            $wxbox->province = $province;
            $wxbox->city     = $city;
            $wxbox->stbid    = $stbid;
            $wxbox->cp       = $cp;*/
            $wxbox->number   = $openid;
            $wxbox->name     = $nickname;
            $wxbox->type     = $data['type'];
            $wxbox->province = $data['province'];
            $wxbox->city     = $data['city'];
            $wxbox->stbid    = $stbid;
            $wxbox->cp       = $data['cp'];
            //$wxbox->save();
//var_dump($wxbox);
            if(!$wxbox->save()){
                LogWriter::logModelSaveError($wxbox,__METHOD__,$wxbox->attributes);
                return 2;
                //$this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
            }else{
//      echo 1;
                $del = Bdtmp::model()->deleteByPk($id);
                if(!$del){
                    //$this->die_json(array('code'=>404,'msg'=>'删除失败'));
                }
                return 1;
            }
        }



    }


    public function getStbid($stbid){
        $http_adr = 'http://bngt.itv.cmvideo.cn:8095/scspProxy';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
                    <message module="SCSP" version="1.1">
                        <header action="REQUEST" command="SCSPSTBQUERY"/>
                        <body>
                            <scspSTBQuery stbId ="'.$stbid.'" param=" "/>
                        </body>
                    </message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:textml;Charset=utf-8',
                'content' => $data
            )
        );
        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);
        $p = xml_parser_create();
        xml_parse_into_struct($p, $tmp, $vals, $index);
        xml_parser_free($p);
        $SCSPSTBQUERY = $index['SCSPSTBQUERY'][0];
        $resultDesc['province'] = $vals[$SCSPSTBQUERY]['attributes']['PROVINCEID'];
        $resultDesc['city'] = $vals[$SCSPSTBQUERY]['attributes']['CITY'];
        $resultDesc['type'] = $vals[$SCSPSTBQUERY]['attributes']['ECCODE'];
        $resultDesc['cp'] = $vals[$SCSPSTBQUERY]['attributes']['COPYRIGHTID'];
        $resultDesc['cp'] = $resultDesc['cp']-699210;
        return $resultDesc;
    }

    //生成微信菜单
    public function actionCreateWechatMenu(){
        $ListOne = WxMenu::model()->findAll(array('condition' => 'data_status=:data_status AND father_id=:father_id', 'params' => array(':data_status' => '1', ':father_id' => '0'), 'order' => 'data_sort ASC,id ASC'));

        $json='{
                                 "button":[';
        $json_ins='';
        foreach($ListOne as $key=>$value){
            $ListTwo = WxMenu::model()->findAll(array('condition' => 'data_status=:data_status AND father_id=:father_id', 'params' => array(':data_status' => '1', ':father_id' => $value['id']), 'order' => 'data_sort ASC,id ASC'));
            if(count($ListTwo)){//有子菜单
                $json_ins.=' {
                            "name": "'.$value["title"].'",
                            "sub_button": [';

                $json_i_ins='';
                foreach($ListTwo as $k=>$val){
                    //点击推事件//扫码推事件
                    //扫码推事件且弹出“消息接收中”提示框//弹出系统拍照发图
                    //弹出拍照或者相册发图//弹出微信相册发图器
                    //弹出地理位置选择器
                    if($val["data_type"]=="click" or $val["data_type"]=="scancode_push"
                        or $val["data_type"]=="scancode_waitmsg" or $val["data_type"]=="pic_sysphoto"
                        or $val["data_type"]=="pic_photo_or_album" or $val["data_type"]=="pic_weixin"
                        or $val["data_type"]=="location_select"
                    ){
                        $json_i_ins.='{
                                      "type":"'.$val["data_type"].'",
                                      "name":"'.$val["title"].'",
                                      "key":"'.$val["btn_key"].'"
                            },';
                    }else if($val["data_type"]=="view"){//跳转URL
                        $json_i_ins.='{
                                      "type":"'.$val["data_type"].'",
                                      "name":"'.$val["title"].'",
                                      "url":"'.$val["url"].'"
                            },';
                    }else if($val["data_type"]=="media_id" or $val["data_type"]=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
                        $json_i_ins.='{
                                      "type":"'.$val["data_type"].'",
                                      "name":"'.$val["title"].'",
                                      "media_id":"'.$val["media_id"].'"
                            },';
                    }else if($value["data_type"]=="click"){
                        $json_ins.='{
                                      "type":"'.$value["data_type"].'",
                                      "name":"'.$value["title"].'",
                                      "key":"'.$value["btn_key"].'"
                            },';

                    }
                }

                $json_ins.=substr($json_i_ins,0,-1);
                $json_ins.='   ]
                        }, ';
            }else{//没有子菜单
                //点击推事件//扫码推事件
                //扫码推事件且弹出“消息接收中”提示框//弹出系统拍照发图
                //弹出拍照或者相册发图//弹出微信相册发图器
                //弹出地理位置选择器
                if($value["data_type"]=="click" or $value["data_type"]=="scancode_push"
                    or $value["data_type"]=="scancode_waitmsg" or $value["data_type"]=="pic_sysphoto"
                    or $value["data_type"]=="pic_photo_or_album" or $value["data_type"]=="pic_weixin"
                    or $value["data_type"]=="location_select"
                ){
                    $json_ins.='{
                                      "type":"'.$value["data_type"].'",
                                      "name":"'.$value["title"].'",
                                      "key":"'.$value["btn_key"].'"
                            },';
                }else if($value["data_type"]=="view"){//跳转URL
                    $json_ins.='{
                                      "type":"'.$value["data_type"].'",
                                      "name":"'.$value["title"].'",
                                      "url":"'.$value["url"].'"
                            },';
                }else if($value["data_type"]=="media_id" or $value["data_type"]=="view_limited"){//下发消息（除文本消息）//跳转图文消息URL
                    $json_ins.='{
                                      "type":"'.$value["data_type"].'",
                                      "name":"'.$value["title"].'",
                                      "media_id":"'.$value["media_id"].'"
                            },';
                }else if($value["data_type"]=="click"){
                    $json_ins.='{
                                      "type":"'.$value["data_type"].'",
                                      "name":"'.$value["title"].'",
                                      "key":"'.$value["btn_key"].'"
                            },';

                }

            }

            //$value["ChildrenList"]=$ListTwo;
            //$_list[]=$value;
        }
        $json.=substr($json_ins, 0,-1);
        $json.=']
                }';
        //wirtefile($file_content);
        //echo $json;exit;
        $info=$this->WechatMenuCreate($json);
        // print_r($info);
        //die();
        if($info["errcode"]=="0"){
            echo "<script>alert('微信菜单创建成功');history.go(-1);</script>";
        }else{
            echo "<script>alert('微信菜单创建失败');history.go(-1);</script>";
        }
    }
    function wirtefile($contnet){

        $fileName=date("Ymd", time());
        $fileName=Yii::app()->basePath.'/../data/wx/'.$fileName.'.txt';
        if(!file_exists($fileName)) {
            $file = fopen("$fileName", 'a+');
            fwrite($file, date("Y-m-d H:i:s：") . $contnet . "\n");
            fclose($file);
            unset($file);
        }else{
            $file = fopen("$fileName", 'a+');
            fwrite($file, date("Y-m-d H:i:s：") . $contnet . "\n");
            fclose($file);
            unset($file);
        }
    }

    //微信菜单创建接口
    public function WechatMenuCreate($data){
        $token = $this->getToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
        $file_content=$this->curlPost($url,$data);
        if(stripos($file_content,"errcode")!==false){$this->wirtefile($file_content);}
        $file_content=(Array)json_decode($file_content);

        return $file_content;
    }




}
?>
