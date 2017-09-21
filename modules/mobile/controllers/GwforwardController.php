<?php

class GwforwardController extends MController
{
    //公网盒子添加收藏
   public function actionGwAddCollection()
   {
        $ip   = "10.200.43.228";
        $port = "18080";
        $userId     = isset($_REQUEST['userId'])?trim($_REQUEST['userId']):'';
        $contentId  = isset($_REQUEST['contentId'])?trim($_REQUEST['contentId']):'';
        $mId        = isset($_REQUEST['mId'])?trim($_REQUEST['mId']):'';
        $type       = isset($_REQUEST['type'])?trim($_REQUEST['type']):'';
        $platform   = isset($_REQUEST['platform'])?trim($_REQUEST['platform']):'';
        $nodeId     = isset($_REQUEST['nodeId'])?trim($_REQUEST['nodeId']):'';
        $mobile     = isset($_REQUEST['mobile'])?trim($_REQUEST['mobile']):'';
        $name       = isset($_REQUEST['name'])?trim($_REQUEST['name']):'';
        $urlPath    = isset($_REQUEST['urlPath'])?trim($_REQUEST['urlPath']):'';
        $channelType = isset($_REQUEST['channelType'])?trim($_REQUEST['channelType']):'';
        $hwId       = isset($_REQUEST['hwId'])?trim($_REQUEST['hwId']):'';
        $contName   = isset($_REQUEST['contName'])?trim($_REQUEST['contName']):'';
        $filmType   = isset($_REQUEST['filmType'])?trim($_REQUEST['filmType']):'';
        $filmScore  = isset($_REQUEST['filmScore'])?trim($_REQUEST['filmScore']):'';
        $posterUrl  = isset($_REQUEST['posterUrl'])?trim($_REQUEST['posterUrl']):'';
        $releaseDate = isset($_REQUEST['releaseDate'])?trim($_REQUEST['releaseDate']):'';
        $totalTime  = isset($_REQUEST['totalTime'])?trim($_REQUEST['totalTime']):'';
        $path       = isset($_REQUEST['path'])?trim($_REQUEST['path']):'';
        $blogId     = isset($_REQUEST['blogId'])?trim($_REQUEST['blogId']):'';
        $weChatId   = isset($_REQUEST['weChatId'])?trim($_REQUEST['weChatId']):'';
        $source     = isset($_REQUEST['source'])?trim($_REQUEST['source']):'';

	$requestUrl = "http://$ip:$port/uic-service/favroites/add";
        if(!empty($userId)){
            $requestUrl .= "?userId=$userId";
        }
        if(!empty($contentId)){
            $requestUrl .= "&contentId=$contentId";
        }
        if(!empty($mId)){
            $requestUrl .= "&mId=$mId";
        }
        if(!empty($platform)){
            $requestUrl .= "&platform=$platform";
        }
        if(!empty($type)){
            $requestUrl .= "&type=$type";
        }
        if(!empty($nodeId)){
            $requestUrl .= "&nodeId=$nodeId";
        }
        if(!empty($mobile)){
            $requestUrl .= "&mobile=$mobile";
        }
        if(!empty($name)){
            $requestUrl .= "&name=$name";
        }
        if(!empty($urlPath)){
            $requestUrl .= "&urlPath=$urlPath";
        }
        if(!empty($channelType)){
            $requestUrl .= "&channelType=$channelType";
        }
        if(!empty($hwId)){
            $requestUrl .= "&hwId=$hwId";
        }
        if(!empty($contName)){
            $requestUrl .= "&contName=$contName";
        }
        if(!empty($udid)){
            $requestUrl .= "&udid=$udid";
        }
        if(!empty($filmType)){
            $requestUrl .= "&filmType=$filmType";
        }
        if(!empty($totalTime)){
            $requestUrl .= "&totalTime=$totalTime";
        }
        if(!empty($path)){
            $requestUrl .= "&path=$path";
        }
        if(!empty($blogId)){
            $requestUrl .= "&blogId=$blogId";
        }
        if(!empty($weChatId)){
            $requestUrl .= "&weChatId=$weChatId";
        }
        if(!empty($filmScore)){
            $requestUrl .= "&filmScore=$filmScore";
        }
        if(!empty($posterUrl)){
            $requestUrl .= "&posterUrl=$posterUrl";
        }
        if(!empty($releaseDate)){
            $requestUrl .= "&releaseDate=$releaseDate";
        }
        if(!empty($source)){
            $requestUrl .= "&source=$source";
        }

        $res = file_get_contents($requestUrl);
        echo $res;

   }

