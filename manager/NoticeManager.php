<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/10/13
 * Time: 14:32
 */
class NoticeManager extends Notice{
    public static function getNoticeList($data,$cp='1'){
        $res = array();
        $sql_count = 'select count(id)';
       // $sql_select = 'select id,title,url,status,addTime';
        $sql_select = 'select id,notice,cp,province,city,delFlag,cTime,sTime,eTime';
        $sql_from = ' from yd_notice';
        $sql_where = ' where id <> 0 and cp ='.$cp;
        $sql_order = ' order by cTime desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];

        $count = $sql_count . $sql_from . $sql_where;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }
}