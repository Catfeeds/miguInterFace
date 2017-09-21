<?php
class MeiziManager extends WxGuide
{
    public static function getList()
    {
        $res = array();
        $cp_sql = "select id,vid,cp,title,info,short,keyword,actor,director,year,type,cate,cTime,language from yd_video limit 10";
        $res =  SQLManager::queryAll($cp_sql);
        return $res;
    }

    public static function getPageList($p,$pagesize)
    {
        $res = array();
        $pageList_sql = "select id,cp,title,info,actor,director,cate,language FROM yd_video limit ".(($p-1)*$pagesize).",10";
        $res = SQLManager::queryAll($pageList_sql);
        return $res;
    }

    public static function getTotalPage()
    {
        $getTotalPage_sql = "select count(*) from yd_video";
        $res = SQLManager::queryAll($getTotalPage_sql);
        $total = ceil($res[0]['count(*)']/10);
        return $total;
    }

    public static function getSeach($keyword,$cp,$language,$type)
    {
        $res = array();
        if(!empty($keyword) && !empty($cp) && !empty($language) && !empty($type)){
            $seach_sql = " cp='".$cp."' AND language='".$language."' And type='".$type."' AND title like '%".$keyword."%' limit 10";
        }
        if(!empty($cp)){
            $cp_sql = " cp='".$cp."'";
        }
        if(!empty($language)){
            if(empty($cp)){
                $language_sql = " language='".$language."'";
            }else{
                $language_sql = " AND language='".$language."'";

            }
        }
        if(!empty($type)){
            if(empty($language) && empty($cp)){
                $type_sql = " type='".$type."'";
            }else{
                $type_sql = " AND type='".$type."'";
            }

        }
        if(!empty($keyword)){
            if(empty($language) && empty($cp) && empty($type)){
                $keyword_sql = "title like '%".$keyword."%'";
            }else{
                $keyword_sql = " AND title like '%".$keyword."%'";
            }
        }

        if(empty($keyword)){
            $keyword_sql='';
        }
        if(empty($language)){
            $language_sql = '';
        }
        if(empty($cp)){
            $cp_sql = '';
        }

        if(empty($type)){
            $type_sql = '';
        }
        $sql = "select id,cp,title,info,actor,director,cate,language FROM yd_video WHERE ";
        $sql = $sql.$cp_sql.$language_sql.$type_sql.$keyword_sql." limit 10";
//        var_dump($sql);die;
        $res = SQLManager::queryAll($sql);
        $res['res'] = $res;
//        var_dump($res);die;
        $total_sql = "select count(*) from yd_video where ".$cp_sql.$language_sql.$type_sql.$keyword_sql;
        $total = SQLManager::queryAll($total_sql);
//        var_dump($total);die;
        $res['seachPage'] = ceil($total[0]['count(*)']/10);
        return $res;
    }


    public static function getSeachPage($keyword,$cp,$language,$type,$p,$pagesize)
    {
        $res = array();
        if(!empty($keyword) && !empty($cp) && !empty($language) && !empty($type)){
            $seach_sql = " cp='".$cp."' AND language='".$language."' And type='".$type."' AND title like '%".$keyword."%' limit 10";
        }
        if(!empty($cp)){
            $cp_sql = " cp='".$cp."'";
        }
        if(!empty($language)){
            if(empty($cp)){
                $language_sql = " language='".$language."'";
            }else{
                $language_sql = " AND language='".$language."'";

            }
        }
        if(!empty($type)){
            if(empty($language) && empty($cp)){
                $type_sql = " type='".$type."'";
            }else{
                $type_sql = " AND type='".$type."'";
            }

        }
        if(!empty($keyword)){
            if(empty($language) && empty($cp) && empty($type)){
                $keyword_sql = "title like '%".$keyword."%'";
            }else{
                $keyword_sql = " AND title like '%".$keyword."%'";
            }
        }

        if(empty($keyword)){
            $keyword_sql='';
        }
        if(empty($language)){
            $language_sql = '';
        }
        if(empty($cp)){
            $cp_sql = '';
        }

        if(empty($type)){
            $type_sql = '';
        }
        $sql = "select id,cp,title,info,actor,director,cate,language FROM yd_video WHERE ";
        $sql = $sql.$cp_sql.$language_sql.$type_sql.$keyword_sql." limit ".(($p-1)*$pagesize).",10";
        $res = SQLManager::queryAll($sql);
//        $res['res'] = $res;
//        $res['seachPage'] = count($res);
        return $res;
    }


    public static function getAddinfo($id)
    {
        $res = array();
        $sql = "select id,title,director,actor,info,cp,type from yd_video where id=$id";
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function doInsert($list)
    {
        $list = $list[0];
        $title = $list['title'];
        $title = "\"".$title."\"";
        $info = $list['info'];
        $info = "\"".$info."\"";
        $actor = $list['actor'];
        $actor = "\"".$actor."\"";
        $director = $list['director'];
        $director = "\"".$director."\"";
        $cp = $list['cp'];
        switch($cp)
        {
            case "642001"  :$cp = 1;break;
            case "BESTVOTT":$cp = 2;break;
            case "ICNTV"   :$cp = 3;break;
            case "youpeng" :$cp = 4;break;
            case "HNBB"    :$cp = 5;break;
            case "CIBN"    :$cp = 6;break;
            case "YGYH"    :$cp = 7;break;
        }
        $cp = "\"".$cp."\"";
        $type = $list['type'];
        $type = "\"".$type."\"";
        $time = time();
        $sql = "insert into yd_wx_movie(title,info,actor,director,cp,type,addTime,img,classify,action,param,orders) VALUES($title,$info,$actor,$director,$cp,$type,$time,'','','','','')";
        $res = SQLManager::execute($sql);
        return $res;
    }

    public static function getCpinfo()
    {
        $res = array();
        $sql = "select cp from yd_video GROUP BY cp";
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function getTypeinfo()
    {
        $res = array();
        $sql = "select type from yd_video GROUP BY type";
        $res = SQLManager::queryAll($sql);
        return $res;
    }

    public static function getLanguageinfo()
    {
        $res = array();
        $sql = "select language from yd_video GROUP BY language";
        $res = SQLManager::queryAll($sql);
        return $res;
    }
}