    //公网盒子查询收藏
   public function actionGwSelectCollection()
   {
       $ip   = "10.200.43.228";
       $port = "18080";
       $userId      = isset($_REQUEST['userId'])?trim($_REQUEST['userId']):'';
       $otherUserId = isset($_REQUEST['otherUserId'])?trim($_REQUEST['otherUserId']):'';
       $type        = isset($_REQUEST['type'])?trim($_REQUEST['type']):'';
       $start       = isset($_REQUEST['start'])?trim($_REQUEST['start']):'';
       $limit       = isset($_REQUEST['limit'])?trim($_REQUEST['limit']):'';
       $all         = isset($_REQUEST['all'])?trim($_REQUEST['all']):'';
       $platformIds = isset($_REQUEST['platformIds'])?trim($_REQUEST['platformIds']):'';
       $platform    = isset($_REQUEST['platform'])?trim($_REQUEST['platform']):'';
       $prdInfoIds  = isset($_REQUEST['prdInfoIds'])?trim($_REQUEST['prdInfoIds']):'';
       $requestUrl = "http://$ip:$port/uic-service/favroites/select";
        if(!empty($userId)){
            $requestUrl .= "?userId=$userId";
        }
        if(!empty($otherUserId)){
            $requestUrl .= "&otherUserId=$otherUserId";
        }
        if(!empty($type)){
            $requestUrl .= "&type=$type";
        }
        if(!empty($platformIds)){
            $requestUrl .= "&platformIds=$platformIds";
        }
        if(!empty($platform)){
            $requestUrl .= "&platform=$platform";
        }
        if(!empty($start)){
            $requestUrl .= "&start=$start";
        }
        if(!empty($limit)){
            $requestUrl .= "&limit=$limit";
        }
        if(!empty($all)){
            $requestUrl .= "&all=$all";
        }
        if(!empty($prdInfoIds)){
            $requestUrl .= "&prdInfoIds=$prdInfoIds";
        }
		
       //$requestUrl = "http://$ip:$port/uic-service/favroites/select?userId=$userId&type=$type&platformIds=$platformIds&platform=$platform&start=$start&limit=$limit&all=$all&prdInfoIds=$prdInfoIds&otherUserId=$otherUserId";
       $res = file_get_contents($requestUrl);
       //echo $res;
	//$res = '{"count":1,"resultCode":"0000","resultDesc":"Success","collections":[{"favoritesid":1229,"contentId":627113847,"mId":5100194276,"nodeId":null,"mobile":null,"name":null,"urlPath":null,"channelType":null,"userId":740064455,"hwId":null,"contName":null,"udid":null,"platform":"0005","totalTime":null,"createTime":"2017-08-16 14:31:08","path":null,"blogId":null,"part":15,"type":"1","weChatId":null,"filmType":null,"filmScore":null,"posterUrl":null,"releaseDate":null,"source":null},{"favoritesid":1229,"contentId":626277592,"mId":5100194276,"nodeId":null,"mobile":null,"name":null,"urlPath":null,"channelType":null,"userId":740064455,"hwId":null,"contName":null,"udid":null,"platform":"0005","totalTime":null,"createTime":"2017-08-16 14:31:08","path":null,"blogId":null,"part":15,"type":"1","weChatId":null,"filmType":null,"filmScore":null,"posterUrl":null,"releaseDate":null,"source":null}]}';
	$res_arr = json_decode($res);
	//print_r($res_arr);die;
        $tmp_vid = array();
        $tmp_vid_key = array();
        if($res_arr->resultCode == '0000'){
            foreach ($res_arr->collections as $k=>$v){
		if(empty($v->contentId)){
                	$tmp_vid[] = null;
			$tmp_vid_key[] = null;
		}else{
                        $tmp_vid[] = $v->contentId;
			$tmp_vid_key[] = $k; 	
		}
            }
        }
	$res_local = '';
        if(!empty($tmp_vid)){
	    foreach($tmp_vid as $a=>$b){
		if(empty($b)){
			unset($tmp_vid[$a]);
			 unset($tmp_vid_key[$a]);
		}
	    }	
	    if(count($tmp_vid)>1){
                 $vids = implode(",",$tmp_vid);
                 $keys = implode(",",$tmp_vid_key);
             }else{
                 $offset = array_keys($tmp_vid);
                 $offset_key = array_keys($tmp_vid_key);
                 $vids = $tmp_vid[$offset[0]];
                 $keys = $tmp_vid_key[$offset_key[0]];
             }		
            //$vids = implode(",",$tmp_vid);
            //$url = "http://10.200.85.107:8080/mobile/default/GwSelectCollectionForward";
	    $url = "http://127.0.0.1:8080/mobile/gw/GwSelectCollectionForward";
            $info  = array('vids'=>$vids,'keys'=>$keys);
	    //var_dump($info);die;	
            $context = stream_context_create(array(
                'http' => array(
                  'method' => 'POST',
                  'header' => 'Content-type:application/x-www-form-urlencoded',
                  'content' => http_build_query($info),
                  'timeout' => 30
                )
            ));
            $res_local = file_get_contents($url, false, $context);		
        }
//        $res_local = '[{"url":"http:\/\/pic-portal-v3.itv.cmvideo.cn:8083\/file\/5500083989_cklz_V34_sc.jpg","vid":"626277592","title":"\u300a\u523a\u5ba2\u5217\u4f20\u300b\u7b2c08\u96c6"},{"url":"http:\/\/pic-portal-v3.itv.cmvideo.cn:8083\/file\/5500269068_wdgl_V23_sc.jpg","vid":"627113847","title":"\u300a\u5367\u5e95\u5f52\u6765\u300b\u7b2c01\u96c6"}]';
        $res_new = array();
        if(strlen($res_local)>2){
            $res_local = json_decode($res_local);
            foreach ($res_local as $k=>$v){
                $object[$k] = json_decode( json_encode($res_arr->collections[$k]),true);
		if($object[$k]['contentId'] == $v->vid){
                	$object[$k]['title'] = $v->title;
                	$object[$k]['url'] = $v->url;
                	$object[$k]['cid'] = $v->cid;
		}	
            }
        }else{
            $object = array();
            $tmp = array();
        }
        if(!empty($object)){
		ksort($object);
                foreach($object as $k=>$v){
                        $tmp[] = $v;
                }
        }
        $res_new['count'] = $res_arr->count;
        $res_new['resultCode'] = $res_arr->resultCode;
        $res_new['resultDesc'] = $res_arr->resultDesc;
        $res_new['collections'] = $tmp;
        echo json_encode($res_new);
   }	

