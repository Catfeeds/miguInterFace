<?php
class WxMovManager extends WxMovie{
    public static function getList($data,$cp,$word){
        $res = array();
        if(!empty($cp) && !empty($word)){
            //$cp = 642000+$cp;
            $sql_where_cp="where cp=$cp and title like '%$word%'";
        }else if(!empty($cp) && empty($word)){
            $sql_where_cp="where cp=$cp";
        }else if(empty($cp) && !empty($word)){
            $sql_where_cp="where title like '%$word%'";
        }else{
            $sql_where_cp='';
        }
        /*if(!empty($word)){
            $sql_where_word=" and title like '%$word%'";
        }else{
            $sql_where_word='';
        }*/
        $sql_select = "select * from yd_wx_movie ";
        $sql_count = "select count(*) from yd_wx_movie ";
        //$sql_where = " where ''";
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql_select . $sql_where_cp . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        $count = $sql_count . $sql_where_cp ;
        //var_dump($count);
        //$res['count'] = count(SQLManager::queryAll($count));
        $res['count']=Yii::app()->db->createCommand($count)->queryScalar();
        return $res;
    }

    public static function getAll($cp,$word,$p){
        $res = array();
        /*if(!empty($cp)){
            $sql_where_cp=" and cp='$cp'";
        }else{
            $sql_where_cp='';
        }
        if(!empty($word)){
            $sql_where_word=" and title like '%$word%'";
        }else{
            $sql_where_word='';
        }*/
        if(!empty($cp) && !empty($word)){
            //$cp = 642000+$cp;
            $sql_where_cp="where cp=$cp and title like '%$word%'";
        }else if(!empty($cp) && empty($word)){
            $sql_where_cp="where cp=$cp";
        }else if(empty($cp) && !empty($word)){
            $sql_where_cp="where title like '%$word%'";
        }else{
            $sql_where_cp='';
        }

        //select count(distinct cp) from yd_mv_nav;
        //update yd_mv_nav set cp=replace(cp,' ','1');
        $sql_select = "select * from yd_wx_movie ";
        //$sql_where = " where ''";
        $sql_limit = " limit $p,20";
        $list = $sql_select . $sql_where_cp . $sql_limit;
        //echo $list;
        $res= SQLManager::queryAll($list);
        return $res;

    }

}
?>
