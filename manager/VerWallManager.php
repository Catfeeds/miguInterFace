<?php
class VerWallManager extends WxGuide
{
    public static function getLists($pro,$city,$userGroup,$epgCode)
    {
        $res = array();
        if(!empty($epgCode)){
            $sql_select =" select id,title,thum,pic ";
            $sql_from = " from yd_ver_wall";
            $sql_where = " where `epgCode`='$epgCode'";
            $sql = $sql_select.$sql_from.$sql_where;
            $res = SQLManager::queryAll($sql);
        }
//        var_dump($userGroup);die;
        if(empty($res) && isset($userGroup)){
            $sql_select =" select id,title,thum,pic ";
            $sql_from = " from yd_ver_wall";
            $sql_where = " where `userGroup`='$userGroup'";
            $sql = $sql_select.$sql_from.$sql_where;
            $res = SQLManager::queryAll($sql);
        }

        if(empty($res)){
            $sql_select = 'select id,title,thum,pic';
            $sql_from = ' from yd_ver_wall ';
            $sql_where = " where `province`='$pro' and `city`='$city'";
            $list = $sql_select . $sql_from .$sql_where;
            $res = SQLManager::queryAll($list);
        }

        if(empty($res)){
            $sql_select = 'select id,title,thum,pic';
            $sql_from = ' from yd_ver_wall ';
            $sql_where = " where `province`='$pro' and `city`=0";
            $list = $sql_select . $sql_from .$sql_where;
            $res = SQLManager::queryAll($list);
            if(empty($res)){
                $sql_select = 'select id,title,thum,pic';
                $sql_from = ' from yd_ver_wall ';
                $sql_where = " where `province`=0 and `city`=0";
                $list = $sql_select . $sql_from .$sql_where;
                $res = SQLManager::queryAll($list);
            }
        }
        
        return $res;
    }

    public static function getData($pro,$city,$cp,$usergroup,$epgcode){
        $res = array();
        $time = time();
        $list = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
        if(!empty($list)){
           $gid=$list['station_id'];
        }else{
           $gid = 1;
        }
        $sql_select = "select * from yd_ver_wall";
        $sql_where = " where gid=$gid and flag=6 and type=0";
        $sql = $sql_select . $sql_where; 
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function getGwData($gid){
        $res = array();

        if(!empty($gid)){
            $gid=$gid;
        }else{
            $gid = 1;
        }
        $sql_select = "select * from yd_ver_wall";
        $sql_where = " where gid=$gid";
        $sql = $sql_select . $sql_where;
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function getForceData($pro,$city,$cp,$usergroup,$epgcode){
        $res = array();
        $time = time();
        $list = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
	//var_dump($list);die;
        if(!empty($list)){
            $gid=$list['station_id'];
        }else{
            $gid = 1;
        }
        $sql_select = "select * from yd_ver_wall";
        $sql_where = " where gid=$gid and type=1 and flag=6 and province like '%$pro%' and city like '%$city%'";
        //$sql_where = " where gid=$gid and type=1 and flag=6";
        $sql = $sql_select . $sql_where;
        $res = SQLManager::queryAll($sql);
        return $res;
    }

}