   //公网盒子删除收藏接口
   public function actionGwDelCollection()
   {
	$ip   = "10.200.43.228";
        $port = "18080";
	$userId  = isset($_REQUEST['userId'])?trim($_REQUEST['userId']):'';		
	$platform  = isset($_REQUEST['platform'])?trim($_REQUEST['platform']):'';		
	$type  = isset($_REQUEST['type'])?trim($_REQUEST['type']):'';		
	$favoritesIds  = isset($_REQUEST['favoritesIds'])?trim($_REQUEST['favoritesIds']):'';		
	$cleanUp  = isset($_REQUEST['cleanUp'])?trim($_REQUEST['cleanUp']):'';		
        $requestUrl = "http://$ip:$port/uic-service/favroites/remove";
	if(!empty($userId)){
            $requestUrl .= "?userId=$userId";
        }
        if(!empty($cleanUp)){
            $requestUrl .= "&cleanUp=$cleanUp";
        }
        if(!empty($favoritesIds)){
            $requestUrl .= "&favoritesIds=$favoritesIds";
        }
        if(!empty($type)){
            $requestUrl .= "&type=$type";
        }
        if(!empty($platform)){
            $requestUrl .= "&platform=$platform";
        }
	//$requestUrl = "http://$ip:$port/uic-service/favroites/remove?userId=$userId&cleanUp=$cleanUp&favoritesIds=$favoritesIds&type=$type&platform=$platform";
       $res = file_get_contents($requestUrl);
       echo $res;
   }		

