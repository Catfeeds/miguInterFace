<?php
class MvNavManager extends MvNav{
    public static function getCount($pro,$city){
        $sql_selet = "select count(distinct cp) as num ";
        $sql_from = " from yd_mv_nav";
        $sql_where = " where province='$pro' and city='$city'";
        $list = $sql_selet . $sql_from .$sql_where;
        //echo $list;
        $count = SQLManager::queryRow($list);
        if($count['num']==0){
            $sql_selet = "select count(distinct cp) as num ";
            $sql_from = " from yd_mv_nav";
            $sql_where = " where province='$pro' and city=0";
            $list = $sql_selet . $sql_from .$sql_where;
            //echo $list;
            $count = SQLManager::queryRow($list);
            if($count['num']==0){
                $sql_selet = "select count(distinct cp) as num ";
                $sql_from = " from yd_mv_nav";
                $sql_where = " where province=0 and city=0";
                $list = $sql_selet . $sql_from .$sql_where;
                //echo $list;
                $count = SQLManager::queryRow($list);
            }
        }
        //var_dump($count);
        return $count;
    }

    public static function getList($pro,$city,$usergroup,$epgcode){
        $sql_selet = "select cp ";
        $sql_from = " from yd_mv_nav";
        $sql_where = " where usergroup='$usergroup'";
        $sql_group = " group by cp";
        $list = $sql_selet . $sql_from .$sql_where . $sql_group;
        $count = SQLManager::queryALL($list);
        if(empty($count)){
            $sql_selet = "select cp ";
            $sql_from = " from yd_mv_nav";
            $sql_where = " where epgcode='$epgcode'";
            $sql_group = " group by cp";
            $list = $sql_selet . $sql_from .$sql_where . $sql_group;
            //echo $list;
            $count = SQLManager::queryALL($list);
            if(empty($count)){
                    $sql_selet = "select cp ";
                    $sql_from = " from yd_mv_nav";
                    $sql_where = " where province='$pro' and city='$city'";
                    $sql_group = " group by cp";
                    $list = $sql_selet . $sql_from .$sql_where . $sql_group;
                    //echo $list;
                    $count = SQLManager::queryALL($list);
                    if(empty($count)){
                        $sql_selet = "select cp ";
                        $sql_from = " from yd_mv_nav";
                        $sql_where = " where province='$pro' and city='0'";
                        $sql_group = " group by cp";
                        $list = $sql_selet . $sql_from .$sql_where . $sql_group;
                        //echo $list;
                        $count = SQLManager::queryALL($list);
                        if(empty($count)){
                            $sql_selet = "select cp ";
                            $sql_from = " from yd_mv_nav";
                            $sql_where = " where province=0 and city=0";
                            $sql_group = " group by cp";
                            $list = $sql_selet . $sql_from .$sql_where . $sql_group;
                            //echo $list;
                            $count = SQLManager::queryALL($list);
                            if(empty($count)){
                                $count = array(array('cp'=>'1'),array('cp'=>'2'),array('cp'=>'3'),array('cp'=>'4'),array('cp'=>'5'));
                            }
                        }
                    }

            }
        }
        return $count;
    }
}
?>
