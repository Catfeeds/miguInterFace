<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/12/28
 * Time: 14:41
 */
class VerSiteListManager extends VerSitelist{

    public static function getList($id){
        $res = array();
        $sql = "select * from yd_ver_sitelist where pid=$id";
        //$sql = "select * from yd_wx_guide where pid=42";
        $res = SQLManager::queryAll($sql);
        //var_dump($list);die;
        return $res;
    }

    public static function getData($data,$list,$gid){
        $res = array();
        $sql = "select c.order as orders,c.id as cid,v.language,c.status as vstatus,c.cTime as vTime,v.* from yd_ver_site c,yd_video v where c.vid=v.vid and c.delFlag=0 and c.gid='$gid' order by orders";
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql . $sql_limit;
        //var_dump($list);die;
        //$count = "select count(id) from yd_ver_content";
        $count = "select count(*) from yd_ver_site c,yd_video v where c.vid=v.vid and c.delFlag=0 and c.gid='$gid'";
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();
        $res['list'] = SQLManager::queryAll($list);
        //var_dump($res['list']);die;
        return $res;
    }

    public static function getSiteList($gid,$p){
        $res = array();
        $p = ($p-1)*12;
         $content = VerSitelist::model()->findByPk($gid);
        $type = $content->attributes['type'];
        //if($type=='3'){
            $sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,p.url as pic,v.score ";
            $sql_count = "select count(s.id) ";
            $sql_from = " from yd_ver_site s inner join yd_video v on s.vid = v.vid and s.gid='$gid' and s.status='1' inner join yd_video_pic p on p.vid=v.vid and p.type=1";
            $sql_group = " group by v.vid";
            $sql_order = " order by s.order,s.upTime desc,s.id";
            $sql_limit = " limit $p,12";
            $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
            $count = $sql_count . $sql_from .$sql_group;
            $test = SQLManager::queryAll($sql);
            $list = SQLManager::queryAll($count);
            $lists = count($list);
            //$list = Yii::app()->db->createCommand($count)->queryScalar();
            $res['total'] = ceil($lists/12);
        /*}else{
            $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
            $tmp = SQLManager::queryAll($sql_s);
            $arr = VerGuideManager::String($tmp);
            $sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,p.url as pic,v.score ";
            $sql_count = "select count(s.id) ";
            $sql_from = " from yd_ver_site s inner join yd_video v on s.vid = v.vid and s.gid in($arr) and s.status='1' inner join yd_video_pic p on p.vid=v.vid and p.type=1";
            $sql_group = " group by v.vid";
            $sql_order = " order by s.order,s.upTime desc,s.id";
            $sql_limit = " limit $p,12";
            $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
            $count = $sql_count . $sql_from .$sql_group;
            $test = SQLManager::queryAll($sql);
            $list = SQLManager::queryAll($count);
            $list = count($list);
            //$list = Yii::app()->db->createCommand($count)->queryScalar();
            $res['total'] = ceil($list/12);
        }*/
        foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $res['contents'][]=$v;
            }
        return $res;
    }
    public static function getFiltData($cid,$country,$year,$p){
        $res = array();
        $p = ($p-1)*10;
        $content = VerSitelist::model()->findByPk($cid);
        $type = $content->attributes['type'];
        //if($type=='3'){
            $sql = "select v.templateType,v.type as uType,v.vid as cid,p.url as pic,v.title,v.score from yd_ver_site s inner join yd_video v on";
            $sql_count = " select count(s.id) from yd_ver_site s inner join yd_video v on";
            $sql_where = " s.vid=v.vid and s.gid='$cid' and s.status='1'";
            /*if(isset($country)){
                $sql_where .=" and v.CountryOfOrigin='$country'";
            }*/
            if($country=='0'){
               $sql_where .=" and v.CountryOfOrigin='$country'";
            }
            if(!empty($country)){
                $sql_where .=" and v.CountryOfOrigin='$country'";
            }

            if(!empty($year)){
                $sql_where .=" and v.year='$year'";
            }
            $sql_pic = " inner join yd_video_pic p on p.vid=v.vid and p.type=1 ";
            //$sql_extra = " inner join yd_video_extra e on e.vid=v.vid ";
            $sql_group = " group by v.vid";
            $sql_order = " order by s.order,s.id  ";
            $sql_limit = " limit $p,10";
            //$list = $sql . $sql_where . $sql_pic .$sql_extra . $sql_group . $sql_order. $sql_limit;
            $list = $sql . $sql_where . $sql_pic  . $sql_group . $sql_order. $sql_limit;
            $test = SQLManager::queryAll($list);
           // echo $list;
           // var_dump($test);die;
            $count = $sql_count . $sql_where .$sql_pic . $sql_group . $sql_order;
            $lists = SQLManager::queryAll($count);
            $total = count($lists);
            //$total = Yii::app()->db->createCommand($count)->queryScalar();
            $res['total'] = ceil($total/10);
/*        }else{
            $sql_s = "select id from yd_ver_sitelist where pid='$cid'";
            $tmp = SQLManager::queryAll($sql_s);
            $arr = VerGuideManager::String($tmp);
            $sql = "select v.templateType,v.type as uType,v.vid as cid,p.url as pic,v.title,v.score from yd_ver_site s inner join yd_video v on";
            $sql_count = " select count(s.id) from yd_ver_site s inner join yd_video v on";
            $sql_where = " s.vid=v.vid and s.gid in($arr) and s.status='1'";
            if($country=='0'){
               $sql_where .=" and v.CountryOfOrigin='$country'";
            }
            if(!empty($country)){
                $sql_where .=" and v.CountryOfOrigin='$country'";
            }
            if(!empty($year)){
                $sql_where .=" and v.year='$year'";
            }
            $sql_pic = " inner join yd_video_pic p on p.vid=v.vid and p.type=1 ";
            //$sql_extra = " inner join yd_video_extra e on e.vid=v.vid ";
            $sql_group = " group by v.vid";
            $sql_order = " order by s.order,s.id";
            $sql_limit = " limit $p,10";
            //$list = $sql . $sql_where . $sql_pic .$sql_extra . $sql_group . $sql_order . $sql_limit;
            $list = $sql . $sql_where . $sql_pic . $sql_group . $sql_order . $sql_limit;
            //var_dump($list);die;
            $test = SQLManager::queryAll($list);
            $count = $sql_count . $sql_where . $sql_group . $sql_order;
            $lists = SQLManager::queryAll($count);
            $total = count($lists);
            //$total = Yii::app()->db->createCommand($count)->queryScalar();
            $res['total'] = ceil($total/10);
        }*/
        foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $res['list'][]=$v;
            }
        return $res;
    }
    public static function getFilter($cid){
        $res = array();
        $content = VerSitelist::model()->findByPk($cid);
        $type = $content->attributes['type'];
        if($type=='3'){
            $sql = "select pid from yd_ver_sitelist where id='$cid'";
            $list = SQLManager::queryRow($sql);
            $cid = $list['pid'];
            $sql = "select id from yd_ver_sitelist where pid='$cid'";
        }else{
            $sql = "select id from yd_ver_sitelist where pid='$cid'";
        }
        //$sql = "select id from yd_ver_sitelist where pid='$cid'";
        $tmp = SQLManager::queryAll($sql);
        $arr = VerGuideManager::String($tmp);
        $sql_list = "select v.CountryOfOrigin as country from yd_ver_site s inner join yd_video v on s.vid=v.vid and s.gid in ($arr) group by country";
        $country = SQLManager::queryAll($sql_list);
        $sql_lists = "select v.year from yd_ver_site s inner join yd_video v on s.vid=v.vid and s.gid in ($arr) group by v.year";
        $yearlist = SQLManager::queryAll($sql_lists);
        foreach($yearlist as $key=>$val){
            if(!is_null($val['year'])){
                $year[]['year']=$val['year'];
            }
        }
        //$sqls = "select id as cid,name from yd_ver_sitelist where pid='$cid' or id='$cid'";
        $sqls = "select id as cid,name from yd_ver_sitelist where pid='$cid'";
        $data['name'] = SQLManager::queryAll($sqls);
        $data['year']=$year;
        foreach($country as $k=>$v){
            switch($v['country']){
                case '0':$v['country']='其他';break;
                case '1':$v['country']='内地';break;
                case '2':$v['country']='港台';break;
                case '3':$v['country']='韩日';break;
                case '4':$v['country']='欧美';break;
                case '5':$v['country']='东南亚';break;
                case '99':$v['country']='其他';break;
                default:
                    $v['country']='其他';break;
            }
            $data['country'][]['country']=$v['country'];
        }
        return $data;
    }
    public static function getMsgData($pro,$city,$usergroup,$epgcode){
        $res = array();
        $time = time();
        $gid = 1;
        $sql_select = "select * from yd_ver_message";
        $sql_where = " where gid=$gid and $time < endTime and $time > firstTime";
        $sql_order = " order by cTime desc";
        $sql = $sql_select . $sql_where . $sql_order;
        $res = SQLManager::queryRow($sql);
        return $res;
    }
    
    public static function getStationList($name){
        $sql = "select id from yd_ver_sitelist where name='$name'";
        $list = SQLManager::queryRow($sql);
        $sql_list = "select id from yd_ver_sitelist where pid in('{$list['id']}') and name='栏目'";
	//$sql_list = "select id from yd_ver_sitelist where pid='{$list['id']}' ";
        $tmp = SQLManager::queryRow($sql_list);
        $sqls = "select id from yd_ver_sitelist where pid in ('{$tmp['id']}')";
	$res = SQLManager::queryAll($sqls);
	foreach($res as $k=>$v){
		$arr[] = $v['id'];
	}
	$arrA =  implode(",", $arr);
	$sqlA = "select id from yd_ver_sitelist where pid in ($arrA)";
	$res = SQLManager::queryAll($sqlA);
	foreach($res as $k=>$v){
                $tmpRes[] = $v['id'];
        }
	$arrB = implode(",", $tmpRes);
	$res = $arrA.','.$arrB;
	//$res = explode(',',$res);
        //var_dump($res);die;
	return $res;
    }

    //public static function getSiteListTextVersion($gid,$p)
    public static function getSiteListTextVersion($gid)
    {
    	$sql_classifyname = "select name from yd_ver_sitelist where id=$gid";
    	$classifyname = SQLManager::queryRow($sql_classifyname);			
    	$res = array();
     	$res['classifyname'] = $classifyname['name'];	
	//    $p = ($p-1)*12;
    	$content = VerSitelist::model()->findByPk($gid);
    	$type = $content->attributes['type'];
    	//if($type=='3'){
    	$sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,a.assetId ,a.cp,a.url, b.id as cid ";
    	$sql_count = "select count(s.id) ";
    	$sql_from = " from yd_video_list as a left join yd_video as v on a.vid = v.vid left join yd_ver_site as s on a.vid=s.vid  left join yd_ver_sitelist as b on b.id=s.gid where s.gid=$gid and s.status='1' and a.flag='1' ";
    	$sql_group = " group by v.vid";
    	$sql_order = " order by s.order,s.upTime desc,s.id";
  	//  $sql_limit = " limit $p,12";
  	//  $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
    	$sql = $sql_select . $sql_from .$sql_group . $sql_order ;
    	$count = $sql_count . $sql_from .$sql_group;
    	$test = SQLManager::queryAll($sql);
    	$list = SQLManager::queryAll($count);
    	$list = count($list);
    	//$list = Yii::app()->db->createCommand($count)->queryScalar();
    	$res['total'] = ceil($list/12);
        	/*}else{
            	$sql_s = "select id from yd_ver_sitelist where pid='$gid'";
            	$tmp = SQLManager::queryAll($sql_s);
            	$arr = VerGuideManager::String($tmp);
            	$sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,p.url as pic,v.score a.id as cid";
            	$sql_count = "select count(s.id) ";
            	$sql_from = " from yd_ver_site s inner join yd_video v on s.vid = v.vid and s.gid in($arr) and s.status='1' inner join yd_video_pic p on p.vid=v.vid and p.type=1 left join yd_ver_sitelist as a on a.vid=v.vid";
            	$sql_group = " group by v.vid";
         	$sql_order = " order by s.order,s.upTime desc,s.id";
            	$sql_limit = " limit $p,12";
            	$sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
            	$count = $sql_count . $sql_from .$sql_group;
            	$test = SQLManager::queryAll($sql);
            	$list = SQLManager::queryAll($count);
            	$list = count($list);
            	//$list = Yii::app()->db->createCommand($count)->queryScalar();
            	$res['total'] = ceil($list/12);
        	}*/
    		foreach($test as $k=>$v){
        		if(is_null($v['templateType'])){
            		switch($v['uType']){
                		case '电影':$v['templateType']='A';break;
                		case '电视剧':$v['templateType']='B';break;
                		case '综艺':$v['templateType']='C';break;
                		case '新闻':$v['templateType']='D';break;
                		default:$v['templateType']='D';break;
            		}
        	}
		$pa = "/<|\m3u8|ts/";
        	preg_match($pa, $v['url'], $match);
		$v['url'] = $match[0];
        	$res['contents'][]=$v;
    	}
    	return $res;
    }


   public static function getGwSiteListTextVersion($gid)
    {
        $sql_classifyname = "select name from yd_ver_sitelist where id=$gid";
        $classifyname = SQLManager::queryRow($sql_classifyname);
        $res = array();
        $res['classifyname'] = $classifyname['name'];
        //    $p = ($p-1)*12;
        $content = VerSitelist::model()->findByPk($gid);
        $type = $content->attributes['type'];
        //if($type=='3'){
        $sql_select = "select v.templateType,a.duration,v.type as uType,v.title,v.vid,v.type,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,a.cp,a.assetId,a.mediafilepath as url,a.contid as ProgramID, b.id as cid ";
        $sql_count = "select count(s.id) ";
        $sql_from = " from yd_video_list as a left join yd_video as v on a.vid = v.vid left join yd_ver_site as s on a.vid=s.vid  left join yd_ver_sitelist as b on b.id=s.gid where s.gid=$gid and s.status='1' and a.flag='1' ";
        $sql_group = " group by v.vid,a.assetId";
        $sql_order = " order by s.order,s.upTime desc,s.id,a.mediacoderate";
        //  $sql_limit = " limit $p,12";
        //  $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
        $sql = $sql_select . $sql_from . $sql_group . $sql_order;
        $count = $sql_count . $sql_from . $sql_group;
        $test = SQLManager::queryAll($sql);
        $list = SQLManager::queryAll($count);
        $list = count($list);
        //$list = Yii::app()->db->createCommand($count)->queryScalar();
        $res['total'] = ceil($list / 12); /*}else{
                $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
                $tmp = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmp);
                $sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,p.url as pic,v.score a.id as cid";
                $sql_count = "select count(s.id) ";
                $sql_from = " from yd_ver_site s inner join yd_video v on s.vid = v.vid and s.gid in($arr) and s.status='1' inner join yd_video_pic p on p.vid=v.vid and p.type=1 left join yd_ver_sitelist as a on a.vid=v.vid";
                $sql_group = " group by v.vid";
                $sql_order = " order by s.order,s.upTime desc,s.id";
                $sql_limit = " limit $p,12";
                $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
                $count = $sql_count . $sql_from .$sql_group;
                $test = SQLManager::queryAll($sql);
                $list = SQLManager::queryAll($count);
                $list = count($list);
                //$list = Yii::app()->db->createCommand($count)->queryScalar();
                $res['total'] = ceil($list/12);
                }*/
        foreach ($test as $k => $v) {
            if (is_null($v['templateType'])) {
                switch ($v['uType']) {
                    case '电影':
                        $v['templateType'] = 'A';
                        break;
                    case '电视剧':
                        $v['templateType'] = 'B';
                        break;
                    case '综艺':
                        $v['templateType'] = 'C';
                        break;
                    case '新闻':
                        $v['templateType'] = 'D';
                        break;
                    default:
                        $v['templateType'] = 'D';
                        break;
                }
            }
            $v['url'] = ltrim($v['url'],'/');
            $v['pid'] = '';
            $res['contents'][] = $v;
        }
        return $res;
    }

    public static function getGwFilter($cid)
    {
        $res = array();
        $content = VerSitelist::model()->findByPk($cid);
        $type = $content->attributes['type'];
        if($type=='3'){
            $sql = "select pid from yd_ver_sitelist where id='$cid'";
            $list = SQLManager::queryRow($sql);
            $cid = $list['pid'];
            $sql = "select id from yd_ver_sitelist where pid='$cid'";
        }else{
            $sql = "select id from yd_ver_sitelist where pid='$cid'";
        }
        $tmp = SQLManager::queryAll($sql);
        $arr = VerGuideManager::String($tmp);
        $sql_list = "select v.CountryOfOrigin as country,v.region from yd_ver_site s inner join yd_video v on s.vid=v.vid and s.gid in ($arr) group by country";
        $country = SQLManager::queryAll($sql_list);
        $sql_lists = "select v.year from yd_ver_site s inner join yd_video v on s.vid=v.vid and s.gid in ($arr) group by v.year";
        $yearlist = SQLManager::queryAll($sql_lists);
        foreach($yearlist as $key=>$val){
            if(!is_null($val['year'])){
                $year[]['year']=$val['year'];
            }
        }
        $sqls = "select id as cid,name from yd_ver_sitelist where pid='$cid'";
        $data['name'] = SQLManager::queryAll($sqls);
        $data['year']=$year;
        foreach($country as $k=>$v){
            if($v['country'] == '0'){
                $v['country']='其他';
            }else if($v['country'] == '1'){
                $v['country']='内地';
            }else if($v['country'] == '2'){
                $v['country']='港台';
            }else if($v['country'] == '3'){
                $v['country']='韩日';
            }else if($v['country'] == '4'){
                $v['country']='欧美';
            }else if($v['country'] == '5'){
                $v['country']='东南亚';
            }else if($v['country'] == '99' || $v['country'] == '100'){
                $v['country']='其他';
            }else{
                $v['country'] = $v['region'];
            }
            $data['country'][]['country']=$v['country'];
        }
        return $data;
    }
 
    public static function getGwFiltData($cid,$country,$year,$p)
    {
        $res = array();
        $p = ($p-1)*10;
        $content = VerSitelist::model()->findByPk($cid);
        $type = $content->attributes['type'];
        $sql = "select v.templateType,v.type as uType,v.vid as cid,p.url as pic,v.title,v.score from yd_ver_site s inner join yd_video v on";
        $sql_count = " select count(s.id) from yd_ver_site s inner join yd_video v on";
        $sql_where = " s.vid=v.vid and s.gid='$cid' and s.status='1'";
        if($country=='0'){
            $sql_where .=" and v.CountryOfOrigin='$country'";
        }
        if(!empty($country)){
            $sql_where .=" and v.CountryOfOrigin='$country'";
        }

        if(!empty($year)){
            $sql_where .=" and v.year='$year'";
        }
        $sql_pic = " inner join yd_video_pic p on p.vid=v.vid and p.type=1 ";
        $sql_group = " group by v.vid";
        $sql_order = " order by s.order,s.id  ";
        $sql_limit = " limit $p,10";
        $list = $sql . $sql_where . $sql_pic  . $sql_group . $sql_order. $sql_limit;
        $test = SQLManager::queryAll($list);
        $count = $sql_count . $sql_where .$sql_pic . $sql_group . $sql_order;
        $lists = SQLManager::queryAll($count);
        $total = count($lists);
        $res['total'] = ceil($total/10);
        foreach($test as $k=>$v){
            if(is_null($v['templateType'])){
                switch($v['uType']){
                    case '电影':$v['templateType']='A';break;
                    case '电视剧':$v['templateType']='B';break;
                    case '综艺':$v['templateType']='C';break;
                    case '新闻':$v['templateType']='D';break;
                    default:$v['templateType']='D';break;
                }
            }
            $res['list'][]=$v;
        }
        return $res;
    }

    public static function getGwSiteList($gid,$p)
    {
        $res = array();
        $p = ($p-1)*12;
        $content = VerSitelist::model()->findByPk($gid);
        $type = $content->attributes['type'];
        //if($type=='3'){
        $sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,p.url as pic,v.score ";
        $sql_count = "select count(s.id) ";
        $sql_from = " from yd_ver_site s inner join yd_video v on s.vid = v.vid and s.gid='$gid' and s.status='1' inner join yd_video_pic p on p.vid=v.vid and p.type=1";
        $sql_group = " group by v.vid";
        $sql_order = " order by s.order,s.upTime desc,s.id";
        $sql_limit = " limit $p,15";
        $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
        $count = $sql_count . $sql_from .$sql_group;
        $test = SQLManager::queryAll($sql);
        $list = SQLManager::queryAll($count);
        $lists = count($list);
        //$list = Yii::app()->db->createCommand($count)->queryScalar();
        $res['total'] = ceil($lists/15);
        /*}else{
            $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
            $tmp = SQLManager::queryAll($sql_s);
            $arr = VerGuideManager::String($tmp);
            $sql_select = "select v.templateType,v.duration,v.type as uType,v.title,v.vid,v.type,p.url as pic,v.score ";
            $sql_count = "select count(s.id) ";
            $sql_from = " from yd_ver_site s inner join yd_video v on s.vid = v.vid and s.gid in($arr) and s.status='1' inner join yd_video_pic p on p.vid=v.vid and p.type=1";
            $sql_group = " group by v.vid";
            $sql_order = " order by s.order,s.upTime desc,s.id";
            $sql_limit = " limit $p,12";
            $sql = $sql_select . $sql_from .$sql_group . $sql_order .$sql_limit;
            $count = $sql_count . $sql_from .$sql_group;
            $test = SQLManager::queryAll($sql);
            $list = SQLManager::queryAll($count);
            $list = count($list);
            //$list = Yii::app()->db->createCommand($count)->queryScalar();
            $res['total'] = ceil($list/12);
        }*/
        foreach($test as $k=>$v){
            if(is_null($v['templateType'])){
                switch($v['uType']){
                    case '电影':$v['templateType']='A';break;
                    case '电视剧':$v['templateType']='B';break;
                    case '综艺':$v['templateType']='C';break;
                    case '新闻':$v['templateType']='D';break;
                    default:$v['templateType']='D';break;
                }
            }
            $res['contents'][]=$v;
        }
        return $res;
    }

}