  //公网盒子添加播放历史
    public function actionGwAddPlayHistory()
    {
        $requestIp   = "10.200.43.228";
        $port = "18080";
        $contId     = isset($_REQUEST['contId'])?trim($_REQUEST['contId']):'';
        $mId        = isset($_REQUEST['mId'])?trim($_REQUEST['mId']):'';
        $mobile     = isset($_REQUEST['mobile'])?trim($_REQUEST['mobile']):'';
        $totalTime  = isset($_REQUEST['totalTime'])?trim($_REQUEST['totalTime']):'';
        $currTime   = isset($_REQUEST['currTime'])?trim($_REQUEST['currTime']):'';
        $platform   = isset($_REQUEST['platform'])?trim($_REQUEST['platform']):'';
        $playType   = isset($_REQUEST['playType'])?trim($_REQUEST['playType']):'';
        $ip         = isset($_REQUEST['ip'])?trim($_REQUEST['ip']):'';
        $userId     = isset($_REQUEST['userId'])?trim($_REQUEST['userId']):'';
        $hwId       = isset($_REQUEST['hwId'])?trim($_REQUEST['hwId']):'';
        $contName   = isset($_REQUEST['contName'])?trim($_REQUEST['contName']):'';
        $udid       = isset($_REQUEST['udid'])?trim($_REQUEST['udid']):'';
        $isLive     = isset($_REQUEST['isLive'])?trim($_REQUEST['isLive']):'';
        $nodeId     = isset($_REQUEST['nodeId'])?trim($_REQUEST['nodeId']):'';
        $path       = isset($_REQUEST['path'])?trim($_REQUEST['path']):'';
        $source     = isset($_REQUEST['source'])?trim($_REQUEST['source']):'';
	$requestUrl = "http://$requestIp:$port/uic-service/playHistory/add";
        if(!empty($userId)){
            $requestUrl .= "?userId=$userId";
        }
        if(!empty($contId)){
            $requestUrl .= "&contId=$contId";
        }
        if(!empty($mId)){
            $requestUrl .= "&mId=$mId";
        }
        if(!empty($platform)){
            $requestUrl .= "&platform=$platform";
        }
        if(!empty($mobile)){
            $requestUrl .= "&mobile=$mobile";
        }
        if(!empty($totalTime)){
            $requestUrl .= "&totalTime=$totalTime";
        }
        if(!empty($currTime)){
            $requestUrl .= "&currTime=$currTime";
        }
        if(!empty($playType)){
            $requestUrl .= "&playType=$playType";
        }
        if(!empty($ip)){
            $requestUrl .= "&ip=$ip";
        }
        if(!empty($hwId)){
            $requestUrl .= "&hwId=$hwId";
        }
        if(!empty($contName)){
            $requestUrl .= "&contName=$contName";
        }
        if(!empty($udid)){
            $requestUrl .= "&udid=$udid";
        }
        if(!empty($isLive)){
            $requestUrl .= "&isLive=$isLive";
        }
        if(!empty($nodeId)){
            $requestUrl .= "&nodeId=$nodeId";
        }
        if(!empty($path)){
            $requestUrl .= "&path=$path";
        }
        if(!empty($source)){
            $requestUrl .= "&source=$source";
        }
        //$requestUrl = "http://$requestIp:$port/uic-service/playHistory/add?userId=$userId&contId=$contId&mId=$mId&platform=$platform&mobile=$mobile&totalTime=$totalTime&currTime=$currTime&playType=$playType&ip=$ip&hwId=$hwId&contName=$contName&udid=$udid&isLive=$isLive&nodeId=$nodeId&path=$path&source=$source";
        $res = file_get_contents($requestUrl);
        echo $res;
    }

