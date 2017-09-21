<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/4 0004
 * Time: 20:24
 */
class KeyWordManager extends VerKeyword{

    public static function getData($data,$list){
        $res = array();
        $sql_select = " select * from yd_ver_keyword";
        $sql_count = "select count(id) from yd_ver_keyword";
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        if(!empty($list['type'])){
            $sql_where = " where type='{$list['type']}'";
            $sql = $sql_select . $sql_where . $sql_limit;
        }else{
            $sql = $sql_select . $sql_limit;
        }

        $list = SQLManager::queryAll($sql);
        $count = Yii::app()->db->createCommand($sql_count)->queryScalar();
        $res['count']=ceil($count/10);
        $res['list']=$list;
        return $res;
    }


    public static function getList($list,$p){
        $page = ($p-1)*10;
        $res = array();
        $sql_select = " select * from yd_ver_keyword";
        $sql_limit = " limit $page,10";
        if(!empty($list['type'])){
            //var_dump($list['type']);
            $arr = explode(" ",trim($list['type']));
            foreach($arr as $k=>$v){
                if($k=='0'){
                    $sql_where = " where type='$v'";
                }else{
                    $sql_where .=" or type='$v'";
                }
            }
            //$sql_where = " where type='{$list['type']}'";
            $sql = $sql_select . $sql_where . $sql_limit;
            $sql_count = "select count(id) from yd_ver_keyword";
            $sqls = $sql_count . $sql_where;
        }else{
            $sql = $sql_select . $sql_limit;
            $sqls = "select count(id) from yd_ver_keyword";
        }

        $list = SQLManager::queryAll($sql);
        $res['count'] = Yii::app()->db->createCommand($sqls)->queryScalar();
        $res['list']=$list;
        return $res;
    }

    public static function getKeyword($lable){
        $sql = "select keyword from yd_ver_keyword where id in ($lable)";
        $list = SQLManager::queryAll($sql);
        $str = '';
        foreach($list as $k=>$v){
            if($k=='0'){
                $str = $v['keyword'];
            }else{
                $str .= '/'.$v['keyword'];
            }

        }
        return $str;
    }

    public static function getKey($lable){
        $sql = "select type,keyword from yd_ver_keyword where id in ($lable)";
        $list = SQLManager::queryAll($sql);
        //var_dump($list);die;
        return $list;
    }
}
