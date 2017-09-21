<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 12:50
 */
class MvGuideManager extends MvGuide{
    public static function getList(){
        $res = array();
        $all = MvGuide::model()->findAll();
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
        $sql_select = 'select pid,name,module,url,status,id from yd_mv_guide';
        return SQLManager::queryAll($sql_select);
    }
    
    public static function getCun($pro){
        $sql_select='select count(id) as total';
        $sql_from=" from yd_mv_user where usergroup='$pro'";
        //$sql_group=' group by uid';
        $list = $sql_select . $sql_from ;
        //echo $list;
        $res = SQLManager::queryRow($list);
        if(empty($res['total'])){
            $sql_select='select count(id) as total';
            $sql_from=" from yd_mv_user where epgcode='$pro'";
            //$sql_group=' group by uid';
            $list = $sql_select . $sql_from ;
            //echo $list;
            $res = SQLManager::queryRow($list);
        }
        //var_dump($res);die;
        return $res;
    }
    public static function getCuns($data,$pro){
        $sql_select='select vname,count(*) as num';
        $sql_from=" from yd_mv_user where usergroup='$pro'";
        $sql_group=' group by usergroup';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql_select . $sql_from . $sql_group .$sql_limit;
        $total = $sql_select . $sql_from;
        $count = $sql_select . $sql_from . $sql_group;
        $res['list'] = SQLManager::queryAll($list);
        $res['total']=SQLManager::queryRow($total);
        $res['count']=count(SQLManager::queryAll($count));
        if(empty($res['list'])){
            $sql_select='select vname,count(*) as num';
            $sql_from=" from yd_mv_user where epgcode='$pro'";
            $sql_group=' group by epgcode';
            $sql_limit = ' limit '.$data['start'].','.$data['limit'];
            $list = $sql_select . $sql_from . $sql_group .$sql_limit;
            $total = $sql_select . $sql_from;
            $count = $sql_select . $sql_from . $sql_group;
            $res['list'] = SQLManager::queryAll($list);
            $res['total']=SQLManager::queryRow($total);
            $res['count']=count(SQLManager::queryAll($count));
        }
        //var_dump($res);die;
        return $res;
    }

    public static function getCunstbid($data,$province,$version){
        $res = array();
        $sql_select = 'select u.id,m.id,u.stbid,from_unixtime(m.cTime) as cTime ';
        $sql_from = ' from yd_mv_user m,yd_user u';
        $sql_where = " where m.uid=u.id and  m.usergroup='$province' and m.vname='$version'";
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        //$res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        $count = $sql_select . $sql_from . $sql_where ;
        $res['count'] = count(SQLManager::queryAll($count));
        if(empty($res['list'])){
            $sql_select = 'select u.id,m.id,u.stbid,from_unixtime(m.cTime) as cTime ';
            $sql_from = ' from yd_mv_user m,yd_user u';
            $sql_where = " where m.uid=u.id and  m.epgcode='$province' and m.vname='$version'";
            $sql_limit = ' limit '.$data['start'].','.$data['limit'];
            //$res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

            $list = $sql_select . $sql_from . $sql_where . $sql_limit;
            $res['list'] = SQLManager::queryAll($list);
            $count = $sql_select . $sql_from . $sql_where ;
            $res['count'] = count(SQLManager::queryAll($count));
        }
        return $res;
    }
    public static function Usergroup(){
        $sql_user ="select name,id from yd_mv_guide where (id in (select min(gid) from yd_mv_nav group by usergroup ));";
        $us = SQLManager::queryAll($sql_user);
        $sql = "select usergroup,min(gid) as gid from yd_mv_nav where usergroup not in('0') group by usergroup";
        $usergroup = SQLManager::queryAll($sql);
        foreach($us as $k=>$v){
            foreach($usergroup as $key=>$val){
                if($v['id']==$val['gid']){
                    $tmp[$key]['province']=$val['usergroup'];
                    $tmp[$key]['pro']=$v['name'];
                }
            }
        }
        foreach($tmp as $k=>$v){
            unset($v['pro']);
            $arr[$k]=$v;
        }
        $group = MvGuideManager::String($arr);
        $count = "select usergroup,count(id) as num from yd_mv_user where usergroup in($group) group by usergroup";
        $list = SQLManager::queryAll($count);
        foreach($tmp as $k=>$v){
            $res[$k]=$v;
            $res[$k]['num']='0';
            foreach($list as $key=>$val){
                if($val['usergroup']==$v['province']){
                    $res[$k]['num']=$val['num'];
                }

            }
        }
        //var_dump($res);die;
        return $res;
    }

