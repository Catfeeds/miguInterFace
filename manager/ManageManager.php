<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/12/10
 * Time: 14:32
 */
class ManageManager extends Manage{
    public static function getManageList($data){
        $res = array();
        $sql_count = 'select count(id)';
        // $sql_select = 'select id,title,url,status,addTime';
       // $sql_select = 'select id,notice,cp,province,city,delFlag,cTime,sTime,eTime';
        $sql_select = 'select *';
        $sql_from = ' from yd_manage';
        $sql_where = ' where id <> 0';
        $sql_order = ' order by time desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];

        $count = $sql_count . $sql_from . $sql_where;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }
}