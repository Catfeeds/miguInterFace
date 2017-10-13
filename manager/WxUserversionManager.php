<?php
class WxUserversionManager extends WxDpuser{
    public static function getProvince($data){
        $sql_select='select count(*) as num,province';
        $sql_from=' from yd_wx_userversion';
        $sql_group=' group by province';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql_select . $sql_from . $sql_group .$sql_limit;
        $total = $sql_select . $sql_from;
        $count = $sql_select . $sql_from . $sql_group;
        $res['list'] = SQLManager::queryAll($list);
        $res['total']=SQLManager::queryRow($total);
        $res['count']=count(SQLManager::queryAll($count));
        //var_dump($res);die;
        return $res;
    }

    public static function getPro($pro){
        $sql_select='select count(id) as total';
        $sql_from=" from yd_wx_userversion where province='$pro'";
        //$sql_group=' group by uid';
        $list = $sql_select . $sql_from ;
        //echo $list;
        $res = SQLManager::queryRow($list);
        //var_dump($res);die;
        return $res;
    }
public static function getVname($data,$pro){
        $sql_select='select vname,cp,count(*) as num,sum(case when flag=1 then 1 else 0 end) as bd';
        $sql_from=" from yd_wx_userversion where province='$pro'";
        $sql_group=' group by vname,cp';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql_select . $sql_from . $sql_group .$sql_limit;
        $total = $sql_select . $sql_from;
        $count = $sql_select . $sql_from . $sql_group;
        $res['list'] = SQLManager::queryAll($list);
        $res['total']=SQLManager::queryRow($total);
        $res['count']=count(SQLManager::queryAll($count));
        //var_dump($res);die;
        return $res;
    }
}

