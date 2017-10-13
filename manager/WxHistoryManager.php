<?php
class WxHistoryManager extends WxHistory{
    public static function getAll($worker,$first,$end,$page){
        $res = array();

        $sql_count = 'select count(id)';
        $sql_select = 'select *';
        $sql_from = ' from yd_wx_history';
        $sql_where = " where worker='$worker' and text <> '[用户点击菜单] [遥控器] ' and time > '$first' and time < '$end' ";
        $sql_order = ' order by time asc';
        $count = $sql_count . $sql_from .$sql_where;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();
        $page_size = 8; //每页数量
        $page_total = ceil($res['count']/$page_size);
        $page_start = $page * $page_size;

        $res = array(
            "total_num" => $res['count'],
            "page_size" => $page_size,
            "page_total_num" => $page_total,
        );
        $sql_limit = " limit $page_start,$page_size";
        $list = $sql_select . $sql_from . $sql_where .$sql_order.$sql_limit  ;
        $list = SQLManager::queryAll($list);
        $data = array('kf2017@MobileBox2015'=>'客服1','kf2004@MobileBox2015'=>'客服2','kf2014@MobileBox2015'=>'客服4','kf2010@MobileBox2015'=>'客服5','kf2011@MobileBox2015'=>'客服6','kf2018@MobileBox2015'=>'客服9');
        foreach($list as $key=>$val){
            $val['worker']=$data[$val['worker']];
            $val['time']=date("Y-m-d h:i:s",$val['time']);
            $res['list'][$key]=$val;
        }
        return $res;
    }

    public static function getExcel($worker,$first,$end){
        $res = array();
        $sql_select = 'select id,openid,text,time,worker';
        $sql_from = ' from yd_wx_history';
        $sql_where = " where worker='$worker' and text <> '[用户点击菜单] [遥控器] ' and time > '$first' and time < '$end' ";
        $sql_order = ' order by time asc';
        $list = $sql_select . $sql_from . $sql_where .$sql_order  ;
        $list = SQLManager::queryAll($list);
        $data = array('kf2017@MobileBox2015'=>'客服1','kf2004@MobileBox2015'=>'客服2','kf2014@MobileBox2015'=>'客服4','kf2010@MobileBox2015'=>'客服5','kf2011@MobileBox2015'=>'客服6','kf2018@MobileBox2015'=>'客服9');
        foreach($list as $key=>$val){
            $val['worker']=$data[$val['worker']];
            $val['time']=date("Y-m-d h:i:s",$val['time']);
            $res[$key]=$val;
        }
        return $res;
    }



}
?>