    //公网盒子查询播放历史
    public function actionGwSelectPlayHistory()
    {
        $requestIp   = "10.200.43.228";
        $port = "18080";
        $userId     = isset($_REQUEST['userId'])?trim($_REQUEST['userId']):'';
        $start      = isset($_REQUEST['start'])?trim($_REQUEST['start']):'0';
        $limit      = isset($_REQUEST['limit'])?trim($_REQUEST['limit']):'20';
        $platform   = isset($_REQUEST['platform'])?trim($_REQUEST['platform']):'';
        $platformIds= isset($_REQUEST['platformIds'])?trim($_REQUEST['platformIds']):'';
        $all        = isset($_REQUEST['all'])?trim($_REQUEST['all']):'';
        $isMonthAgo = isset($_REQUEST['isMonthAgo'])?trim($_REQUEST['isMonthAgo']):'';
        $otherUserId= isset($_REQUEST['otherUserId'])?trim($_REQUEST['otherUserId']):'';
        $prdInfoIds = isset($_REQUEST['prdInfoIds'])?trim($_REQUEST['prdInfoIds']):'';
	$requestUrl = "http://$requestIp:$port/uic-service/playHistory/query";
        if(!empty($userId)){
            $requestUrl .= "?userId=$userId";
        }
        if(!empty($all)){
            $requestUrl .= "&all=$all";
        }
        if(!empty($platform)){
            $requestUrl .= "&platform=$platform";
        }
        if(!empty($platformIds)){
            $requestUrl .= "&platformIds=$platformIds";
        }
        if(!empty($isMonthAgo)){
            $requestUrl .= "&isMonthAgo=$isMonthAgo";
        }
        if(!empty($start)){
            $requestUrl .= "&start=$start";
        }
        if(!empty($limit)){
            $requestUrl .= "&limit=$limit";
        }
        if(!empty($otherUserId)){
            $requestUrl .= "&otherUserId=$otherUserId";
        }
        if(!empty($prdInfoIds)){
            $requestUrl .= "&prdInfoIds=$prdInfoIds";
        }
        //$requestUrl = "http://$requestIp:$port/uic-service/playHistory/query?userId=$userId&all=$all&platform=$platform&platformIds=$platformIds&isMonthAgo=$isMonthAgo&start=$start&limit=$limit&otherUserId=$otherUserId&prdInfoIds=$prdInfoIds";
        $res = file_get_contents($requestUrl);
        //echo $res;die;
	$res_arr = json_decode($res);
        $tmp_vid = array();
        $tmp_vid_key = array();
        if($res_arr->resultCode == '0000'){
            foreach ($res_arr->PHList as $k=>$v){
                $tmp_vid[] = $v->contId;
		$tmp_vid_key[] = $k;
            }
        }
	$res_local = '';
        if(!empty($tmp_vid)){
	    foreach($tmp_vid as $a=>$b){
                if(empty($b)){
                        unset($tmp_vid[$a]);
                        unset($tmp_vid_key[$a]);
                }
            }
            if(count($tmp_vid)>1){
                $vids = implode(",",$tmp_vid);
                $keys = implode(",",$tmp_vid_key);
            }else{
                $offset = array_keys($tmp_vid);
                $offset_key = array_keys($tmp_vid_key);
                $vids = $tmp_vid[$offset[0]];
                $keys = $tmp_vid_key[$offset_key[0]];
            }	
	    //var_dump($vids);	
	    //var_dump($keys);die;	
            //$vids = implode(",",$tmp_vid);
            //$url = "http://10.200.85.107:8080/mobile/default/GwSelectCollectionForward";
            $url = "http://127.0.0.1:8080/mobile/gw/GwSelectCollectionForward";
	    $info  = array('vids'=>$vids,'keys'=>$keys);
            $context = stream_context_create(array(
                'http' => array(
                  'method' => 'POST',
                  'header' => 'Content-type:application/x-www-form-urlencoded',
                  'content' => http_build_query($info),
                  'timeout' => 20
                )
            ));	
	    $res_local = file_get_contents($url, false, $context);	
        }
        $res_new = array();
        if(strlen($res_local)>2){
            $res_local = json_decode($res_local);
            foreach ($res_local as $k=>$v){
		$object[$k] = json_decode( json_encode($res_arr->PHList[$k]),true);
		//if($object[$k]['contId'] == $v->vid){
                        $object[$k]['title'] = $v->title;
                        $object[$k]['url'] = $v->url;
                        $object[$k]['cid'] = $v->cid;
                        $object[$k]['vid'] = $v->vid;
                //}
            }
        }else{
            $object = array();
            $tmp = array();
        }
	if(!empty($object)){
		ksort($object);
		foreach($object as $k=>$v){
			$tmp[] = $v;
		}
	}
        $res_new['count'] = $res_arr->count;
        $res_new['resultCode'] = $res_arr->resultCode;
        $res_new['resultDesc'] = $res_arr->resultDesc;
        $res_new['PHList'] = $tmp;
        echo json_encode($res_new);
    }
 
    //公网盒子删除播放历史	
    public function actionGwDelPlayHistory()
    {
	$requestIp   = "10.200.43.228";
        $port = "18080";
        $userId     = isset($_REQUEST['userId'])?trim($_REQUEST['userId']):'';
	$platform   = isset($_REQUEST['platform'])?trim($_REQUEST['platform']):'';
	$mId   = isset($_REQUEST['mId'])?trim($_REQUEST['mId']):'';
	$cleanUp   = isset($_REQUEST['cleanUp'])?trim($_REQUEST['cleanUp']):'';
	$requestUrl = "http://$requestIp:$port/uic-service/playHistory/delete";
        if(!empty($userId)){
            $requestUrl .= "?userId=$userId";
        }
        if(!empty($mId)){
            $requestUrl .= "&mId=$mId";
        }
        if(!empty($platform)){
            $requestUrl .= "&platform=$platform";
        }
        if(isset($cleanUp)){
            $requestUrl .= "&cleanUp=$cleanUp";
        }
	//$requestUrl = "http://$requestIp:$port/uic-service/playHistory/delete?userId=$userId&mId=$mId&platform=$platform&cleanUp=$cleanUp";
        $res = file_get_contents($requestUrl);
        echo $res;
    }	



}
