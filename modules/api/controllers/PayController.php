<?php
/**
 *created by PhpStorm.
 * User: xzm
 */
class PayController extends PController{

    //1、鉴权询价接口
    public function actionInquiry()
    {
        if (empty($_REQUEST['userId']))           throw new ExceptionEx('发起方用户id不能为空');
        if (empty($_REQUEST['terminalId']))       throw new ExceptionEx('终端标识不能为空');
        if (empty($_REQUEST['copyRightId']))      throw new ExceptionEx('牌照方标识不能为空');
        if (!isset($_REQUEST['systemId']))        throw new ExceptionEx('发起方系统标识不能为空');
        if (empty($_REQUEST['contentId']))        throw new ExceptionEx('内容标识不能为空');
        if (empty($_REQUEST['consumeLocal']))     throw new ExceptionEx('消费地域不能为空');
        if (empty($_REQUEST['consumeScene']))     throw new ExceptionEx('消费场景不能为空');
        if (empty($_REQUEST['consumeBehaviour'])) throw new ExceptionEx('消费行为不能为空');
        if (empty($_REQUEST['token']))            throw new ExceptionEx('(UserId)登录的token标识不能为空');

        $subContentId = isset($_REQUEST['subContentId']) ? $_REQUEST['subContentId'] : '';
        $path = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
        $http_adr = 'http://172.17.90.133:8989/cmcc/interface';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
                    <message module="SCSP" version="1.1">
                        <header action="REQUEST" command="AUTHORIZE"/>
                        <body>
                            <authorize userId="'.$_REQUEST['userId'].'" terminalId="'.$_REQUEST['terminalId'].'" contentId="contentId" subContentId="'.$subContentId.'" systemId="'.$_REQUEST['systemId'].'" copyRightId="'.$_REQUEST['copyRightId'].'" consumeLocal="'.$_REQUEST['consumeLocal'].'" consumeScene="'.$_REQUEST['consumeScene'].'" consumeBehaviour="'.$_REQUEST['consumeBehaviour'].'"  path="'.$path.'" token="'.$_REQUEST['token'].'"/>
                        </body>
                    </message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:text/html;Charset=utf-8',
                'content' => $data
            )
        );

        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);
        $xml = simplexml_load_string ( $tmp, 'SimpleXMLElement', LIBXML_NOCDATA );

        $json = json_encode($xml);
        $tmp = json_decode($json, true);
	echo json_encode($tmp['body']['authorize']['@attributes']);

/*
	$arr['result']="20";
	$arr['accountIdentify']='15710142516';
        $arr['resultDesc']="账户的计费标识需要验证";
        $arr['accountIdentifyPhone']="15710142516";
        $arr['productToOrderList']['0']['type']="1";
        $arr['productToOrderList']['0']['productCode']="1234";
        $arr['productToOrderList']['0']['orderContentId']="45678";
        $arr['productToOrderList']['0']['productInfo']="点播包月";
        $arr['productToOrderList']['0']['productPrice']="50";
        $arr['productToOrderList']['0']['price']="5";
        $arr['productToOrderList']['1']['type']="2";
        $arr['productToOrderList']['1']['productCode']="1234";
        $arr['productToOrderList']['1']['orderContentId']="45678";
        $arr['productToOrderList']['1']['productInfo']="单集";
        $arr['productToOrderList']['1']['productPrice']="25";
        $arr['productToOrderList']['1']['price']="5";
        echo $json=json_encode($arr);
  */     
    }
    //2、验证计费标识接口
    public function actionVerify(){
        if(empty($_REQUEST['userId']))           throw new ExceptionEx('发起方用户id不能为空');
        if(empty($_REQUEST['terminalId']))       throw new ExceptionEx('终端标识不能为空');
        if(empty($_REQUEST['copyRightId']))      throw new ExceptionEx('牌照方标识不能为空');
        if(!isset($_REQUEST['systemId']))        throw new ExceptionEx('发起方系统标识不能为空');
        if(empty($_REQUEST['accountIdentifyPhone']))        throw new ExceptionEx('计费标识需要验证的手机号不能为空');
        if(!isset($_REQUEST['passcode']))         throw new ExceptionEx('计费验证手机号的短信验证码不能为空');
        if(empty($_REQUEST['token']))            throw new ExceptionEx('(UserId)登录的token标识不能为空');
        $http_adr = 'http://172.17.90.133:8989/cmcc/interface';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
					<message module="SCSP" version="1.1">
					<header action="REQUEST" command="ACCOUNTIDENTIFYVERIFY"/>
					<body>
					<accountIdentifyVerify userId="'.$_REQUEST['userId'].'" terminalId="'.$_REQUEST['terminalId'].'" systemId="'.$_REQUEST['systemId'].'" copyRightId="'.$_REQUEST['copyRightId'].'" accountIdentifyPhone="'.$_REQUEST['accountIdentifyPhone'].'" passcode="'.$_REQUEST['passcode'].'" token="'.$_REQUEST['token'].'"/>
					</body>
					</message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:text/html;Charset=utf-8',
                'content' => $data
            )
        );

        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);

        $xml = simplexml_load_string ( $tmp, 'SimpleXMLElement', LIBXML_NOCDATA );

        $json = json_encode($xml);
        $tmps = json_decode($json, true);
       // var_dump($tmp);
