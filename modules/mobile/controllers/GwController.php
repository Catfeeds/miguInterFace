<?php

class GwController extends MController
{
   public function actionGetGwHomeTab()
    {
        $res=array();
        $station_id = isset($_REQUEST['stationId'])?$_REQUEST['stationId']:STATIONID;
        //$sql = "select a.id as gid,a.title,a.pic_true as ico_true,a.pic_false as ico_false,a.pic_three as ico_three,a.focus from yd_ver_screen_guide as a where a.gid in (32,9) order by a.`order`";
        $sql = "select a.id as gid,a.title,a.pic_true as ico_true,a.pic_false as ico_false,a.pic_three as ico_three,a.focus from yd_ver_screen_guide as a where a.gid=$station_id order by a.`order`";
        $sql_res = SQLManager::queryAll($sql);
        $logo_sql = "select logo,guide,message from yd_ver_station where id=$station_id";
        $logo_res = SQLManager::queryRow($logo_sql);
        if(!empty($sql_res) && !empty($logo_res)){
            $guide = $logo_res['guide'];
            $message = $logo_res['message'];
            if($guide==2){//导航不显示
                $guide=1;//和前端规定为1不显示
            }else{
                $guide=0;
            }
            if($message==2){
                $message=1;
            }else{
                $message=0;
            }
            $res['logo'] = $logo_res['logo'];
            $res['tabs'] = $sql_res;
            $res['guide'] = $guide;
            $res['message'] = $message;
            $err = 0;
        }else{
            $err = 1;
        }
        $res['err']=$err;
        echo json_encode($res);
    }

    public function actionGetEpgContent()
    {
        $err = 0;
        if(!empty($_REQUEST['gid'])){
            $gid = $_REQUEST['gid'];
        }else{
            $err = '1';
            $list['err'] = $err;
            echo json_encode($list);
            return;
        }

        $cacheId = 'GetEpgContent'.'?gid='.$_REQUEST['gid'];

        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $sql = "select upTime from yd_ver_screen_content where `screenGuideId`=$gid group by upTime order by upTime desc";
            $res = SQLManager::queryAll($sql);
            $data=array();
            if(empty($res)){
                return null;
            }else{
                $data['updateTime']= $res[0]['upTime'];
            }
            //$res['updateTime'] = VerScreenContentManager::getEpgContentUpdateTime(8);
            $data['err'] = '0';
            //$data['list'] = VerScreenContentManager::getEpgContent($gid);
            $info = array();
            $sql_select="select c.type,c.tType, g.gid,s.circular as is_circular ,c.id ,c.cp,c.cid,c.action,c.param,c.title as main_title,c.uType,c.width,c.height,c.x,c.y,c.pic,c.order,c.videoUrl from yd_ver_screen_content c ,yd_ver_screen_guide g,yd_ver_station s";
            $sql_where = " where `screenGuideId`=$gid and `delFlag`=0 and c.screenGuideid=g.id and g.gid=s.id order by `order`";
            $sql = $sql_select.$sql_where;
            $info = SQLManager::queryAll($sql);
            if(empty($info)){   return null;
            }
            foreach ($info as $k => $v) {
                if($v['is_circular']=='2'){//无圆角
                    $v['is_circular']=1;
                }else{
                    $v['is_circular']=0;//圆角
                }
                $order = $v['order'];
                if (empty($arr[$order])) {
                    $arr[$order]['banner'][] = $v;
                } else {
                    $tmp = $arr[$order]['banner'];
                    $tmp[] = $v;
                    $arr[$order]['banner'] = $tmp;
                }
                if($v['cid'] == ' '){
                    $v['cid'] = '0';
                }
            }
            foreach ($arr as $k=>$v){
                $newArr[] = $v;
            }
            $data['list']=$newArr;

            $value = $data;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

    public function actionGetGwDetail()
    {
        $cacheId = 'getGwDetail'.'?cid='.$_REQUEST['cid'].'&type='.$_REQUEST['type'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
            $err = 0;
            if (empty($_REQUEST['cid']) || empty($_REQUEST['type']) ) $err = 1;
            if($err==0){
                $vid = $_REQUEST['cid'];
                $type = $_REQUEST['type'];
                /*$pro = $_REQUEST['pro'];
                $city = $_REQUEST['city'];
                $cp = $_REQUEST['cp'];
                $usergroup = $_REQUEST['usergroup'];
                $epgcode = $_REQUEST['epgcode'];*/
//                $tmp = VerGuideManager::getStation($pro,$city,$cp,$usergroup,$epgcode);
                $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
                $gw_res = SQLManager::queryRow($gw_sql);
                $list = VerGuideManager::getStationList($gw_res['name']);
                $tmp = VideoManager::getGwDetail($vid,$type,$list);
                $res['content']=$tmp;
            }
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, 60);
            echo json_encode($res);
        }else{
            echo json_encode($value);
        }

    }