    public static function Epgcode(){
        $res = array();
        $sql_user ="select name,id from yd_mv_guide where (id in (select min(gid) from yd_mv_nav group by epgcode ));";
        $us = SQLManager::queryAll($sql_user);
        $sql = "select epgcode,min(gid) as gid from yd_mv_nav where epgcode not in('0') group by epgcode";
        $usergroup = SQLManager::queryAll($sql);
        foreach($us as $k=>$v){
            foreach($usergroup as $key=>$val){
                if($v['id']==$val['gid']){
                    $tmp[$key]['province']=$val['epgcode'];
                    $tmp[$key]['pro']=$v['name'];
                }
            }
        }
        if(!empty($tmp)){
            foreach($tmp as $k=>$v){
                unset($v['pro']);
                $arr[$k]=$v;
            }
            $group = MvGuideManager::String($arr);
            $count = "select epgcode,count(id) as num from yd_mv_user where epgcode in($group) group by epgcode";
            $list = SQLManager::queryAll($count);
            foreach($tmp as $k=>$v){
                $res[$k]=$v;
                $res[$k]['num']='0';
                foreach($list as $key=>$val){
                    if($val['epgcode']==$v['province']){
                        $res[$key]['num']=$val['num'];
                    }

                }
            }

        }



        //var_dump($res);die;
        return $res;
    }
    public static function String($arr){
        $t = '';
        foreach ($arr as $v){
            $v = join(",",$v); //可以用implode将一维数组转换为用逗号连接的字符串，join是别名
            $temp[] = $v;
        }
        foreach($temp as $v){
            $t.="'$v'".",";
        }
        $t=substr($t,0,-1);  //利用字符串截取函数消除最后一个逗号
        return $t;
    }    
    public static function getStbid($data,$province,$version){
        $res = array();
        //$sql_select = 'select stbid,from_unixtime(cTime) as cTime ';
        //$sql_from = ' from yd_mv_user';
        //$sql_where = " where province=$province and vname='$version'";
        $sql_select = 'select u.id,m.id,u.stbid,from_unixtime(m.cTime) as cTime ';
        $sql_from = ' from yd_mv_user m,yd_user u';
        $sql_where = " where m.uid=u.id and  m.vname='$version'";
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        //$res['count'] = Yii::app()->db->createCommand($count)->queryScalar();
        $sql_order = 'order by cTime desc';
        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        $count = $sql_select . $sql_from . $sql_where ;
        $res['count'] = count(SQLManager::queryAll($count));
        return $res;
    }

        
    /*public static function getTotal(){
        $sql_select='select count(id) as total';
        $sql_from=' from yd_user ';
        //$sql_group=' group by uid';
        $list = $sql_select . $sql_from ;
        //echo $list;
        $res = SQLManager::queryRow($list);
        //var_dump($res);die;
        return $res;
    }

    public static function getVname($data){
        $sql_select='select vname,count(*) as num';
        $sql_from=' from yd_mv_user';
        $sql_group=' group by vname';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql_select . $sql_from . $sql_group .$sql_limit;
        $total = $sql_select . $sql_from;
        $count = $sql_select . $sql_from . $sql_group;
        $res['list'] = SQLManager::queryAll($list);
        $res['total']=SQLManager::queryRow($total);
        $res['count']=count(SQLManager::queryAll($count));
        //var_dump($res);die;
        return $res;
    }*/
    public static function getTotal(){
    $sql_select='select count(id) as total';
    $sql_from=' from yd_user ';
    //$sql_group=' group by uid';
    $list = $sql_select . $sql_from ;
    //echo $list;
    $res = SQLManager::queryRow($list);
    //var_dump($res);die;
    return $res;
}
    public static function getPro($pro){
        $sql_user = "select usergroup from yd_mv_nav where usergroup not in('0') group by usergroup";
        $usergroup = SQLManager::queryAll($sql_user);
        //var_dump($usergroup);die;
        $sql_epg = "select epgcode from yd_mv_nav where epgcode not in('0') group by epgcode";
        $epgcode= SQLManager::queryAll($sql_user);
        $group = MvGuideManager::String($usergroup);
        $epg = MvGuideManager::String($epgcode);
        $sql_select='select count(id) as total';
        $sql_from=" from yd_mv_user where usergroup not in($group) and epgcode not in($epg)";
        //$sql_group=' group by uid';
        $list = $sql_select . $sql_from ;
        //echo $list;
        $res = SQLManager::queryRow($list);
        //var_dump($res);die;
        return $res;
    }

