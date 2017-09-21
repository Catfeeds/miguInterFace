<?php
class WxDpuserManager extends WxDpuser{
    public static function getList($first,$end,$p,$province,$type){
        $res = array();
        $p = $p*5;
        $sql_select = "select u.*,p.provinceName,count(u.id) as total,max(from_unixtime(u.cTime)) as time  ";
        $sql_from = " from yd_wx_dpuser u,yd_province p ";
        if(!empty($province) ){
            $sql_where =" where u.province=$province and (u.cTime >= $first and u.cTime <= $end  ) and p.provinceCode=u.province ";
        }else{
            $sql_where =" where (u.cTime >= $first and u.cTime <= $end  ) and p.provinceCode=u.province";
        }
        $sql_where_type=" and type=$type ";
        $sql_group = " group by title,typeName";
        $sql_limit = " limit $p,5";
        $sql = $sql_select . $sql_from . $sql_where . $sql_where_type . $sql_group . $sql_limit;
        //echo $sql;die;
        $countsql = $sql_select . $sql_from . $sql_where . $sql_where_type . $sql_group;
        $res['res'] = SQLManager::queryAll($sql);
        //var_dump($res);die;
        $length = SQLManager::queryAll($countsql);
        $count = count($length);
        $res['count'] = $count;
        return $res;
    }
    public static function getAll($first,$end,$province,$type){
        $res = array();
        $sql_select = "select title,typeName,count(*) as total,max(from_unixtime(cTime)) as time  ";
        $sql_from = " from yd_wx_dpuser  ";
        if(!empty($province) ){
            $sql_where =" where province=$province and (cTime >= $first and cTime <= $end  ) ";
        }else{
            $sql_where =" where (cTime >= $first and cTime <= $end  )";
        }
        $sql_where_type=" and type=$type ";
        $sql_group = " group by title,typeName";
        //$sql_limit = " limit $p,5";
        $sql = $sql_select . $sql_from . $sql_where . $sql_where_type . $sql_group;
        //echo $sql;die;
        //$countsql = $sql_select . $sql_from . $sql_where . $sql_where_type . $sql_group;
        $res = SQLManager::queryAll($sql);
        //var_dump($res);die;
        /*$length = SQLManager::queryAll($countsql);
        $count = count($length);
        $res['count'] = $count;*/
        return $res;
    }
}

