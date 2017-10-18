<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/12/28
 * Time: 14:41
 */
class VideoManager extends Video{

    public static function getList($data){
        $res = array();
        $sql_count = 'select count(id)';
        $sql_select = 'select vid,cp,title,info,actor,director,cate,type';
        $sql_from = ' from yd_video';
        $sql_where = " where title like '%".$data['title']."%'";
        $sql_order = ' order by cTime desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];

        $count = $sql_count . $sql_from . $sql_where;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }

    public static function getData($data,$list){
        $res = array();
        $sql_count = 'select count(id)';
        $sql_select = 'select id,ShowType,vid,cp,title,language,info,actor,director,cate,type,cTime,flag';
        $sql_from = ' from yd_video ';
        $sql_order = ' order by id desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        if(!empty($list['ShowType']) && !empty($list['cp']) && !empty($list['title'])){
            $sql_where = " where ShowType ='".$list['ShowType']."' and cp='".$list['cp']."' and title like '%".$list['title']."%' and instr(title,'_')=0";
        }else if(empty($list['ShowType']) && !empty($list['cp']) && !empty($list['title'])){
            $sql_where = " where cp='".$list['cp']."' and title like '%".$list['title']."%' and instr(title,'_')=0";
        }else if(!empty($list['ShowType']) && empty($list['cp']) && !empty($list['title'])){
            $sql_where = " where ShowType ='".$list['ShowType']."'  and title like '%".$list['title']."%' and instr(title,'_')=0";
        }else if(!empty($list['ShowType']) && !empty($list['cp']) && empty($list['title'])){
            $sql_where = " where ShowType ='".$list['ShowType']."' and cp='".$list['cp']."' and instr(title,'_')=0";
        }else if(empty($list['ShowType']) && !empty($list['cp']) && empty($list['title'])){
            $sql_where = " where cp='".$list['cp']."' and instr(title,'_')=0";
        }else if(!empty($list['ShowType']) && empty($list['cp']) && empty($list['title'])){
            $sql_where = " where ShowType ='".$list['ShowType']."' and instr(title,'_')=0";
        }else if(empty($list['ShowType']) && empty($list['cp']) && !empty($list['title'])){
            $sql_where = " where title like '%".$list['title']."%' and instr(title,'_')=0";
        }else{
            $sql_where = " where instr(title,'_')=0";
        }
        $count = $sql_count . $sql_from . $sql_where;
        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        //var_dump($list);die;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();


        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }


    public static function getReview($data,$list){
        $res = array();
        $sql_count = 'select count(id)';
        $sql_select = 'select id,vid,cp,title,language,info,actor,director,cate,type,cTime,flag';
        $sql_from = " from yd_video where flag='1'";
        $sql_order = ' order by cTime desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        if(!empty($list['type'])){
            $sql_where = " where type like '%".$list['type']."%'";
            $count = $sql_count . $sql_from . $sql_where;
            $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        }else{
            $count = $sql_count . $sql_from ;
            $list = $sql_select . $sql_from  . $sql_order . $sql_limit;
        }
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();


        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }
     
    public static function getDetail($vid,$type,$list){
        $res = array();
        /*if($type=='1'){
            $sql = "select id,type,vid as cid,title,duration as length,year,director,actor as star,info as introduction,keyword as lable,language,CountryOfOrigin as state from yd_video where vid='$vid'";
        }else{*/
            $sql = "select simple_set,score,id,type,vid as cid,title,duration as length,year,director,actor as star,info as introduction,keyword as lable,language,CountryOfOrigin as state from yd_video where vid='$vid'";
        //}
        //var_dump($sql);die;
        $tmp = SQLManager::queryRow($sql);
        //var_dump($tmp);die;
        if(!empty($tmp)){
            $vid = $tmp['cid'];
            switch($tmp['state']){
                case '0':$tmp['state']='其他';break;
                case '1':$tmp['state']='内地';break;
                case '2':$tmp['state']='港台';break;
                case '3':$tmp['state']='韩日';break;
                case '4':$tmp['state']='欧美';break;
                case '5':$tmp['state']='东南亚';break;
                case '99':$tmp['state']='其他';break;
            }
            $lable = $tmp['lable'];
            $pa = "/^[\d,']+$/";
            preg_match($pa, $lable, $match);
            //var_dump($match);die;
            $tmp['lable']=array();
            if(!empty($match)){
                $str = KeyWordManager::getKey($lable);
                $tmp['lable']=$str;
            }
            //var_dump($language);die;
            if($type=='2'){
                $sql = "select v.title,v.type as uType,v.vid,l.cp,l.assetId,l.url from yd_video v,yd_video_list l where v.targetgroupassetid='$vid' and v.vid=l.vid and v.delFlag=1 and l.flag=1 group by l.assetId order by v.order";
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $data['total']=count($data['episode']);
                if(empty($data['total'])){
                    $data['total']=1;
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                //$arrlist = $arr.','.$arrs;
                //$sql_list = "select gid from yd_ver_site where gid in ($arrlist) and vid='$vid'";
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists = SQLManager::queryAll($sql_list);
                //$lists = array(array('id'=>3));
		if(!empty($lists)){
                $gidlist = VerGuideManager::String($lists);
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
                /*$sqls = "select l.id from yd_ver_site s inner join yd_ver_sitelist l on s.vid = {$tmp['cid']} and s.gid=l.id and s.status=1 and l.pid=0";
                $list = SQLManager::queryRow($sqls);
                $gid=$list['id'];
                $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);
                //$sqls = "select v.type as uType,v.vid as cid,v.title,p.url from yd_video v,yd_video_pic p where v.ShowType='Series' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.id order by v.cTime limit 0,12";
                //$tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($test)){
                    $sql_s = "select id from yd_ver_sitelist where pid='3'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.id as vid from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid  order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);
                    //$tmp['recommend']=array();
                }*/
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                   if(is_null($v['templateType'])){
                       switch($v['uType']){
                           case '电影':$v['templateType']='A';break;
                           case '电视剧':$v['templateType']='B';break;
                           case '综艺':$v['templateType']='C';break;
                           case '新闻':$v['templateType']='D';break;
                           default:$v['templateType']='D';break;
                       }
                   }
                   $tmp['recommend'][]=$v;
                }
		}
            }else if($type=='1'){
                $sql = "select v.type as uType,v.vid,l.cp,l.assetId,l.url from yd_video v,yd_video_list l where (v.vid='$vid' or targetgroupassetid='$vid') and v.vid=l.vid and l.flag=1 group by l.assetId";
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts|mp4/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                //$arrlist = $arr.','.$arrs;
                //$sql_list = "select gid from yd_ver_site where gid in ($arrlist) and vid='$vid'";
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists=array();
                $lists = SQLManager::queryAll($sql_list);
                //$lists = array(array('id'=>3));
                if(!empty($lists)){
                    $gidlist = VerGuideManager::String($lists);
                }else{
                    $gidlist=$arrs;
                }
                    $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                    $test=SQLManager::queryAll($sql_lists);
                /*$sqls = "select l.id from yd_ver_site s inner join yd_ver_sitelist l on s.vid = {$tmp['cid']} and s.gid=l.id and s.status=1 and l.pid=0";
                $list = SQLManager::queryRow($sqls);
                $gid=$list['id'];
                $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);
                //$sqls = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_video v,yd_video_pic p where v.ShowType='Movie' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.id order by v.cTime limit 0,12";
                //$tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($test)){
                    //$tmp['recommend']=array();
                    $sql_s = "select id from yd_ver_sitelist where pid='2'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);
                }*/
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                   if(is_null($v['templateType'])){
                       switch($v['uType']){
                           case '电影':$v['templateType']='A';break;
                           case '电视剧':$v['templateType']='B';break;
                           case '综艺':$v['templateType']='C';break;
                           case '新闻':$v['templateType']='D';break;
                           default:$v['templateType']='D';break;
                       }
                   }
                   $tmp['recommend'][]=$v;
                }
            }else if($type=='3'){
                $sql = "select v.title,v.type as uType,v.vid,l.cp,l.assetId,l.url from yd_video v,yd_video_list l where v.vid='$vid' and v.vid=l.vid and l.flag=1 group by l.assetId";
                //var_dump($sql);
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                //$arrlist = $arr.','.$arrs;
                //$sql_list = "select gid from yd_ver_site where gid in ($arrlist) and vid='$vid'";
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists = SQLManager::queryAll($sql_list);
                //$lists = array(array('id'=>3));
                //$gidlist = VerGuideManager::String($lists);
		 if(!empty($lists)){
                    $gidlist = VerGuideManager::String($lists);
                }else{
                    $gidlist=$arrs;
                }
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
                /*$sqls = "select l.id from yd_ver_site s inner join yd_ver_sitelist l on s.vid = {$tmp['cid']} and s.gid=l.id and s.status=1 and l.pid=0";
                $list = SQLManager::queryRow($sqls);
                $gid=$list['id'];
                $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);

                //$sqls = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_video v,yd_video_pic p where v.ShowType='News' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.vid  order by v.cTime  limit 0,4";
                //$tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($test)){
                    $sql_s = "select id from yd_ver_sitelist where pid='17'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);
                    //$tmp['recommend']=array();
                }*/
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                   if(is_null($v['templateType'])){
                       switch($v['uType']){
                           case '电影':$v['templateType']='A';break;
                           case '电视剧':$v['templateType']='B';break;
                           case '综艺':$v['templateType']='C';break;
                           case '新闻':$v['templateType']='D';break;
                           default:$v['templateType']='D';break;
                       }
                   }
                   $tmp['recommend'][]=$v;
                }

            }else if($type=='4'){
                $sql = "select v.type as uType,v.title,v.vid,l.cp,l.assetId,l.url,l.cTime from yd_video v,yd_video_list l where v.targetgroupassetid='$vid' and v.vid=l.vid and v.delFlag=1 and l.flag=1 group by l.assetId order by v.order desc";
                //var_dump($sql);
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $data['total']=count($data['episode']);
                if(empty($data['total'])){
                    $data['total']=1;
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists = SQLManager::queryAll($sql_list);
                //$gidlist = VerGuideManager::String($lists);
		 if(!empty($lists)){
                    $gidlist = VerGuideManager::String($lists);
                }else{
                    $gidlist=$arrs;
                }
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
                /*$type=$tmp['type'];
                $sqls = "select l.id from yd_ver_site s inner join yd_ver_sitelist l on s.vid = {$tmp['cid']} and s.gid=l.id  and s.status=1 and l.pid=0";
                $list = SQLManager::queryRow($sqls);
                $gid=$list['id'];
                $sql_s = "select id from yd_ver_sitelist where pid='$gid'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
		//var_dump($sql_list);die;
                $test=SQLManager::queryAll($sql_list);

                //$sqls = "select v.type as uType,v.vid as cid,v.title,p.url from yd_video v,yd_video_pic p where v.type='$type' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.vid  order by v.cTime  limit 0,12";
                //$tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($test)){
                    //$tmp['recommend']=array();
                    $sql_s = "select id from yd_ver_sitelist where pid='2'";
                $tmplist = SQLManager::queryAll($sql_s);
                $arr = VerGuideManager::String($tmplist);
                $sql_list = "select v.templateType,v.type as uType,v.vid as cid,v.title,p.url from yd_ver_site s inner join yd_video v on s.gid in ($arr) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_list);
                }*/
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                   if(is_null($v['templateType'])){
                       switch($v['uType']){
                           case '电影':$v['templateType']='A';break;
                           case '电视剧':$v['templateType']='B';break;
                           case '综艺':$v['templateType']='C';break;
                           case '新闻':$v['templateType']='D';break;
                           default:$v['templateType']='D';break;
                       }
                   }
                   $tmp['recommend'][]=$v;
                }

            }else{
                $data['episode']=array();
                $data['total']=1;
                $tmp['recommend']=array();
            }
            //$sqlpic = "select url from yd_video_pic where vid='$vid' and type=1";
            $sqlpic = "select p.url,e.end from yd_video_pic p inner join yd_video_extra e on e.vid=p.vid and p.vid='$vid' and type=1";
            $pic=SQLManager::queryRow($sqlpic);
            $tmp['pic']=$pic['url'];
            $tmp['end']=$pic['end'];
            //$tmp['pic']='http://portalpic.itv.cmvideo.cn:8088/file/2b88e2c54bcd7eae452133e39c4b53b8.png';
            //$tmp['score']='7.6';
            $res = array_merge($tmp,$data);

        }


        return $res;
    }

    public static function getVideo($id){
        $res = array();
        $sql = "select v.id,v.title,l.videocodec,l.filesize,v.duration,v.bitrate from yd_video v,yd_video_list l where v.vid=l.vid and v.id=$id";
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function getVideoList($vid,$id){
        $res = array();
        $sql = "select vid from yd_video where targetgroupassetid=$vid order by `order`";
        //$sql = "select v.id,v.title,l.videocodec,l.filesize,v.duration,v.bitrate from yd_video v,yd_video_list l where v.vid=l.vid and v.id=$id and ";
        $tmp = SQLManager::queryAll($sql);
        //var_dump($tmp);die;
        if(!empty($tmp)){
            $list = VideoManager::String($tmp);
            $sqls = "select v.id,v.title,l.videocodec,l.filesize,v.duration,v.bitrate from yd_video v,yd_video_list l where v.vid=l.vid and v.vid in ($list) or v.id=$id group by v.vid";
        }else{
            $sqls = "select v.id,v.title,l.videocodec,l.filesize,v.duration,v.bitrate from yd_video v,yd_video_list l where v.vid=l.vid and v.id=$id";
        }

        $res = SQLManager::queryAll($sqls);
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


    public static function getInfo($data,$title){
        $res = array();
        $sql_count = 'select count(id)';
        $sql_select = 'select id,ShowType,vid,cp,title,language,info,actor,director,cate,type,cTime,flag';
        $sql_from = ' from yd_video ';
        $sql_order = ' order by id desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];
        $sql_where=" where title like '%$title%'";
        $count = $sql_count . $sql_from . $sql_where;
        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        //var_dump($list);die;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();


        $res['list'] = SQLManager::queryAll($list);
        return $res;
    }

     public static function getSomeContent($list)
    {
        $res = array();
	$tmp = explode(',',$list);
        //if(count($list)>1){
        if(count($tmp)>1){
           /*$arrA = VerGuideManager::String($list);
	   $sql_select = "select id from yd_ver_sitelist where pid in ($arrA)";
           $arrlist = SQLManager::queryAll($sql_select);
           $arrB = VerGuideManager::String($arrlist);
	   $arr = $arrA.','.$arrB; */
	   $arr = $list;	
        }else{
           //$arr = $list[0]['id'];
           $arr = $list;
           /*$sql_select = "select id from yd_ver_sitelist where pid in ($arr)";
           $arrlist = SQLManager::queryAll($sql_select);
           if(count($arrlst)>1){
              $arr = VerGuideManager::String($arrlist);
           }else{
              $arr=$arrlist[0]['id'];
           }*/
        }
        /*$sql = "select id,name from yd_ver_sitelist where pid in($arr) ORDER BY  RAND() LIMIT 8";
        $res = SQLManager::queryAll($sql);*/
        $test=array();
        $sql = "select a.id,a.vid,a.cp,a.type,c.name as cate,b.url,b.title from yd_video as a inner join yd_video_pic as b on a.vid=b.vid inner join yd_ver_site s on s.vid=a.vid inner join yd_ver_sitelist as c on c.id=s.gid and s.gid in ($arr) where a.flag=6 and b.type=1 and s.status=1 and a.cate is not null  group by a.cate limit 8";
        //var_dump($sql);die;
	$test = SQLManager::queryAll($sql);
        $res=$test;
        
        return $res;
    }

    public static function getMovie($list,$row)
    {
        $new_arr = array();
//        $sql_select = 'select a.id,a.vid,b.title,b.url as pic from yd_video a left join yd_video_pic as b on a.vid=b.vid where b.type=0 limit 5';
        $sql_count = "select count(*) from yd_video_pic";
        //$count = SQLManager::queryAll($sql_count);
        //$rand = rand(1,$count[0]['count(*)']-$row);
//        $sql_select = "select id ,vid ,title,url as pic from yd_video_pic where type=1";
        //$arr = VerGuideManager::String($list);
	$arr = $list;
	//$sql_select = "select b.templateType,a.id ,a.vid ,a.title,a.url as pic,b.type as uType from yd_video_pic as a left join yd_video as b on b.vid=a.vid where a.type=1 and b.flag=2 and a.vid=b.vid group by a.vid order by b.upTime desc";
        $sql_select = "select b.templateType,a.id ,a.vid ,b.title,a.url as pic,b.type as uType from yd_ver_site s inner join yd_video b on s.vid=b.vid and s.gid in ($arr) and s.status=1 inner join yd_video_pic a on a.vid=b.vid inner join yd_ver_sitelist as c on c.id=s.gid and a.type=1 and s.status=1 group by a.vid order by s.upTime desc";
        $sql_limit = " limit $row";
        $sql = $sql_select.$sql_limit;
	//var_dump($sql);die;
        $test = SQLManager::queryAll($sql);
        /*foreach ($res as $key =>$v){
                $new_arr[]=$v;
        }*/
        if(!empty($test)){
        foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $new_arr[]=$v;
            }
        }
        return $new_arr;
    }

    public static function initialSearch($initial,$showType,$title,$list,$p)
    {
        header("Content-Type:text/html;Charset=utf-8");
        $p = ($p-1)*25;
        $res = array();
	$tmp = explode(',',$list);
        //if(count($list)>1){
        if(count($tmp)>1){
            //$arr = VerGuideManager::String($list);
	    $arr = $list;	
        }else{
            //$arr = $list[0]['id'];
	    $arr = $list;	
        }
        if(!empty($initial) && !empty($showType)){
            $sql_where = " where a.initial like '%$initial%' and d.name like '%$showType%' and c.status=1 ";
        }else if(!empty($title)){
            //$sql_where = " where a.title like '%$title%' or c.cate like '%$title%'  and c.status=1 ";
            $sql_where = " where a.title like '%$title%' or d.name like '%$title%'  and c.status=1 ";
        }else if(!empty($showType)){
	    $sql_where = " where d.name like '%$showType%' and c.status=1";	
	}else{
            $sql_where = " where a.initial like '%$initial%' and c.status=1 ";
        }
        $sql_select = "select a.templateType,a.title,a.id,a.vid,a.type as uType,d.name as ShowType,d.id as cid from yd_ver_sitelist as d left join yd_ver_site as c on c.gid = d.id and d.id in ($arr) LEFT JOIN yd_video as a on a.vid=c.vid ";
        $sql_group_by  = " group by a.id";
        $sql_limit = " limit $p,25";
        $sql = $sql_select.$sql_where.$sql_group_by.$sql_limit;//var_dump($sql);die;
        $tests = SQLManager::queryAll($sql);
	//var_dump($tests);die;
	$sql_type = "select d.name as ShowType from yd_ver_sitelist as d left join yd_ver_site as c on c.gid = d.id and d.id in ($arr) LEFT JOIN yd_video as a on a.vid=c.vid ";
        $sql_type_group = " group by d.name";
        $sql_types = $sql_type . $sql_where . $sql_type_group;
        $res['types']=SQLManager::queryAll($sql_types);
        $sql_count = "select a.templateType,a.title,a.id,a.vid,a.type as uType,d.name as ShowType,d.id as cid from yd_ver_sitelist as d left join yd_ver_site as c on c.gid = d.id and d.id in ($arr) LEFT JOIN yd_video as a on a.vid=c.vid ";
        $count = $sql_count.$sql_where.$sql_group_by;
        $total = SQLManager::queryAll($count);
        $res['count']=count($total);
        $res['total']=ceil(count($total)/25);
        $arr = array();
        $test=array();
        foreach ($tests as $k => $v) {
            $v['uType'] = trim($v['uType']);
            $test[]=$v;
        }

        if(!empty($test)){
            foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $res['list'][]=$v;
            }
        }
        if(empty($res['list'])){
            $res['err'] = '1';
            $res['list'] = null;
        }else{
            $res['err'] = '0';
        }
        return $res;
    }    
	
    public static function titleSearch($initial,$showType,$list,$p)
    {
        $res = array();
        /*if(count($list)>1){
           $arr = VerGuideManager::String($list);
        }else{
           $arr = $list[0]['id'];
        }*/
	$tmp = explode(',',$list);
        if(count($tmp)>1){
            //$arr = VerGuideManager::String($list);
            $arr = $list;
        }else{
            //$arr = $list[0]['id'];
            $arr = $list;
        }
        $p = ($p-1)*25;
        if(!empty($initial) && !empty($showType)){
            $sql_where = " where a.title like '%$initial%' and d.name like '%$showType%' and c.status=1 ";
        }else{
            $sql_where = " where a.title like '%$initial%' and c.status=1 ";
        }

        $sql_select = "select a.templateType,a.title,a.id,a.vid,a.type as uType,d.name as ShowType,d.id as cid from yd_ver_sitelist as d left join yd_ver_site as c on c.gid = d.id and d.id in ($arr) LEFT JOIN yd_video as a on a.vid=c.vid ";
        $sql_group_by  = " group by a.id";
        $sql_limit = " limit $p,25";
        $sql = $sql_select.$sql_where.$sql_group_by.$sql_limit;
        $tests = SQLManager::queryAll($sql);
        $sql_type = "select d.name as ShowType from yd_ver_sitelist as d left join yd_ver_site as c on c.gid = d.id and d.id in ($arr) LEFT JOIN yd_video as a on a.vid=c.vid ";
        $sql_type_group = " group by d.name";
        $sql_types = $sql_type . $sql_where . $sql_type_group;
        $res['types']=SQLManager::queryAll($sql_types);
        $sql_count = "select count(d.id) from yd_ver_sitelist as d left join yd_ver_site as c on c.gid = d.id and d.id in ($arr) LEFT JOIN yd_video as a on a.vid=c.vid ";
        $count = $sql_count.$sql_where.$sql_group_by;
        $total = SQLManager::queryAll($count);
        $res['count']=count($total);
	$res['total']=ceil(count($total)/25);
        $arr = array();
        $test=array();
        foreach ($tests as $k => $v) {
            $v['uType'] = trim($v['uType']);
            $test[]=$v;
        }

        if(!empty($test)){
        foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $res['list'][]=$v;
            }
        }
        if(empty($res['list'])){
            $res['err'] = '1';
            $res['list'] = null;
        }else{
            $res['err'] = '0';
        }
        return $res;
    }



    public static function getNewDetail($vid,$type){
        $res = array();
        $sql = "select type,vid as cid,title,duration as length,year,director,actor as star,info as introduction,keyword as lable,language,CountryOfOrigin as state from yd_video where vid='$vid'";
        //var_dump($sql);die;
        $tmp = SQLManager::queryRow($sql);
        //var_dump($tmp);die;
        if(!empty($tmp)){
            $vid = $tmp['cid'];
            switch($tmp['state']){
                case '0':$tmp['state']='其他';break;
                case '1':$tmp['state']='内地';break;
                case '2':$tmp['state']='港台';break;
                case '3':$tmp['state']='韩日';break;
                case '4':$tmp['state']='欧美';break;
                case '5':$tmp['state']='东南亚';break;
                case '99':$tmp['state']='其他';break;
            }
            //var_dump($language);die;
            if($type=='2'){
                $sql = "select v.type as uType,v.vid,l.cp,l.assetId,l.url from yd_video v inner join yd_video_list l on v.targetgroupassetid='$vid' and v.vid=l.vid and v.delFlag=1 and l.flag=1 group by l.assetId ";
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $data['total']=count($data['episode']);
                if(empty($data['total'])){
                    $data['total']=1;
                }
                //$sqls = "select v.vid as cid,v.title,p.url from yd_video v,yd_video_pic p where v.ShowType='Series' and p.type=1 and p.vid=v.vid and v.vid not in('$vid')  order by v.cTime limit 0,12";
                $sqls = "select v.type as uType,v.vid as cid,v.title,p.url from yd_video v inner join yd_video_pic p on v.ShowType='Series' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.vid  order by v.cTime limit 0,12";
                $tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($tmp['recommend'])){
                    $tmp['recommend']=array();
                }
            }else if($type=='1'){
                $sql = "select v.type as uType,v.vid,l.cp,l.assetId,l.url from yd_video v inner join yd_video_list l on v.vid='$vid' and v.vid=l.vid and l.flag=1 group by l.assetId";
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $sqls = "select v.type as uType,v.vid as cid,v.title,p.url from yd_video v inner join yd_video_pic p on v.ShowType='Movie' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.vid order by v.cTime limit 0,12";
                $tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($tmp['recommend'])){
                    $tmp['recommend']=array();
                }
            }else if($type=='3'){
                $sql = "select v.type as uType,v.vid,l.cp,l.assetId,l.url from yd_video v inner join yd_video_list l on v.vid='$vid' and v.vid=l.vid and l.flag=1 group by l.assetId";
                //var_dump($sql);
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $sqls = "select v.type as uType,v.vid as cid,v.title,p.url from yd_video v inner join yd_video_pic p on v.ShowType='News' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.vid  order by v.cTime  limit 0,12";
                $tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($tmp['recommend'])){
                    $tmp['recommend']=array();
                }
            }else if($type=='4'){
                $sql = "select v.type as uType,l.title,v.vid,l.cp,l.assetId,l.url from yd_video v inner join yd_video_list l on v.targetgroupassetid='$vid' and v.vid=l.vid and v.delFlag=1 and l.flag=1 group by l.assetId ";
                //var_dump($sql);
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=$match[0];
                    }
                }else{
                    $data['episode']=array();
                }
                $data['total']=count($data['episode']);
                if(empty($data['total'])){
                    $data['total']=1;
                }
                $type=$tmp['type'];
                $sqls = "select v.type as uType,v.vid as cid,v.title,p.url from yd_video v inner join yd_video_pic p on v.type='$type' and p.type=1 and p.vid=v.vid and v.vid not in('$vid') group by p.vid  order by v.cTime  limit 0,12";
                $tmp['recommend']=SQLManager::queryAll($sqls);
                if(empty($tmp['recommend'])){
                    $tmp['recommend']=array();
                }
            }else{
                $data['episode']=array();
                $data['total']=1;
                $tmp['recommend']=array();
            }
            $sqlpic = "select * from yd_video_pic where vid='$vid' and type=1";
            $pic=SQLManager::queryRow($sqlpic);
            $tmp['pic']='http://192.168.1.105/file/01.png';
            $tmp['score']='7.6';
            $res = array_merge($tmp,$data);

        }


        return $res;
    }

   public static function getGwDetail($vid,$type,$list)
    {
        $res = array();
        $sql = "select a.score,a.id,a.type,a.vid as cid,a.title,b.duration as length,a.year,a.director,a.actor as star,a.info as introduction,a.keyword as lable,a.language,a.CountryOfOrigin as state,a.simple_set,a.region from yd_video as a left join yd_video_list as b on a.vid=b.vid where a.vid='$vid' group by b.vid order by b.mediacoderate desc";
        //}
        //var_dump($sql);die;
        $tmp = SQLManager::queryRow($sql);
        //var_dump($tmp);die;
        if(!empty($tmp)){
            $vid = $tmp['cid'];
            /*switch($tmp['state']){
                case '0':$tmp['state']='其他';break;
                case '1':$tmp['state']='内地';break;
                case '2':$tmp['state']='港台';break;
                case '3':$tmp['state']='韩日';break;
                case '4':$tmp['state']='欧美';break;
                case '5':$tmp['state']='东南亚';break;
                case '99':$tmp['state']='其他';break;
                default:
                    $tmp['state']='其他';
                    break;
            }*/
	    if($tmp['state'] == '0'){
                $tmp['state']='其他';
            }else if($tmp['state'] == '1'){
                $tmp['state']='内地';
            }else if($tmp['state'] == '2'){
                $tmp['state']='港台';
            }else if($tmp['state'] == '3'){
                $tmp['state']='韩日';
            }else if($tmp['state'] == '4'){
                $tmp['state']='欧美';
            }else if($tmp['state'] == '5'){
                $tmp['state']='东南亚';
            }else if($tmp['state'] == '99' || $tmp['state'] == '100'){
                $tmp['state']='其他';
            }else{
                $tmp['state'] = $tmp['region'];
            }	
            $lable = $tmp['lable'];
            $pa = "/^[\d,']+$/";
            preg_match($pa, $lable, $match);
            //var_dump($match);die;
            $tmp['lable']=array();
            if(!empty($match)){
                $str = KeyWordManager::getKey($lable);
		$str[0]['type'] = $tmp['type'];
                $tmp['lable']=$str;
            }
            //var_dump($language);die;
            if($type=='2'){
                $sql = "select v.title,v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video v,yd_video_list l where v.targetgroupassetid='$vid' and v.vid=l.vid and v.delFlag=1 and l.flag=1 group by l.assetId order by v.order, l.mediacoderate";
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        //$pa = "/<|\m3u8|ts/";
                        //preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=ltrim($v['url'],'/');
                        $data['episode'][$k]['pid']='';
			$len = strlen($v['cTime']);
			$addLen = 8-$len;
			$tmp_str = '';
			for($i = 0 ; $i<$addLen/2; $i++){
				$tmp_str .='01';
			}
			$unixTime = $v['cTime'].$tmp_str;//echo $unixTime;die;
                        $data['episode'][$k]['cTime']=strtotime($unixTime);
                    }
                }else{
                    $data['episode']=array();
                }
                $data['total']=count($data['episode']);
                if(empty($data['total'])){
                    $data['total']=1;
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                $arrs = $arr.','.$arrs;
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists = SQLManager::queryAll($sql_list);
                $test=array();
                if(!empty($lists)){
                    //$lists = array(array('id'=>3));
                    $gidlist = VerGuideManager::String($lists);
                    $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                    $test=SQLManager::queryAll($sql_lists);
                }
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                    if(is_null($v['templateType'])){
                        switch($v['uType']){
                            case '电影':$v['templateType']='A';break;
                            case '电视剧':$v['templateType']='B';break;
                            case '综艺':$v['templateType']='C';break;
                            case '新闻':$v['templateType']='D';break;
                            default:$v['templateType']='D';break;
                        }
                    }
                    $tmp['recommend'][]=$v;
                }

            }else if($type=='1'){
                $sql = "select v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video v,yd_video_list l where (v.vid='$vid' or targetgroupassetid='$vid') and v.vid=l.vid and l.flag=1 group by l.assetId order by l.mediacoderate";
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        //$pa = "/<|\m3u8|ts/";
                        //preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=ltrim($v['url'],'/');
			$data['episode'][$k]['pid']='';
			$len = strlen($v['cTime']);
			$addLen = 8-$len;
			$tmp_str = '';
			for($i = 0 ; $i<$addLen/2; $i++){
				$tmp_str .='01';
			}
			$unixTime = $v['cTime'].$tmp_str;//echo $unixTime;die;
                        $data['episode'][$k]['cTime']=strtotime($unixTime);
                    }
                }else{
                    $data['episode']=array();
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                $arrs = $arr.','.$arrs;
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists=array();
                $lists = SQLManager::queryAll($sql_list);
                //$lists = array(array('id'=>3));
                if(!empty($lists)){
                    $gidlist = VerGuideManager::String($lists);
                }else{
                    $gidlist=$arrs;
                }
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                    if(is_null($v['templateType'])){
                        switch($v['uType']){
                            case '电影':$v['templateType']='A';break;
                            case '电视剧':$v['templateType']='B';break;
                            case '综艺':$v['templateType']='C';break;
                            case '新闻':$v['templateType']='D';break;
                            default:$v['templateType']='D';break;
                        }
                    }
                    $tmp['recommend'][]=$v;
                }
            }else if($type=='3'){
                $sql = "select v.title,v.type as uType,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video v,yd_video_list l where v.vid='$vid' and v.vid=l.vid and l.flag=1 group by l.assetId order by l.mediacoderate";
                //var_dump($sql);
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        //$pa = "/<|\m3u8|ts/";
                        //preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=ltrim($v['url'],'/');
			$data['episode'][$k]['pid']='';	
			$len = strlen($v['cTime']);
			$addLen = 8-$len;
			$tmp_str = '';
			for($i = 0 ; $i<$addLen/2; $i++){
				$tmp_str .='01';
			}
			$unixTime = $v['cTime'].$tmp_str;//echo $unixTime;die;
                        $data['episode'][$k]['cTime']=strtotime($unixTime);
                    }
                }else{
                    $data['episode']=array();
                }
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                $arrs = $arr.','.$arrs;
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                $lists = SQLManager::queryAll($sql_list);
                //$gidlist = VerGuideManager::String($lists);
		 if(!empty($lists)){
                    $gidlist = VerGuideManager::String($lists);
                }else{
                    $gidlist=$arrs;
                }
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                    if(is_null($v['templateType'])){
                        switch($v['uType']){
                            case '电影':$v['templateType']='A';break;
                            case '电视剧':$v['templateType']='B';break;
                            case '综艺':$v['templateType']='C';break;
                            case '新闻':$v['templateType']='D';break;
                            default:$v['templateType']='D';break;
                        }
                    }
                    $tmp['recommend'][]=$v;
                }

            }else if($type=='4'){
                $sql = "select v.type as uType,v.title,v.vid,v.spid,v.mms_id,v.targetgroupassetid as ParentNodeID,v.year as cTime,l.cp,l.assetId,l.mediafilepath as url,l.contid as ProgramID from yd_video v,yd_video_list l where v.targetgroupassetid='$vid' and v.vid=l.vid and v.delFlag=1 and l.flag=1 group by l.assetId order by v.order ,l.mediacoderate desc";
                //var_dump($sql);
                $episode= SQLManager::queryAll($sql);
                if(!empty($episode)){
                    foreach($episode as $k=>$v){
                        //$pa = "/<|\m3u8|ts/";
                        //preg_match($pa, $v['url'], $match);
                        $data['episode'][$k]=$v;
                        $data['episode'][$k]['url']=ltrim($v['url'],'/');
			$data['episode'][$k]['pid']='';
			$len = strlen($v['cTime']);
			$addLen = 8-$len;
			$tmp_str = '';
			for($i = 0 ; $i<$addLen/2; $i++){
				$tmp_str .='01';
			}
			$unixTime = $v['cTime'].$tmp_str;//echo $unixTime;die;
                        $data['episode'][$k]['cTime']=strtotime($unixTime);
                    }
                }else{
                    $data['episode']=array();
                }
                $data['total']=count($data['episode']);
                if(empty($data['total'])){
                    $data['total']=1;
                }
		//var_dump($list);die;
                $arr = VerGuideManager::String($list);
                $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
                $tmplist = SQLManager::queryAll($sql_s);
                $arrs = VerGuideManager::String($tmplist);
                $arrs = $arr.','.$arrs;
                $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
                //echo $sql_list;die;
		$lists = SQLManager::queryAll($sql_list);
                //$gidlist = VerGuideManager::String($lists);
		 if(!empty($lists)){
                    $gidlist = VerGuideManager::String($lists);
                }else{
                    $gidlist=$arrs;
                }
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('{$tmp['cid']}') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
                $tmp['recommend']=array();
                foreach($test as $k=>$v){
                    if(is_null($v['templateType'])){
                        switch($v['uType']){
                            case '电影':$v['templateType']='A';break;
                            case '电视剧':$v['templateType']='B';break;
                            case '综艺':$v['templateType']='C';break;
                            case '新闻':$v['templateType']='D';break;
                            default:$v['templateType']='D';break;
                        }
                    }
                    $tmp['recommend'][]=$v;
                }

            }else{
                $data['episode']=array();
                $data['total']=1;
                $tmp['recommend']=array();
            }
            //$sqlpic = "select url from yd_video_pic where vid='$vid' and type=1";
            $sqlpic = "select p.url,e.end from yd_video_pic p inner join yd_video_extra e on e.vid=p.vid and p.vid='$vid' and type=1";
            $pic=SQLManager::queryRow($sqlpic);
            $tmp['pic']=$pic['url'];
            $tmp['end']=$pic['end'];
            //$tmp['pic']='http://portalpic.itv.cmvideo.cn:8088/file/2b88e2c54bcd7eae452133e39c4b53b8.png';
            //$tmp['score']='7.6';
            $res = array_merge($tmp,$data);
        }


        return $res;
    } 


    public static function getGwDetailRecommend($vid,$type,$list)
    {
        $res = array();
        if($type=='2'){
            $arr = VerGuideManager::String($list);
            $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
            $tmplist = SQLManager::queryAll($sql_s);
            $arrs = VerGuideManager::String($tmplist);
            $arrs = $arr.','.$arrs;
            $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
            $lists = SQLManager::queryAll($sql_list);
            $test=array();
            if(!empty($lists)){
                $gidlist = VerGuideManager::String($lists);
                $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('$vid') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
                $test=SQLManager::queryAll($sql_lists);
            }
            $tmp=array();
            foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $tmp[]=$v;
            }

        }else if($type=='1'){
            $arr = VerGuideManager::String($list);
            $sql_s ="select id from yd_ver_sitelist where pid in ($arr)";
            $tmplist = SQLManager::queryAll($sql_s);
            $arrs = VerGuideManager::String($tmplist);
            $arrs = $arr.','.$arrs;
            $sql_list = "select gid from yd_ver_site where gid in ($arrs) and vid='$vid'";
            $lists=array();
            $lists = SQLManager::queryAll($sql_list);
            if(!empty($lists)){
                $gidlist = VerGuideManager::String($lists);
            }else{
                $gidlist=$arrs;
            }
            $sql_lists="select v.templateType,v.type as uType,v.vid as cid,v.title,p.url,s.gid as vid  from yd_ver_site s inner join yd_video v on s.gid in ($gidlist) and s.status=1 and s.vid=v.vid and s.vid not in ('$vid') inner join yd_video_pic p on v.vid=p.vid and p.type=1 group by v.vid order by s.order,s.upTime desc,s.id limit 0,12";
            $test=SQLManager::queryAll($sql_lists);
            $tmp=array();
            foreach($test as $k=>$v){
                if(is_null($v['templateType'])){
                    switch($v['uType']){
                        case '电影':$v['templateType']='A';break;
                        case '电视剧':$v['templateType']='B';break;
                        case '综艺':$v['templateType']='C';break;
                        case '新闻':$v['templateType']='D';break;
                        default:$v['templateType']='D';break;
                    }
                }
                $tmp[]=$v;
            }
        }
        return $tmp;
    }

}
