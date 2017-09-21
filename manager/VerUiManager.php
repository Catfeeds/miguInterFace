<?php


class VerUiManager extends VerUi
{
    /**
     * @return array
     * 获取布局数据
     */
    public static function getAll($gid){//$cp = '',$type = '',$provinceCode = '0',$cityCode = '0'
        $res = array();
        $criteria = new CDbCriteria();
        if(!empty($gid)){
            $criteria->addCondition('gid=:gid');
            $criteria->params[':gid'] = $gid;
        }
        $criteria->order="SUBSTRING(position ,2) asc";
        $mvui = self::model()->findAll($criteria);

        if(!empty($mvui)){
            foreach ($mvui as $v) {
                $res[$v['position']][] = $v->getAttributes();
            }
        }

        return $res;
    }

    public static function getData($gid,$pos){//$cp = '',$type = '',$provinceCode = '0',$cityCode = '0'
        $res = array();
        $criteria = new CDbCriteria();
        if(!empty($gid)){
            $criteria->addCondition('gid=:gid');
            $criteria->params[':gid'] = $gid;
        }
        if(!empty($pos)){
            $criteria->addCondition('position=:position');
            $criteria->params[':position'] = $pos;
        }
        $criteria->order="SUBSTRING(position ,2) asc";
        $mvui = self::model()->findAll($criteria);

        if(!empty($mvui)){
            foreach ($mvui as $v) {
                $res[$v['position']][] = $v->getAttributes();
            }
        }

        return $res;
    }

    public static function getTool($gid,$epg,$pos){//$cp = '',$type = '',$provinceCode = '0',$cityCode = '0'
        $res = array();
        $criteria = new CDbCriteria();
        if(isset($gid)){
            $criteria->addCondition('gid=:gid');
            $criteria->params[':gid'] = $gid;
        }
        if(isset($epg)){
            $criteria->addCondition('epg=:epg');
            $criteria->params[':epg'] = $epg;
        }
        if(!empty($pos)){
            $criteria->addCondition('position=:position');
            $criteria->params[':position'] = $pos;
        }
        $criteria->order="SUBSTRING(position ,2) asc";
        $mvui = self::model()->findAll($criteria);
        if(!empty($mvui)){
            foreach ($mvui as $v) {
                $res= $v->getAttributes();
            }
        }
        return $res;
    }


    public static function getKey($key,$arr){
        //var_dump($key);
        if(array_key_exists($key,$arr)){
            return $arr[$key];
        }
        return '';
    }

    public static function getList($gid){
        $res = array();
        //$sql = "select * from yd_ver_ui where gid='$gid' and delFlag='0' order by position";
        $sql = "select a.id,a.title,a.tType,a.param,a.action,a.pic,a.cp,a.addtime,a.upTime,a.vid,a.gid,a.type,a.uType from yd_ver_ui as a left join yd_video as b on a.vid=b.vid where a.gid='$gid' and a.delFlag='0' order by a.position";
        $res = SQLManager::queryAll($sql);
        return $res;
    }








}
