<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 12:50
 */
class WxGuideManager extends WxGuide{
    public static function getList(){
        $res = array();
        $all = WxGuide::model()->findAll();
//        var_dump($all);die();
        if(!empty($all)){
            foreach($all as $key=>$n){
                if($n->pid == 0){
                    $tmp['id'] = $n->id;
                    $tmp['name'] = $n->name;
                    $res[$n->id] = $tmp;
                }elseif(array_key_exists($n->pid,$res)){//array_key_exists() 函数判断某个数组中是否存在指定的 key，如果该 key 存在，则返回 true，否则返回 false。
                    $tm['id'] = $n->id;
                    $tm['name'] = $n->name;
                    $res[$n->pid]['node'][] = $tm;
                }
            }
        }

        return $res;
    }
    public static function lists(){
        $sql_select = 'select pid,name,module,url,status,id from yd_wx_guide';
        return SQLManager::queryAll($sql_select);
    }

    public static function getforparent($id=0){
        $sql_select = 'select name,url,id,module,pid from yd_wx_guide where pid='.intval($id).' order by `order` asc';
        $res = SQLManager::queryAll($sql_select);
        //var_dump($res);
        return $res;
        //return SQLManager::queryAll($sql_select);
    }

    public static function getTabs($pro,$city){
        $res = array();
        if($pro == 0 && $city==0){
            $id=2;
        }else{
            $sql = "select id from yd_mv_guide where province='$pro' and city='$city' and pid=0";
            $res = SQLManager::queryRow($sql);
            $id = $res['id'];
            if(empty($res)){
                $sql = "select id from yd_mv_guide where province='$pro' and city=0 and pid=0";
                $res = SQLManager::queryRow($sql);
                $id = $res['id'];
                if(empty($res)){
                    $id = 2;
                }
            }

        }
        if(!empty($id)){
            $sql_select = 'select `ico_true`,`ico_false`,`order`,vip,name as title';
            $sql_from = ' from yd_mv_guide';
            $sql_where = " where pid=$id";
            $sql_order = ' order by `order` asc';

            $list = $sql_select . $sql_from . $sql_where .$sql_order;

            $res = SQLManager::queryAll($list);

        }else{
            $res='';
        }


        return $res;
    }

    public static function Dptab($pro,$city){
        $sql_select = "select *";
        $sql_from = " from yd_wx_guide";
        if($pro ==0 && $city==0){
            $sql_where = " where province=$pro and city=$city and pid=0 and name='全国'";
        }else{
            $sql_where = " where province=$pro and city=$city and pid=0";
        }
        $sql = $sql_select . $sql_from . $sql_where;
        $res = SQLManager::queryRow($sql);
        if(!$res){
            $sql_where = " where province=$pro and city=0 and pid=0";
            $sql = $sql_select . $sql_from . $sql_where;
            $res = SQLManager::queryRow($sql);
            if(!$res){
            $sql_where = " where province=0 and city=0 and pid=0 and name='全国'";
            $sql = $sql_select . $sql_from . $sql_where;
            $res = SQLManager::queryRow($sql);
           }

        }
        return $res;
    }

    public static function getAll($pid,$type){
        $sql_select = "select id,name,pid from yd_wx_guide";
        if($type==1){
            $sql_where = " where pid =$pid and name='视频推荐'";
            $sql_wheres =" where pid=$pid and name='视频分类'";
        }else{
            $sql_where = " where pid =$pid and name='应用推荐'";
            $sql_wheres =" where pid=$pid and name='应用分类'";
        }
        $sqls="select g.id,s.*,s.type as tType from yd_wx_guide g,yd_wx_select s where g.pid=$pid and s.gid=g.id";
        $res['banner'] = SQLManager::queryAll($sqls);
        $sql = $sql_select . $sql_where;
        $res['list'] = SQLManager::queryRow($sql);
        $sqles = $sql_select . $sql_wheres;
        $pid = SQLManager::queryRow($sqles);
        $pid = $pid['id'];
        $sql_tab="select id,name,pid from yd_wx_guide where pid=$pid";
        $res['tab']=SQLManager::queryAll($sql_tab);
        return $res;
    }

