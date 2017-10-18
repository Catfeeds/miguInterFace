<?php

class MessageManager extends Message{
    public static function getList($data,$list){
        $res = array();
        $sql_count = 'select count(id)';
        $sql_select = 'select *';
        $sql_from = ' from yd_ver_message ';
        $sql_order = ' order by cTime desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        if(!empty($list['title'])){
            $sql_where =" title like '%".$list['title']."%' ";
        }
        $count = $sql_count . $sql_from ;
        $list = $sql_select . $sql_from . $sql_order . $sql_limit;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();


        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }

    public static function getMsgData($pro,$city,$usergroup,$epgcode,$cp){
        $res = array();
        $time = time();
	//$list = VerGuideManager::getStation($pro,$city,$cp,$usergroup,$epgcode);
        $list = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
        if(!empty($list)){
	   $gid=$list['station_id'];
        }else{
           $gid = 1;
        }
        $sql_select = "select * from yd_ver_message";
        $sql_where = " where gid=$gid and $time < endTime and $time > firstTime and flag=6";
        $sql_order = " order by cTime desc";
        $sql = $sql_select . $sql_where . $sql_order;
	
        $res = SQLManager::queryRow($sql);
        return $res;
    }
   
    public static function getGwMsgData($gid)
    {
        $res = array();
        $time = time();
        if(!empty($gid)){
            $gid=$gid;
        }else{
            $gid = 1;
        }
        $sql_select = "select * from yd_ver_message";
        $sql_where = " where gid=$gid and $time < endTime and $time > firstTime";
        $sql_order = " order by cTime desc";
        $sql = $sql_select . $sql_where . $sql_order;
        $res = SQLManager::queryRow($sql);
        $res['uType']=(int)$res['uType'];
        return $res;
    }
}
