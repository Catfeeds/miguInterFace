<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 12:50
 */
class VerGuideManager extends VerGuide{
    public static function getList(){
        $res = array();
        $all = VerGuide::model()->findAll();
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
        $sql_select = 'select pid,name,module,url,status,id from yd_ver_guide';
        return SQLManager::queryAll($sql_select);
    }

    public static function getforparent($id=0){
        $sql_select = 'select name,url,id,module,pid from yd_ver_guide where pid='.intval($id).' order by `order` asc';
        $res = SQLManager::queryAll($sql_select);
        //var_dump($res);
        return $res;
        //return SQLManager::queryAll($sql_select);
    }


    /*public static function getData($pro,$city,$cp,$usergroup,$epgcode){*/
       /* $res = array();
        if(empty($usergroup)){
           $usergroup='-1';
        }
        if(empty($epgcode)){
           $epgcode='-1';
        }
        $cp = $cp-699210;
        $sql_select ="select * from yd_ver_station where usergroup='$usergroup'";
        $list = SQLManager::queryRow($sql_select);
        if(empty($list)){
            $sql_select ="select * from yd_ver_station where epgcode='$epgcode'";
            $list = SQLManager::queryRow($sql_select);
            if(empty($list)){
                $sql_select ="select * from yd_ver_station where province like '%$pro%' and city like '%$city%' and cp like '%$cp%'";
                $list = SQLManager::queryRow($sql_select);
                if(empty($list)){
                    $sql_select ="select * from yd_ver_station where province like '%$pro%' and city like '%0%' and cp like '%$cp%'";
                    $list = SQLManager::queryRow($sql_select);
                }
            }
        }
        $gid = $list['id'];
        $logo = $list['logo'];
        $guide=$list['guide'];
        $message=$list['message'];
        if($guide==2){//导航不显示
            $guide=1;//和前端规定为1不显示
        }else{
            $guide=0;
        }
        if($message==2){
            $message=1;
        }else{
            $message=0;
        }
        $result = array();
        if(!empty($gid)){
        $sql = "select g.id as gid,g.name as title,g.ico_true,g.ico_false,`order`,e.epg from yd_ver_guide g,yd_ver_epg e  where pid='$gid' and g.name=e.epgName order by `order` asc";
        $sql = "select g.id as gid,g.title,g.pic_true as ico_true,g.pic_false as ico_false,g.pic_three as ico_three,g.focus from yd_ver_screen_guide as g where gid=$gid order by `order` asc";
        $result = SQLManager::queryAll($sql);
        }
        $res['logo']=$logo;
        $res['tabs']=$result;
        $res['message']=$message;
        $res['guide']=$guide;
        return $res;
    }*/

   public static function getData($pro,$city,$cp,$usergroup,$epgcode){
        $res = array();
        if(empty($usergroup)){
           $usergroup='-1';
        }
        if(empty($epgcode)){
           $epgcode='-1';
        }
        $cp = $cp-699210;
        $sql_select ="select * from yd_ver_station where usergroup='$usergroup'";
        $list = SQLManager::queryAll($sql_select);
        if(empty($list)){
            $sql_select ="select * from yd_ver_station where epgcode='$epgcode'";
            $list = SQLManager::queryAll($sql_select);
            if(empty($list)){
                $sql_select ="select * from yd_ver_station where province like '%$pro%' and city like '%$city%' and cp like '%$cp%' and CHAR_LENGTH(usergroup)=0 and CHAR_LENGTH(epgcode)=0";
                $list = SQLManager::queryAll($sql_select);
                if(empty($list)){
                    $sql_select ="select * from yd_ver_station where province like '%$pro%' and city like '%0%' and cp like '%$cp%' and CHAR_LENGTH(usergroup)=0 and CHAR_LENGTH(epgcode)=0";
                    $list = SQLManager::queryAll($sql_select);
                }
            }
        }

	$list_flag = $list;
        if(count($list)>1){
            foreach ($list as $a=>$b){
                if(!empty($b['usergroup'])){
                    if($b['usergroup'] != $usergroup){
                        unset($list[$a]);
                    }
                }
            }
            if(count($list)>1){
                foreach ($list as $c=>$d){
                    if(!empty($d['epgcode'])){
                        if($d['epgcode'] != $epgcode){
                            unset($list[$c]);
                        }
                    }
                }
            }
		
            if(count($list)>1){
                foreach ($list as $e=>$f){
                    if(!empty($f['province'])){
                        $tmp = explode(" ",$f['province']);
                        if(!in_array($pro,$tmp)){
                            unset($list[$e]);
                        }
                    }
                }
            }
	    $list_bak = $list;	
            if(count($list)>1){
                foreach ($list as $h=>$i){
                    if(!empty($i['city'])){
                        $tmp = explode(" ",$i['city']);
                        if(!in_array($city,$tmp)){
                            unset($list[$h]);
                        }
                    }
                }
            }
            if(count($list)>1){
                foreach ($list as $j=>$k){
                    if(!empty($k['cp'])){
                        $tmp = explode("/",$k['cp']);
                        if(!in_array($cp,$tmp)){
                            unset($list[$j]);
                        }
                    }
                }
            }
        }

	if(empty($list) && !empty($list_flag)){
           foreach ($list_bak as $k=>$v){
               $pro_bk = explode(" ",$v['province']);
               $city_bk = explode(" ",$v['city']);
               foreach ($pro_bk as $q=>$w){
                   if($w == $pro){
                       $offset = $q;
                   }
               }

               foreach ($city_bk as $x=>$y){
                   if($y != '0' && $x == $offset){
                       unset($list_bak[$k]);
                   }
               }

           }
           $list = $list_bak;
        }

        if(!empty($list)){
            $k = array_keys($list);
            $k = $k[0];
            $gid = $list[$k]['id'];
            $logo = $list[$k]['logo'];
            $guide=$list[$k]['guide'];
            $message=$list[$k]['message'];
            $station_id=$list[$k]['id'];
        }else{
            $gid = null;
            $logo = null;
            $guide= null;
            $message= null;
            $station_id= null;
        }

        if($guide==2){//导航不显示
            $guide=1;//和前端规定为1不显示
        }else{
            $guide=0;
        }
        if($message==2){
            $message=1;
        }else{
            $message=0;
        }
        $result = array();
        if(!empty($gid)){
        //$sql = "select g.id as gid,g.name as title,g.ico_true,g.ico_false,`order`,e.epg from yd_ver_guide g,yd_ver_epg e  where pid='$gid' and g.name=e.epgName order by `order` asc";
        $sql = "select g.id as gid,g.title,g.pic_true as ico_true,g.pic_false as ico_false,g.pic_three as ico_three,g.focus from yd_ver_screen_guide as g where gid=$gid order by `order` asc";

        $result = SQLManager::queryAll($sql);
        }
        $res['logo']=$logo;
        $res['tabs']=$result;
        $res['message']=$message;
        $res['guide']=$guide;
        $res['station_id']=$station_id;
        return $res;
    }
 		