    public function actionClassifyData()
    {
        $cacheId = 'ClassifyData'.'?cid='.$_REQUEST['cid'].'&p='.$_REQUEST['p'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
            $err = 0;
            if (empty($_REQUEST['cid'] || empty($_REQUEST['p']))) $err = 1;
            if($err==0){
                $gid = $_REQUEST['cid'];
                $p = $_REQUEST['p'];
                $tmp = VerSiteListManager::getGwSiteList($gid,$p);
                $res = $tmp;
            }
            $res['err']=$err;
            //echo json_encode($res);
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, 60);
            //echo '1';
            echo json_encode($res);
        }else{
            //echo '2';
            echo json_encode($value);
        }
    }

    public function actionSpecial(){
        $err = 0;
        if (empty($_REQUEST['cid'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $cacheId = 'Special'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $vid = $_REQUEST['cid'];
            $tmp= VerBkimg::model()->find("gid='$vid'");
            $res['wallpaper']=$tmp->attributes;
            $res['content'] = VerUiManager::getList($vid);
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    public function actionNewSpecial(){
        $err=0;
        if(empty($_REQUEST['cid'])){
            $err=1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $cacheId = 'NewSpecial'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $sid=$_REQUEST['cid'];
            $sql = "select * from yd_special_topic where sid=$sid order by `order` asc";
            $data = SQLManager::queryAll($sql);

            $bkimg = VerBkimg::model()->find("gid = $sid");
            $bgimg=$bkimg->url;
            foreach($data as $v){
                $info[]=array("id"=>$v['id'],"cid"=>$v['cid'],"is_circular"=>1,"action"=>$v['action'],"param"=>$v['param'],"main_title"=>$v['title'],"type"=>$v['type'],
                    "tType"=>$v['tType'],"uType"=>$v['uType'],"width"=>$v['width'],"height"=>$v['height'],"x"=>$v['x'],"y"=>$v['y'],"pic"=>$v['picSrc'],"order"=>$v['order'],"videoUrl"=>$v[
                    'videoUrl'],"cp"=>0);
            }
            foreach ($info as $k => $v) {
                $order = $v['order'];
                $v['width']  = $v['width'];
                $v['height'] = $v['height'];
                $v['x'] = $v['x'];
                $v['y'] = $v['y'];
                if (empty($arr[$order])) {
                    $arr[$order]['banner'][] = $v;
                } else {
                    $tmp = $arr[$order]['banner'];
                    $tmp = $arr[$order]['banner'];
                    $tmp[] = $v;
                    $arr[$order]['banner'] = $tmp;
                }
                if($v['cid'] == ' '){
                    $v['cid'] = '0';
                }
            }
            foreach ($arr as $k=>$v){
                $newArr[] = $v;
            }
            $res['err'] = 0;
            $res['bgimg'] = $bgimg;
            $res['list'] = $newArr;
            $res['updateTime'] = 0;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    public function actionClassify(){
        $err = 0;
        if (!isset($_REQUEST['cid'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }
        $res=array();
        $cacheId = 'Classify'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $cid= $_REQUEST['cid'];
            $tmp = VerGuideManager::getClassify($cid);
            $res=$tmp;
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }
    public function actionGetGwDetailTest()
    {
        $cacheId = 'getGwDetailTest'.'?cid='.$_REQUEST['cid'].'&type='.$_REQUEST['type'];
        $value=Yii::app()->cache->get($cacheId);
        //var_dump($value);die;
        if($value===false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
            $err = 0;
            if (empty($_REQUEST['cid']) || empty($_REQUEST['type']) ) $err = 1;
            if($err==0){
                $vid = $_REQUEST['cid'];
                $type = $_REQUEST['type'];
                /*$pro = $_REQUEST['pro'];
                $city = $_REQUEST['city'];
                $cp = $_REQUEST['cp'];
                $usergroup = $_REQUEST['usergroup'];
                $epgcode = $_REQUEST['epgcode'];*/
//                $tmp = VerGuideManager::getStation($pro,$city,$cp,$usergroup,$epgcode);
                $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
                $gw_res = SQLManager::queryRow($gw_sql);
                $list = VerGuideManager::getStationList($gw_res['name']);
                $tmp = VideoManager::getGwDetail($vid,$type,$list);
                $res['content']=$tmp;
            }
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, 10);
            echo json_encode($res);
        }else{
            echo json_encode($value);
        }
    }

    public function actionGwClassifyDataTextVersion()
    {
        //$cacheId = 'ClassifyData'.'?cid='.$_REQUEST['cid'].'&p='.$_REQUEST['p'];
        $cacheId = 'gwClassifyData' . '?cid=' . $_REQUEST['cid'];
        $value = Yii::app()->cache->get($cacheId);
        if ($value === false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
            $err = 0;
            if (empty($_REQUEST['cid'])) $err = 1;
            if ($err == 0) {
                $gid = $_REQUEST['cid'];
                $tmp = VerSiteListManager::getGwSiteListTextVersion($gid);
                $res = $tmp;
            }
            $res['err'] = $err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, 60);
            echo json_encode($res);
        } else {
            echo json_encode($value);
        }
    }


    public function actionGwSearchIndex()
    {
        $res = array();
        $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
        $gw_res = SQLManager::queryRow($gw_sql);
        $list = VerSiteListManager::getStationList($gw_res['name']);
        $res['list'] = VideoManager::getSomeContent($list);
        $row = 4;
        $res['movie'] = VideoManager::getMovie($list,$row);
        if(!empty($res['list']) && !empty($res['movie'])){
            $err = 0;
            $res['err'] = $err;
        }else{
            $res['err'] = 1;
            $res['list'] = null;
            $res['movie'] = null;
        }
        echo json_encode($res);
    }

    public function actionGwInitialsSearch()
    {
        $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
        $gw_res = SQLManager::queryRow($gw_sql);
        $list = VerSiteListManager::getStationList($gw_res['name']);
        $initial = !empty($_REQUEST['initials'])?$_REQUEST['initials']:'';
        $showType = !empty($_REQUEST['showType'])?$_REQUEST['showType']:'';
	$p = !empty($_REQUEST['p'])?$_REQUEST['p']:'1';
        if($showType == '全部' ){
            $showType = '';
        }
        $title = !empty($_REQUEST['title'])?$_REQUEST['title']:'';
        $res = array();
        $res = VideoManager::initialSearch($initial,$showType,$title,$list,$p);
        echo json_encode($res);
    }

    public function actionGwTitleSearch()
    {
        $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
        $gw_res = SQLManager::queryRow($gw_sql);
        $p = !empty($_REQUEST['p'])?$_REQUEST['p']:'1';
        $list = VerSiteListManager::getStationList($gw_res['name']);
        $initial = !empty($_REQUEST['initials'])?$_REQUEST['initials']:'';
        $showType = !empty($_REQUEST['showType'])?$_REQUEST['showType']:'';
        if($showType == '全部' ){
            $showType = '';
        }
        $res = array();
        $res = VideoManager::titleSearch($initial,$showType,$list,$p);
        echo json_encode($res);
    }

    public function actionGwHomeSearch()
    {
        $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
        $gw_res = SQLManager::queryRow($gw_sql);
        $row = 6;   //取多少条数据
        $list = VerSiteListManager::getStationList($gw_res['name']);
        $res['movie'] = VideoManager::getMovie($list,$row);
        if(!empty($res['movie'])){
            $res['err'] = 0;
        }else{
            $res['err'] = 1;
        }
        echo json_encode($res);
    }

    public function actionGwFiltData()
    {
        $err = 0;
        if (empty($_REQUEST['cid'])) $err = 1;
        if($err==0){
            $cid = $_REQUEST['cid'];
            $country = $_REQUEST['country'];
            $year = $_REQUEST['year'];
            $p = $_REQUEST['p'];
            $tmp = VerSiteListManager::getGwFiltData($cid,$country,$year,$p);
            $res = $tmp;
        }
        $res['err']=$err;
        echo json_encode($res);
    }

    public function actionGwFilter()
    {
        $err = 0;
        if (empty($_REQUEST['cid'])) $err = 1;
        if($err==0){
            $cid = $_REQUEST['cid'];
            $tmp = VerSiteListManager::getGwFilter($cid);
            $res['tab']=$tmp;
        }
        $res['err']=$err;
        echo json_encode($res);
    }

    public function actionGetGwWallPaper()
    {
        $list = array();
        $gid=STATIONID;
        $tmp = VerWallManager::getGwData($gid);
        if (!empty($tmp)) {
            $err = 0;
            foreach ($tmp as $val) {
                $list[] = $val;
            }
        } else {
            $err = 1;
        }
        $res['err'] = $err;
        $res['walls'] = $list;
        echo json_encode($res);
    }

    public function actionGwMsgContent()
    {
        $err = 0;
        $gid=STATIONID;
        $tmp = MessageManager::getGwMsgData($gid);
        $res['content']=$tmp;
        if(!empty($res['content'])){
            $err = 0;
        }else{
            $err =1;
        }
        $res['err']=$err;
        echo json_encode($res);
    }

    //公网盒子2.0版本详情页接口，上半部分内容
    public function actionGetGwDetailPageInfoTop()
    {
        $vid  = $_REQUEST['cid'];
        if(empty($vid) ){
            $err = 1;
            $res['err'] = $err;
            echo json_encode($res);
            return;
        }
//        $gw_sql = "select name from yd_ver_station where id=32";
//        $gw_res = SQLManager::queryRow($gw_sql);
//        $list = VerGuideManager::getStationList($gw_res['name']);
//        $tmp = VideoManager::getGwDetailPageInfo($vid,$list);
        $res = array();
        $sql = "select a.`order`,a.first_play_time,a.score,a.id,a.type,a.vid as cid,a.title,b.duration as length,a.year,a.director,a.actor as star,a.info as introduction,a.keyword as lable,a.language,a.CountryOfOrigin as state,a.simple_set,a.region , a.spid,a.mms_id,a.targetgroupassetid as ParentNodeID,a.ShowType, b.cp,b.assetId,b.mediafilepath as url,b.contid as ProgramID from yd_video as a left join yd_video_list as b on a.vid=b.vid where a.vid='$vid' group by b.vid order by b.mediacoderate desc";
        $tmp = SQLManager::queryRow($sql);

        if(!empty($tmp)) {
            if($tmp['length'] == ""){
                $tmp['length'] = 0;
            }
	    if($tmp['score'] == '0'){
		$tmp['score'] = '6.0';
	    }	
            if ($tmp['state'] == '0') {
                $tmp['state'] = '其他';
            } else if ($tmp['state'] == '1') {
                $tmp['state'] = '内地';
            } else if ($tmp['state'] == '2') {
                $tmp['state'] = '港台';
            } else if ($tmp['state'] == '3') {
                $tmp['state'] = '韩日';
            } else if ($tmp['state'] == '4') {
                $tmp['state'] = '欧美';
            } else if ($tmp['state'] == '5') {
                $tmp['state'] = '东南亚';
            } else if ($tmp['state'] == '99' || $tmp['state'] == '100') {
                $tmp['state'] = '其他';
            } else {
                $tmp['state'] = $tmp['region'];
            }
            if($tmp['ShowType'] == 'Variety'){
                $tmp['simple_set']=3;
            }
	
	    if($tmp['simple_set'] == 2 || $tmp['simple_set'] == 3){
                $sql_extra = "select b.total from yd_video_extra as b where b.vid='$vid'";
                $sql_extra_res = SQLManager::queryRow($sql_extra);
                $total = $sql_extra_res['total'];
            }else{
                $total = 1;
            }

            $tmp['video_total'] = $total;	
	
            $lable = $tmp['lable'];
            $pa = "/^[\d,']+$/";
            preg_match($pa, $lable, $match);
            $tmp['lable'] = array();
            if (!empty($match)) {
                $str = KeyWordManager::getKey($lable);
                $str[0]['type'] = $tmp['type'];
                $tmp['lable'] = $str;
            }
        }
        $res['err'] = 0;
        $sqlpic = "select p.url,e.end from yd_video_pic p inner join yd_video_extra e on e.vid=p.vid and p.vid='$vid' and type=1";
        $pic=SQLManager::queryRow($sqlpic);
        $tmp['pic']=$pic['url'];
        $tmp['end']=$pic['end'];

        $res['content'] = $tmp;
        if(!empty($tmp['simple_set'])){
            if($tmp['simple_set'] == '1' /*&& $tmp['ShowType'] == 'Movie'*/){
                $sql_episode = "select  v.first_play_time,v.`order`,v.title, v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video as v left join yd_video_list as l on v.vid=l.vid  where (v.vid='$vid' or targetgroupassetid='$vid') and l.flag=1 group by l.assetId order by l.mediacoderate desc";
            }else if( $tmp['simple_set'] == '3'){
                //$sql_episode = "select  v.first_play_time,v.`order`,v.title,v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video as v left join yd_video_list as l on v.vid=l.vid where v.targetgroupassetid='$vid' and v.delFlag=1 and l.flag=1 group by l.assetId order by v.`order`, l.mediacoderate desc";
                $sql_episode = "select  v.first_play_time,v.`order`,v.title,v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video as v left join yd_video_list as l on v.vid=l.vid where v.targetgroupassetid='$vid' and v.delFlag=1 and l.flag=1  group by l.assetId order by v.`order` desc";
            }else if($tmp['simple_set'] == '2'){
		$sql_episode = "select  v.first_play_time,v.`order`,v.title,v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,
l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video as v left join yd_video_list as l on v.vid=l.vid where v.targetgroupassetid='$vid' and v.delF
lag=1 and l.flag=1  group by l.assetId order by v.`order` asc";
	    }
//        echo $sql_episode;die;
            $episode= SQLManager::queryAll($sql_episode);
        }
        if(!empty($episode)){
            foreach($episode as $k=>$v){
                $data['episode'][$k]=$v;
                $data['episode'][$k]['url']=ltrim($v['url'],'/');
                $data['episode'][$k]['pid']='';
                $len = strlen($v['cTime']);
                $addLen = 8-$len;
                $tmp_str = '';
                for($i = 0 ; $i<$addLen/2; $i++){
                    $tmp_str .='01';
                }
                $unixTime = $v['cTime'].$tmp_str;
                $data['episode'][$k]['cTime']=strtotime($unixTime);
            }
        }else{
            $data['episode']=array();
        }
        $data['total']=count($data['episode']);
        if(empty($data['total'])){
            $data['total']=1;
        }
        $res = array_merge($res,$data);
        echo json_encode($res);

    }

    //公网盒子获取收藏信息后查询详细信息接口
    public function actionGwSelectCollectionForward()
    {
        $vids = $_REQUEST['vids'];
        $keys = $_REQUEST['keys'];
        $keys = explode(",",$keys);
        $arr_vids = explode(",",$vids);
        $sort_arr = array_combine($keys,$arr_vids);
//      var_dump($sort_arr);die;
        //$sql = "select a.vid,a.title,a.targetgroupassetid,b.url from yd_video as a left join yd_video_pic as b on a.vid=b.vid where a.vid in ($vids)  and b.type=1"; //and b.type=1
        //$sql = "select a.vid,a.title,a.targetgroupassetid,b.url from yd_video as a left join yd_video_pic as b on a.vid=b.vid where a.vid in ($vids) group by a.vid"; //and b.type=1
        $sql = "select a.vid,a.title,a.targetgroupassetid  from yd_video as a  where a.vid in ($vids)"; //and b.type=1
        $res = SQLManager::queryAll($sql);
        //var_dump($res);die;
//        $tar_arr = array();
        $tmp = array();
        foreach ($res as $k=>$v){
            $offset = array_search($v['vid'],$sort_arr);
            if($v['targetgroupassetid'] != '0'){
                $tmp[$offset]['url'] = $this->getEpisodePic($v['targetgroupassetid']);
                $tmp[$offset]['vid'] = $v['vid'];
                $tmp[$offset]['title'] = $v['title'];
                $tmp[$offset]['cid'] = $v['targetgroupassetid'];
            }else{
                $tmp[$offset]['url'] = $this->getMoviesPic($v['vid']);
                $tmp[$offset]['vid'] = $v['vid'];
                $tmp[$offset]['title'] = $v['title'];
                $tmp[$offset]['cid'] = $v['targetgroupassetid'];
            }
        }
        //var_dump($tmp);
        if(!empty($tmp)){
            //$tmp = array_multisort($tmp);
            /*foreach ($tmp as $k => $v) {
                    //var_dump($v);die;
                    $edition[] = $v['vid'];
            }
            array_multisort($edition, SORT_ASC, $tmp);
            var_dump($tmp);die;*/
            echo json_encode($tmp);
        }else{
            echo json_encode($res);
        }
    }

    public function getEpisodePic($targetgroupassetid)
    {
        $sql = "select url from yd_video_pic where vid=$targetgroupassetid and type=1";//and type=1
        $res = SQLManager::queryRow($sql);
        return $res['url'];
    }

    public function getMoviesPic($vid)
    {
        $sql = "select url from yd_video_pic where vid=$vid and type=1";//and type=1
        $res = SQLManager::queryRow($sql);
        return $res['url'];
    }

    public function actionGwGetActorImg(){
        $vid=$_REQUEST['vid'];
        $res=array();
        $result=Video::model()->findByAttributes(array("vid"=>$vid,"cp"=>"poms"));
        if(!empty($result)){
            $arr=array("vid"=>$result->vid,"actor"=>$result->actor);
        }else{
            //echo json_encode(array("error"=>-1));return;
	    $arr = array();	
        }
        if(!empty($arr['actor'])){
            $tmp=explode("/",$arr['actor']);
        }else{
            $tmp=null;
        }
        if(!empty($tmp)){
            for($k=0;$k<count($tmp);$k++){
                $list=explode("-",$tmp[$k]);
                if(isset($list[1])){
                    $sql="select * from yd_video_star ,yd_video_star_images where yd_video_star.starId=yd_video_star_images.starId and yd_video_star.starId=$list[1]";
                    $res[$k]=SQLManager::queryRow($sql);
                    $res[$k]['chname']=$list[0];
                }else{
                    //echo json_encode(array("error"=>1));return;
                }
            }

            //var_dump($list);die;
            for($j=0;$j<count($res);$j++){
                if( isset($res[$j]['pic']) && isset($res[$j]['id'])){
                    $actorList[]=array("name"=>$res[$j]['chname'],"pic"=>$res[$j]['pic'],"aid"=>$res[$j]['starId']);
                }else{
                    $actorList[]=array("name"=>$res[$j]['chname'],"pic"=>null,"aid"=>null);
                }
            }
        }else{
            $actorList=array();
        }
	if(!empty($actorList)){
            foreach ($actorList as $k=>$v){
                if($v['pic']==null){
		    unset($actorList[$k]);
                }
            }
        }
	if(!empty($actorList)){
            $actorList_tmp = array();
            foreach ($actorList as $k=>$v){
                $actorList_tmp[] = $v;
            }
        }else{
	    $actorList_tmp = array();	
	}
	
        $gw_sql = 'select name from yd_ver_station where id='.STATIONID;
        $gw_res = SQLManager::queryRow($gw_sql);
        $list = VerGuideManager::getStationList($gw_res['name']);
	if($result->simple_set == 1){
            $type=1;
        }/*else if($result->simple_set == 2 && $result->ShowType='Variety'){
            $type=3;
        }*/else if($result->simple_set == 2){
            $type=2;
        }
        $tmp = VideoManager::getGwDetailRecommend($vid,$type,$list);
        //echo json_encode(array("actor"=>$actorList,"recommend"=>$tmp['recommend']));
        echo json_encode(array("actor"=>$actorList_tmp,"recommend"=>$tmp));
    }

    //演员详情
    public function actionGwActor(){
        $aid=$_REQUEST['aid'];//演员starid
        $tmp=VideoStarImages::model()->findByAttributes(array("starId"=>$aid));
        $img=$tmp->pic;//演员图片
        $model=VideoStar::model()->findByAttributes(array("starId"=>$aid));
        $desc=$model->brief;//演员介绍
        $name=$model->name;//演员姓名
        $nameEn=$model->nameEn;
        $weight=$model->weight;
        $tall=$model->tall;
        $birth=$model->birth;
        $professon=$model->professon;
        $nation=$model->birthplace;
        $sql="select id,vid,title,year,type,targetgroupassetid from yd_video where actor like '%$name%' and cp='poms'";
        $list=SQLManager::queryAll($sql);
        $result=array();
        for($i=0;$i<count($list);$i++){
            if($list[$i]['targetgroupassetid']!=0){//查找相关视频
                $result[$i]=Video::model()->findByAttributes(array("vid"=>$list[$i]['targetgroupassetid']));
            }else{//顶级则直接返回vid title
                $result[$i]=array("vid"=>$list[$i]['vid'],"title"=>$list[$i]['title'],"type"=>$list[$i]['type']);
            }
        }
        foreach($result as $k=>$v){//返回所有vid
            $res[]=array("vid"=>$v['vid'],"type"=>$v['type'],"title"=>$v['title']);
        }
        for($j=0;$j<count($res);$j++){
            if(!empty($res[$j]['vid'])){//去除未查询到剧集的相关视频
                $newRes[]=$res[$j];
            }
        }
        //去重
        for($k=0;$k<count($newRes);$k++){
            $str=join(",",$newRes[$k]);
            $temp[]=$str;
        }
        $temp=array_unique($temp);
	//var_dump($temp);die;
        $variety=array();
        $series=array();
        $movie=array();
        foreach($temp as $key=>$val){
            $tmp=explode(",",$val);
            $vid=$tmp[0];
            $title=$tmp[2];
            $cate=$tmp[1];
            $pic=VideoPic::model()->findByAttributes(array("vid"=>$vid));
	    if(!empty($pic)){
            switch($cate){
                case "电视剧":$series[]=array("vid"=>$vid,"cate"=>$cate,"title"=>$title,"pic"=>$pic->url);break;
                case "综艺":$variety[]=array("vid"=>$vid,"cate"=>$cate,"title"=>$title,"pic"=>$pic->url);break;
                case "电影":$movie[]=array("vid"=>$vid,"cate"=>$cate,"title"=>$title,"pic"=>$pic->url);break;
            }
	    }else{
	    switch($cate){
		case "电视剧":$series[]=array("vid"=>$vid,"cate"=>$cate,"title"=>$title,"pic"=>null);break;
                case "综艺":$variety[]=array("vid"=>$vid,"cate"=>$cate,"title"=>$title,"pic"=>null);break;
                case "电影":$movie[]=array("vid"=>$vid,"cate"=>$cate,"title"=>$title,"pic"=>null);break;
	    }}
        }
        echo json_encode(array("nation"=>$nation,"nameEn"=>$nameEn,"weight"=>$weight,"tall"=>$tall,"birth"=>$birth,"professon"=>$professon,"img"=>$img,"desc"=>$desc,"name"=>$name,"list"=>array("series"=>$series,"movie"=>$movie,"variety"=>$variety)));
    }

    public function actionGetSpecialContent()
    {
        $cacheId = 'GetSpecialContent'.'?gid='.$_REQUEST['gid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $gid = $_REQUEST['gid'];
            $bkimg = VerBkimg::model()->find("gid = $gid");
            if (empty($bkimg)) {
                $bkimg = new VerBkimg();
            } else {
                $type = $bkimg->attributes['type'];
            }
            if ($type == '3') {
                $sql = "select a.upTime,a.id,a.tType,a.vid,a.param,a.action,a.title,a.vid,a.pic,a.uType,a.scort,a.position,a.type,b.assetId,b.cp,b.url from yd_ver_ui as
 a left join yd_video_list as b on a.vid=b.vid where a.gid=$gid AND a.`delFlag`=0 and b.flag='1' order by `position` asc";
            } else {
                $sql = "select a.upTime,a.id,a.vid,a.param,a.action,a.title,a.vid,a.pic,a.uType,b.templateType as vuType,a.scort,a.cp,a.position,a.type,b.type as vType,
a.tType from yd_ver_ui as a left join yd_video as b on a.vid=b.vid where a.gid=$gid AND a.`delFlag`=0   order by `position`,scort asc";
            }
            $tmp = SQLManager::queryAll($sql);
            $sql_bg = "select url from yd_ver_bkimg where delFlag=0 and gid=$gid";
            $bg = SQLManager::queryRow($sql_bg);
            if (!empty($bg)) {
                $res['bg'] = $bg['url'];
            } else {
                $res['bg'] = null;
            }
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    if (is_null($tt['uType'])) {
                        switch ($tt['vType']) {
                            case '电影':
                                $tt['uType'] = 'A';        break;
                            case '电视剧':
                                $tt['uType'] = 'B';
                                break;
                            case '综艺':
                                $tt['uType'] = 'C';
                                break;
                            case '新闻':
                                $tt['uType'] = 'D';
                                break;
                            default:
                                $tt['uType'] = 'D';
                                break;
                        }
                    }
                    switch ($tt['uType']) {
                        case 'A':
                            $tt['uType'] = '7';
                            break;
                        case 'B':
                            $tt['uType'] = '8';
                            break;
                        case 'C':
                            $tt['uType'] = '10';
                            break;
                        case 'D':
                            $tt['uType'] = '9';
                            break;
                        default :
                            $tt['uType'] = $tt['uType'];
                            break;
                    }
                    $pos = $tt['position']; $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                        if ($tt['position'] == 'appTop') {
                            $tt['position'] = '5';
                        }
                        if ($type == '3') {
                            $pa = "/<|\m3u8|ts/";
                            preg_match($pa, $tt['url'], $match);
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'position' => $tt['position'],
                                'assetId' => $tt['assetId'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'url' => $match[0],
                            );
                        } else {
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'tType' => $tt['tType'],'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'position' => $tt['position'],
                            );
                        }
                        $tmp_tmp[$pos] = array('info' => $tmp2);
                    } else {
                        if ($tt['position'] == 'appTop') {
                            $tt['position'] = '5';
                        }
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        if ($type == '3') {
                            $pa = "/<|\m3u8|ts/";
                            preg_match($pa, $tt['url'], $match);
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'position' => $tt['position'],
                                'assetId' => $tt['assetId'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'url' => $match[0],
                            );
                        } else {
                            $tmp2[] = array( 'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'position' => $tt['position'],
                            );
                        }
                        $tmp_tmp[$pos]['info'] = $tmp2;
                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
                $err = 0;
                $res['err'] = $err;
                $res['list'] = $list;
            } else {
                $err = 1;
                $res['err'] = $err;
            }
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

}
