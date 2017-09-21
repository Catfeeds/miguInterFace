<?php
class VerScreenContentManager extends MvUi
{
    public static function getAll($gid)
    {
        $res = array();
        $sql_select = "select id,pic,screenGuideId,width,height,tType,type,cp,`order` from yd_ver_screen_content";
        $sql_where = " where screenGuideId=$gid and `delFlag`=0";
        $sql_order = " order by addTime";
        $sql = $sql_select.$sql_where.$sql_order;
	//var_dump($sql);die;
        $res = SQLManager::queryAll($sql);
	//var_dump($res);die;
        return $res;
    }

    public static function getOne($screenGuideId,$order)
    {
        $res = array();
        $sql_select = "select id,pic,screenGuideId,width,height,tType,type,cp,action,param,title,x,y,`order`,epg from yd_ver_screen_content";
        $sql_where = " where `screenGuideId`=$screenGuideId AND `order`='$order'";
        $sql_order = " order by addTime";
        $sql = $sql_select.$sql_where.$sql_order;
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function updateData($data)
    {
        $title    = trim($data['title']);
        $type     = trim($data['type']);
        $Type     = trim($data['tType']);
        $cp       = trim($data['cp']);
        $gid      = trim($data['screenGuideId']);
        $epg      = trim($data['epg']);
        $action   = trim($data['action']);
        $param    = trim($data['param']);
        $pic      = trim($data['key']);
        $upTime   = time();
        $width    = trim($data['width']);
        $height   = trim($data['height']);
        $x        = trim($data['x']);
        $y        = trim($data['y']);
        $delFlag  = '0';
        $order    = trim($data['order']);
        $id       = trim($data['id']);
        $sql_update = "update yd_ver_screen_content set ";
        $sql_set = " `title`='$title',`type`='$type',`tType`='$Type',`cp`='$cp',`screenGuideId`='$gid',`action`='$action',`param`='$param',`pic`='$pic',`upTime`='$upTime',`width`='$width',`height`='$height',`x`='$x',`y`='$y',`delFlag`='$delFlag',`order`='$order'";
        $sql_where = " where id=$id";
        $sql  = $sql_update.$sql_set.$sql_where;
        $res = SQLManager::execute($sql);
        return $res;
    }

    public static function getEpgContent($gid)
    {
        $res = array();
        //$sql_select = "select `id`,`cp`,`cid`,action,param,`title` as main_title,`type`,`tType`,`uType`,`width`,`height`,`x`,`y`,`pic`,`order`,videoUrl from yd_ver_screen_content";
        //$sql_where = " where `screenGuideId`=$gid and `delFlag`=0 order by `order`";
        $sql_select="select c.type,c.tType, g.gid,s.circular as is_circular ,c.id ,c.cp,c.cid,c.action,c.param,c.title as main_title,c.uType,c.width,c.height,c.x,c.y,c.pic,c.order,c.videoUrl from yd_ver_screen_content c ,yd_ver_screen_guide g,yd_ver_station s";
        $sql_where = " where `screenGuideId`=$gid and `delFlag`=0 and c.screenGuideid=g.id and g.gid=s.id order by `order`";
        $sql = $sql_select.$sql_where;
	//var_dump($sql);die;
        $res = SQLManager::queryAll($sql);
	if(empty($res)){
		return null;
		die;
	}
        foreach ($res as $k => $v) {
	    /*switch($v['uType'])
            {
		case '7' :$v['uType']='A';break;
		case '8' :$v['uType']='B';break;
		case '9' :$v['uType']='C';break;
		case '10':$v['uType']='D';break;
		default:$v['uType']=$v['uType'];break;
            }*/
	    //var_dump($v);die;
            if($v['is_circular']=='2') {无圆角
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
        return $newArr;
    }

    public static function getEpgContentUpdateTime($gid)
    {
        $sql = "select upTime from yd_ver_screen_content where `screenGuideId`=$gid group by upTime order by upTime desc";
        $res = SQLManager::queryAll($sql);
	if(empty($res)){
		return null;
	}else{
	    //var_dump($res);die;
            //var_dump($res[0]['upTime']);die;
            return $res[0]['upTime'];
	}
    }

}