   public static function getClassify($cid){
        $res = array();
        $sql = "select id,pid,name,search,filter,type from yd_ver_sitelist where id='$cid'";
        $res = SQLManager::queryRow($sql);
        if($res['type']=='3'){
           $sql = "select id as pid,id,name,search,filter,type from yd_ver_sitelist where id='{$res['pid']}'";
           $res = SQLManager::queryRow($sql);
           $sql_content = "select * from yd_ver_sitelist where pid='{$res['pid']}'";
           $res['content']=SQLManager::queryAll($sql_content);
        }else{
            $sql = "select id,id as pid,name,search,filter,type from yd_ver_sitelist where id='{$res['id']}'";
           $res = SQLManager::queryRow($sql);
            $sql_content = "select * from yd_ver_sitelist where pid='$cid'";
            $res['content']=SQLManager::queryAll($sql_content);

        }
        return $res;
    }


    public static function getGuide($id){
        //$sql = "select * from yd_ver_guide where pid=$id";
        $sql = "select * from yd_ver_guide where pid=42";
        //$sql = "select * from yd_ver_screen_guide where gid=2";
        $list = SQLManager::queryAll($sql);
	//var_dump($list);die;
        return $list;
    }

    public static function String($arr){
        $t = '';
	$temp=array();
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
    public static function getStation($pro,$city,$cp,$usergroup,$epgcode){
        $list = array();
        if(empty($usergroup)){
           $usergroup='-1';
        }
        if(empty($epgcode)){
           $epgcode='-1';
        }
        $cp = $cp-699210;
        $sql_select ="select * from yd_ver_station where usergroup='$usergroup'";
        $list = SQLManager::queryRow($sql_select);
        if(empty($list)){
            $sql_select ="select * from yd_ver_station where epgcode='$epgcode'";
            $list = SQLManager::queryRow($sql_select);
            if(empty($list)){
                $sql_select ="select * from yd_ver_station where province like '%$pro%' and city like '%$city%' and cp like '%$cp%'";
                $list = SQLManager::queryRow($sql_select);
                if(empty($list)){
                    $sql_select ="select * from yd_ver_station where province like '%$pro%' and city like '%0%' and cp like '%$cp%'";
                    $list = SQLManager::queryRow($sql_select);
                }
            }
        }
        return $list;
    }
    public static function getStationList($name){
        $sql = "select id from yd_ver_sitelist where name='$name'";
        $list = SQLManager::queryRow($sql);
        $sql_list = "select id from yd_ver_sitelist where pid='{$list['id']}' and name='栏目'";
        $tmp = SQLManager::queryRow($sql_list);
        $sqls = "select id from yd_ver_sitelist where pid='{$tmp['id']}'";
        $res = SQLManager::queryAll($sqls);
        return $res;
    }
}
