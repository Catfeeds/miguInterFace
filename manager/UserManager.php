<?php
class UserManager extends User{
    public static function getUserList($data,$cp='1'){
        $res = array();
        $sql_select = 'select p.provinceName,count(u.id) as num,u.province';
        $sql_from = ' from yd_province p,yd_user u';
        $sql_where = ' where p.provinceCode not in (28) and u.province=p.provinceCode and u.cp='.$cp;
        $sql_group =' group by u.province';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        //$res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_group . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        $count = $sql_select . $sql_from . $sql_where . $sql_group;
        $res['count'] = count(SQLManager::queryAll($count));
        return $res;
    }
    public static function getStbid($data,$province,$cp='1'){
        $res = array();
        $sql_select = 'select stbid,from_unixtime(cTime) as cTime ';
        $sql_from = ' from yd_user';
        $sql_where = ' where province='.$province.' and cp='.$cp;
        $sql_order = ' order by cTime desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        //$res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_order .$sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        $count = $sql_select . $sql_from . $sql_where ;
        $res['count'] = count(SQLManager::queryAll($count));
        return $res;
    }
}