    public static function getVname($data){
        $sql_select='select vname,count(*) as num';
        $sql_from=" from yd_mv_user";
        $sql_group=' group by vname';
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

    public static function getProvince($data){
        //$sql_user = "select n.gid,n.usergroup,g.name from yd_mv_nav n,yd_mv_guide g where n.usergroup not in('0') and n.gid=g.id group by n.usergroup";
        //$usergroup = SQLManager::queryAll($sql_user);
        $sql_user = "select usergroup from yd_mv_nav where usergroup not in('0') group by usergroup";
        $usergroup = SQLManager::queryAll($sql_user);
        //var_dump($usergroup);die;
        $sql_epg = "select epgcode from yd_mv_nav where epgcode not in('0') group by epgcode";
        $epgcode= SQLManager::queryAll($sql_user);
        $group = MvGuideManager::String($usergroup);
        $epg = MvGuideManager::String($epgcode);
        $sql_select='select count(*) as num';
        $sql_from=' from yd_mv_user';
        $sql_where =" where usergroup not in($group) and epgcode not in($epg)";
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $list = $sql_select . $sql_from . $sql_where  .$sql_limit;
        $total = $sql_select . $sql_from;
        $count = $sql_select . $sql_from ;
        $res['list'] = SQLManager::queryAll($list);
        $res['total']=SQLManager::queryRow($total);
        $res['count']=count(SQLManager::queryAll($count));
        //var_dump($res);die;
        return $res;
    }
    public static function getforparent($id=0){
        $sql_select = 'select name,url,id,module,pid from yd_mv_guide where pid='.intval($id).' order by `order` asc';
        return SQLManager::queryAll($sql_select);
    }
    
    public static function getNew($pro, $city, $cp)
    {
        $res = array();
        if ($pro == 0 && $city == 0) {
            $id = 2;
        } else {
            $sql = "select n.gid,g.id from yd_mv_nav n,yd_mv_guide g where n.province='$pro' and n.city='$city' and g.pid=0 and cp='$cp' group by n.id";
            //var_dump($sql);die;
            $res = SQLManager::queryRow($sql);
            $id = $res['gid'];
            //var_dump($res);
            if (empty($res)) {
                $sql = "select n.gid,g.id from yd_mv_nav n,yd_mv_guide g where n.province='$pro' and n.city=0 and g.pid=0 and cp='$cp' group by n.id";
                //var_dump($sql);die;
                $res = SQLManager::queryRow($sql);
                $id = $res['gid'];
                //var_dump($res);
                if (empty($res)) {
                    $id = 2;
                }
            }

        }
        if (!empty($id)) {
            $sql_select = 'select id as gid,`ico_true`,`ico_false`,`order`,vip,name as title';
            $sql_from = ' from yd_mv_guide';
            $sql_where = " where pid=$id";
            $sql_order = ' order by `order` asc';

            $list = $sql_select . $sql_from . $sql_where . $sql_order;

            $res = SQLManager::queryAll($list);
            if (empty($res)) {
                $sql_select = 'select id as gid,`ico_true`,`ico_false`,`order`,vip,name as title';
                $sql_from = ' from yd_mv_guide';
                $sql_where = " where pid=2";
                $sql_order = ' order by `order` asc';

                $list = $sql_select . $sql_from . $sql_where . $sql_order;

                $res = SQLManager::queryAll($list);
            }

        } else {
            $res = '';
        }


        return $res;
    }
    public static function getNews($pro, $city, $cp , $usergroup , $epgcode){
        $res = array();
        if($usergroup=='0'){
            $usergroup='';
        }
        //var_dump($usergroup);die;
        $sql="select gid from yd_mv_nav where usergroup ='$usergroup' order by gid";
        $res = SQLManager::queryRow($sql);
        //var_dump($res);
        $id = $res['gid'];
        if (empty($res)) {
            //echo 1;
            $sql="select gid from yd_mv_nav where epgcode ='$epgcode' order by gid";
            $res = SQLManager::queryRow($sql);
            $id = $res['gid'];
            if (empty($res)) {
                $sql = "select n.gid,g.id from yd_mv_nav n,yd_mv_guide g where n.province='$pro' and n.city='$city' and g.pid=0 and cp='$cp' group by n.id";
                //var_dump($sql);die;
                $res = SQLManager::queryRow($sql);
                $id = $res['gid'];
                //var_dump($res);
                if (empty($res)) {
                    $sql = "select n.gid,g.id from yd_mv_nav n,yd_mv_guide g where n.province='$pro' and n.city=0 and g.pid=0 and cp='$cp' group by n.id";
                    //var_dump($sql);die;
                    $res = SQLManager::queryRow($sql);
                    $id = $res['gid'];
                    //var_dump($res);
                    if (empty($res)) {
                        $id = 2;
                    }
                }
            }
        }
        if (!empty($id)) {
            $sql_select = 'select id as gid,`ico_true`,`ico_false`,`order`,vip,name as title';
            $sql_from = ' from yd_mv_guide';
            $sql_where = " where pid=$id";
            $sql_order = ' order by `order` asc';

            $list = $sql_select . $sql_from . $sql_where . $sql_order;

            $res = SQLManager::queryAll($list);
            //var_dump($res);die;
            if (empty($res)) {
                $sql_select = 'select id as gid,`ico_true`,`ico_false`,`order`,vip,name as title';
                $sql_from = ' from yd_mv_guide';
                $sql_where = " where pid=2";
                $sql_order = ' order by `order` asc';

                $list = $sql_select . $sql_from . $sql_where . $sql_order;

                $res = SQLManager::queryAll($list);
            }

        } else {
            $res = '';
        }


        return $res;
    }
    public static function getTabs(){
        $res = array();
        /*if($pro == 0 && $city==0){
            //$id=2;
        //}else{
            $sql = "select id from yd_mv_guidepid=0";
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

        }*/
            $id = 2;
            $sql_select = 'select `ico_true`,`ico_false`,`order`,vip,name as title';
            $sql_from = ' from yd_mv_guide';
            $sql_where = " where pid=$id";
            $sql_order = ' order by `order` asc';

            $list = $sql_select . $sql_from . $sql_where .$sql_order;

            $res = SQLManager::queryAll($list);



        return $res;
    }
}