    public static function getData($pid,$type){
        $sql = "select id,name from yd_wx_guide where pid=$pid ";
        $res = SQLManager::queryAll($sql);
        foreach($res as $k=>$v){
            $gid = $v['id'];
            if($type==1){
                $sql = "select action,param,title,id as cid,img,type as tType from yd_wx_select where gid=$gid";
            }else{
                $sql = "select action,param,downloadUrl,name as title,id,tType as cid,imageUrl from yd_wx_seapp where gid=$gid";
            }
            //$sql = "select downloadUrl,name,id as cid,imageUrl from yd_wx_select where gid=$gid";
            $res[$k]['recommend'] = SQLManager::queryAll($sql);
        }
        return $res;
    }

    public static function getDp($id){
        $sql = "select id,name from yd_wx_guide where pid=$id";
        $res=SQLManager::queryAll($sql);
        //var_dump($res);
        return $res;
    }

    public static function getDplist($id,$type){
        if($type==3){
            $sql = "select id,name as title,imageUrl as img from yd_wx_seapp where gid=$id order by orders asc";
        }else{
            $sql = "select id,title,img from yd_wx_select where gid=$id order by orders asc";
        }
        //$sql = "select id,title,img from yd_wx_select where gid=$id";
        $res=SQLManager::queryAll($sql);
        return $res;
    }
    
    public static function getDplists($id,$type,$p){
        if($type==3){
            $p = ($p-1)*12;
            $sql = "select id,name as title,imageUrl as img from yd_wx_seapp where gid=$id order by orders asc limit $p,12";
            $sqls = "select count(*) from yd_wx_seapp where gid=$id order by orders asc";
        }else{
            $p = ($p-1)*12;
            $sql = "select id,title,img from yd_wx_select where gid=$id order by orders asc limit $p,12";
            $sqls = "select count(*) from yd_wx_select where gid=$id order by orders asc";
        }
        //$sql = "select id,title,img from yd_wx_select where gid=$id";
        $res['list']=SQLManager::queryAll($sql);
        $total = Yii::app()->db->createCommand($sqls)->queryScalar();
        $res['count']=ceil($total/12);
        return $res;
    }

    public static function getDpinfo($id,$type){
        /*$sql = "select * from yd_wx_select where id=$id";
        $res['info']=SQLManager::queryRow($sql);
        $gid = $res['info']['gid'];
        $mid = $res['info']['mid'];
        $sqls = "select id,title,img from yd_wx_select where id not in ($id) and gid=$gid order by addTime desc limit 0,3";
        $res['recommend']=SQLManager::queryAll($sqls);
        $episode = "select * from yd_wx_episode where mid=$mid";
        $res['list'] = SQLManager::queryAll($episode);*/
        if($type==3){
            $sql = "select * from yd_wx_seapp where id=$id";
            $res['info']=SQLManager::queryRow($sql);
            $gid = $res['info']['gid'];
            $sqls = "select id,name as title,imageUrl as img from yd_wx_seapp where id not in ($id) and gid=$gid order by addTime desc limit 0,3";
            $res['recommend']=SQLManager::queryAll($sqls);
            $res['list']=[];
            $res['flag']=3;
        }else{
            $sql = "select * from yd_wx_select where id=$id";
            $res['info']=SQLManager::queryRow($sql);
            $gid = $res['info']['gid'];
            $mid = $res['info']['mid'];
            $classify=$res['info']['classify'];
            if($classify=='轮播'){
                $sqls = "select id,title,img from yd_wx_select where classify='电影' order by addTime desc limit 0,3";
            }else{
                $sqls = "select id,title,img from yd_wx_select where id not in ($id) and gid=$gid order by addTime desc limit 0,3";
            }
            //$sqls = "select id,title,img from yd_wx_select where id not in ($id) and gid=$gid order by addTime desc limit 0,3";
            $res['recommend']=SQLManager::queryAll($sqls);
            $episode = "select * from yd_wx_episode where mid=$mid";
            $res['list'] = SQLManager::queryAll($episode);
            if(empty($res['list'])){
                $res['flag']=0;
            }else{
                if($res['info']['classify']=='电视剧' || $res['info']['classify']=='甘肃电视剧'){
                    $res['flag']=1;
                }else{
                    $res['flag']=2;
                }
            }
        }
        return $res;
    }

}