//        echo json_encode($tmps['body']['accountIdentifyVerify']['@attributes']);
//	echo json_encode($tmps);
	
	$arr['result']="0";
        $arr['resultDesc']="缺少必要参数";
        echo $json=json_encode($arr);
    }
    //3、订购
    public function actionOrder(){
        if(empty($_REQUEST['seqId']))            throw new ExceptionEx('请求序列号标识不能为空');
        if(empty($_REQUEST['userId']))           throw new ExceptionEx('发起方用户标识不能为空');
        if(empty($_REQUEST['accountIdentify']))  throw new ExceptionEx('订购使用的计费标识');
        if(empty($_REQUEST['terminalId']))       throw new ExceptionEx('终端标识');
        if(empty($_REQUEST['copyRightId']))      throw new ExceptionEx('牌照方标识');
        if(!isset($_REQUEST['systemId']))        throw new ExceptionEx('发起方终端类型标识');
        if(empty($_REQUEST['productCode']))      throw new ExceptionEx('订购的产品标识');
        if(empty($_REQUEST['contentId']))        throw new ExceptionEx('内容标识');
        if(empty($_REQUEST['orderContentId']))   throw new ExceptionEx('订购接口返回的内容标识');
        if(empty($_REQUEST['token']))            throw new ExceptionEx('(UserId)登录的token标识');

        $consumeLocal     = isset($_REQUEST['consumeLocal']) ? $_REQUEST['consumeLocal'] : '';
        $consumeScene     = isset($_REQUEST['consumeScene']) ? $_REQUEST['consumeScene'] : '';
        $consumeBehaviour = isset($_REQUEST['consumeBehaviour']) ? $_REQUEST['consumeBehaviour'] : '';
        $path             = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
        $http_adr = 'http://172.17.90.133:8989/cmcc/interface';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
				<message module="SCSP" version="1.1">
				<header action="REQUEST" command="ORDER"/>
				<body>
				<order seqId="'.$_REQUEST['seqId'].'" userId="'.$_REQUEST['userId'].'" terminalId="'.$_REQUEST['terminalId'].'"  systemId="'.$_REQUEST['systemId'].'" copyRightId="'.$_REQUEST['copyRightId'].'" productCode="'.$_REQUEST['productCode'].'"  accountIdentify="'.$_REQUEST['accountIdentify'].'" contentId="'.$_REQUEST['contentId'].'" orderContentId="'.$_REQUEST['orderContentId'].'" consumeLocal="'.$consumeLocal.'" consumeScene="'.$consumeScene.'" consumeBehaviour="'.$consumeBehaviour.'" path="'.$path.'" token="'.$_REQUEST['token'].'" />
				</body>
				</message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:text/html;Charset=utf-8',
                'content' => $data
            )
        );

        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);
        $xml = simplexml_load_string ( $tmp, 'SimpleXMLElement', LIBXML_NOCDATA );

        $json = json_encode($xml);
        $tmps = json_decode($json, true);
        echo json_encode($tmps['body']['order']['@attributes']);

    }
    //4、短信发送接口
    public function actionSend(){
        if(!isset($_REQUEST['operation']))   throw new ExceptionEx('操作类型');
        if(empty($_REQUEST['phoneNumber']))  throw new ExceptionEx('手机号码');
        $content  = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $token    = isset($_REQUEST['token']) ? $_REQUEST['content'] : '';
	$http_adr = 'http://172.17.90.133:8989/cmcc/interface';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
				<message module="SCSP" version="1.1">
				<header action="REQUEST" command="SMSSEND"/>
				<body>
				<smsSend operation="'.$_REQUEST['operation'].'" phoneNumber="'.$_REQUEST['phoneNumber'].'" content="'.$content.'" token="'.$token.'"/>
				</body>
				</message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:text/html;Charset=utf-8',
                'content' => $data
            )
        );

        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);
        $xml = simplexml_load_string ( $tmp, 'SimpleXMLElement', LIBXML_NOCDATA );

        $json = json_encode($xml);
        $tmps = json_decode($json, true);
        echo json_encode($tmps['body']['smsSend']['@attributes']);
    }

    public function actionMessage(){
        if (empty($_REQUEST['contentId'])) throw new ExceptionEx('内容id不能为空');
        $message = array_map(create_function('$record','return $record->attributes;'),UiPay::model()->findAllBySql("select p.duration,p.year,p.country,p.form,p.hot,p.director,p.actor,p.epitasis from yd_ui as u JOIN  yd_ui_pay as p on p.u_id=u.id and u.url = ".$_REQUEST['contentId']));
        echo json_encode($message);

    }


    public function actionPay(){
        if (empty($_REQUEST['stbId']))         throw new ExceptionEx('stbId不能为空');
        if (empty($_REQUEST['usergroup']))     throw new ExceptionEx('usergroup不能为空');
        if (empty($_REQUEST['authCode']))      throw new ExceptionEx('authCode不能为空');

        $res['link'] = 'http://gslbserv.itv.cmvideo.cn:80/123.m3u8?channel-id=wasusyt&Contentid=8835439207829435185&stbId='.$_REQUEST['stbId'].'&usergroup='.$_REQUEST['usergroup'].'&livemode=1&authCode='.$_REQUEST['authCode'].'';
        echo json_encode($res);
    }

    public function actionIndex(){
        $_REQUEST['operation']=1;
        $_REQUEST['phoneNumber']='13054999999';
        $_REQUEST['content']='111';
        $_REQUEST['token'] = '11111111';
        $http_adr = 'http://172.17.90.133:8989/cmcc/interface';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
				<message module="SCSP" version="1.1">
				<header action="REQUEST" command="SMSSEND"/>
				<body>
				<smsSend operation='.$_REQUEST['operation'].' phoneNumber='.$_REQUEST['phoneNumber'].' content='.$_REQUEST['content'].' token='.$_REQUEST['token'].'/>
				</body>
				</message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:text/html;Charset=utf-8',
                'content' => $data
            )
        );
       // var_dump($data);


        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);
        //var_dump($tmp);
        echo json_encode($tmp);
    }
    public function actionTextss()
    {
        $http_adr = 'http://172.17.90.133:8989/cmcc/interface';
        $data = '<?xml version="1.0" encoding="UTF-8"?>
                    <message module="SCSP" version="1.1">
                        <header action="REQUEST" command="AUTHORIZE"/>
                        <body>
                            <authorize userId="363016321" terminalId="004001FF003182A001E5000763F5602E" contentId="3001275806" subContentId="" systemId="0" copyRightId="699211" consumeLocal="02" consumeScene="02" consumeBehaviour="03" path="" token="9d420901e78af21a3f192c08710741c4
"/>
                        </body>
                    </message>';
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:text/html;Charset=utf-8',
                'content' => $data
            )
        );

        $context = stream_context_create($opts);
        $tmp = file_get_contents($http_adr, false, $context);
        $xml = simplexml_load_string ( $data, 'SimpleXMLElement', LIBXML_NOCDATA );

        //echo json_encode($tmp);

        $json = json_encode($xml);
        $tmp = json_decode($json, true);
        echo json_encode($tmp['body']['authorize']['@attributes']);

    }
}

?>
