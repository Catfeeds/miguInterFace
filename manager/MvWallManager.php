<?php
class MvWallManager extends MvWallpaper{
    public static function getList(){
        $res = array();
        $sql_select = 'select *';
        $sql_from = ' from yd_mv_wall ';
        $list = $sql_select . $sql_from  ;
        //var_dump($list);die;
        $res = SQLManager::queryAll($list);
        //var_dump($res);die;
        return $res;
    }

    public static function getLists($pro,$city){
        $res = array();
        $sql_select = 'select *';
        $sql_from = ' from yd_mv_wallpaper ';
        $sql_where = " where province='$pro' and city='$city'";
        $list = $sql_select . $sql_from .$sql_where;
        //var_dump($list);die;
        $res = SQLManager::queryAll($list);
        if(empty($res)){
            $sql_select = 'select *';
            $sql_from = ' from yd_mv_wallpaper ';
            $sql_where = " where province='$pro' and city=0";
            $list = $sql_select . $sql_from .$sql_where;
            //var_dump($list);die;
            $res = SQLManager::queryAll($list);
            if(empty($res)){
                $sql_select = 'select *';
                $sql_from = ' from yd_mv_wallpaper ';
                $sql_where = " where province=0 and city=0";
                $list = $sql_select . $sql_from .$sql_where;
                //var_dump($list);die;
                $res = SQLManager::queryAll($list);
            }
        }
        //var_dump($res);die;
        return $res;
    }

}
?>