<?php 
class ActiveTwopicManager extends WxGuide
{
    public static function getList($p)
    {
        $res = array();
        // ($Page- 1) * $PageSize, $PageSize
        date_default_timezone_set('Asia/Shanghai'); 
        $time = strtotime('-1 ,day');
        $p = $p*5;
        $sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where cTime <= $time limit $p,5";
        $res = SQLManager::queryAll($sql);
        $countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where cTime <= $time";
        $length = SQLManager::queryAll($countsql);
        $count = count($length);
        $res['res'] = $res;
        $res['count'] = $count;
       
        return $res;
    }

	public static function getProvinces(){
        $sql = "select * from yd_province";
		$row = SQLManager::queryAll($sql);
		return $row;
	}

	public static function getCitys(){
		$sql = "select * from yd_city";
		$row = SQLManager::queryAll($sql);
		return $row;
	}

    public static function getProvince($pro)
  	{
  		
  		$sql = "select provinceName from yd_province where provinceCode = $pro";
  		$row = SQLManager::queryAll($sql);
  		$row = $row[0]['provinceName'];
  		return $row;
  	} 

  	public static function getCity($city)
  	{
		if($city!=0){
			$sql = "select cityName from yd_city where cityCode = $city";
			$row = SQLManager::queryAll($sql);
			if(!empty($row)){
				$row = $row[0]['cityName'];
			}else{
				$row='全部地级市';
			}
		}else{
			$row='全部地级市';
		}
		return $row;
  	}

  	public static function getProvinceSelect()
  	{
  		$res = array();
        $sql = "select provinceName ,provinceCode from  yd_province";
        $res = SQLManager::queryAll($sql);
        return $res;
  	}

  	public static function getCitySelect()
  	{
  		$res = array();
        $sql = "select CityName ,CityCode from  yd_city";
        $res = SQLManager::queryAll($sql);
        return $res;
  	}

  	public static function getListTime($first,$end,$p)
  	{
  		$res = array();
  		$p = $p*5;
  		$sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where cTime >=$first and cTime <=$end limit $p,5 ";
  		$res = SQLManager::queryAll($sql);
        $countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where cTime >=$first and cTime <=$end";
        $length = SQLManager::queryAll($countsql);
        $count = count($length);
        $res['res'] = $res;
        $res['count'] = $count;
        return $res;
  	}

  	public static function getListKeyword($keyword,$p)
  	{
  		$res = array();
  		$p = $p*5;
  		$sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where title like '%".$keyword."%' limit $p, 5";
  		$res = SQLManager::queryAll($sql);
        $countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where title like '%".$keyword."%' ";
        $length = SQLManager::queryAll($countsql);
        $count = count($length);
        $res['res'] = $res;
        $res['count'] = $count;
        return $res;
  	}

  	public static function getListAll($keyword,$first,$end,$p,$province,$city)
  	{
  		$res = array();
  		$p = $p*5;
		if(!empty($province) && !empty($city)){
			$sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='.$province.' and city='.$city.' limit $p, 5";
			$countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='.$province.' and city='.$city.'";
		}else if(!empty($province) && empty($city)){
			$sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='.$province.' limit $p, 5";
			$countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='.$province.'";
		}else if(!empty($city) && empty($province)){
			$sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and city='.$city.' limit $p, 5";
			$countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  )  and city='.$city.'";
		}else{
			$sql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from  yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) limit $p, 5";
			$countsql = "select uid,type,province,city,cp,epg,cid ,cTime,vname,title,pos,rand from yd_active_onepic where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) ";
		}

  		$res = SQLManager::queryAll($sql);

        $length = SQLManager::queryAll($countsql);
        $count = count($length);
        $res['res'] = $res;
        $res['count'] = $count;

        return $res;
  	}

	public static function getClick($keyword,$first,$end,$p,$province,$city,$usergroup,$epgcode){
		$res = array();
		$p = $p*5;
		$sql_select = "select *,count(*) as total,max(from_unixtime(cTime)) as time,min(from_unixtime(cTime)) as mintime";
		$sql_from = " from yd_active_twopic ";
                if(!empty($usergroup)){
                    if(!empty($keyword)){
                        $sql_where ="where title like '%".$keyword."%' and usergroup='$usergroup' and (cTime >= $first and cTime <= $end  )";
                    }else{
                        $sql_where ="where usergroup='$usergroup' and (cTime >= $first and cTime <= $end  )";
                    }
                }else if(!empty($epgcode)){
                    if(!empty($keyword)){
                        $sql_where ="where title like '%".$keyword."%' and epgcode='$epgcode' and (cTime >= $first and cTime <= $end  )";
                    }else{
                        $sql_where ="where epgcode='$epgcode' and (cTime >= $first and cTime <= $end  )";
                    }
                }else{ 
		if(!empty($keyword) && !empty($province) && !empty($city)){
			$sql_where = " where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='$province' and city='$city'";
		}else if(!empty($keyword) && !empty($province)){
			$sql_where = " where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='$province'";
		}else if(!empty($keyword)){
			$sql_where = " where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  )";
		}else if(!empty($province) && empty($city)){
			$sql_where = " where province='$province' and (cTime >= $first and cTime <= $end  )";
		}else if(!empty($province) && !empty($city)){
			$sql_where = " where (cTime >= $first and cTime <= $end  ) and province='$province' and city='$city'";
		}else{
			$sql_where = " where (cTime >= $first and cTime <= $end  )";
		}
                }
		$sql_limit = " limit $p,5";
		$sql_group = " group by title,epg";
		$sql = $sql_select . $sql_from . $sql_where .$sql_group . $sql_limit;
		$countsql = $sql_select . $sql_from . $sql_where .$sql_group;
		$res['res'] = SQLManager::queryAll($sql);
		$length = SQLManager::queryAll($countsql);
		$count = count($length);
		$res['count'] = $count;
		return $res;
	}

	public static function getClicks($keyword,$first,$end,$province,$city,$usergroup,$epgcode){
		$res = array();
		$sql_select = "select province,city,cp,cid,epg,title,min(from_unixtime(cTime)) as mintime,max(from_unixtime(cTime)) as time,count(*) as total";
		$sql_from = " from yd_active_twopic ";
                if(!empty($usergroup)){
                    if(!empty($keyword)){
                        $sql_where ="where title like '%".$keyword."%' and usergroup='$usergroup' and (cTime >= $first and cTime <= $end  )";
                    }else{
                        $sql_where ="where usergroup='$usergroup' and (cTime >= $first and cTime <= $end  )";
                    }
                }else if(!empty($epgcode)){
                    if(!empty($keyword)){
                        $sql_where ="where title like '%".$keyword."%' and epgcode='$epgcode' and (cTime >= $first and cTime <= $end  )";
                    }else{
                        $sql_where ="where epgcode='$epgcode' and (cTime >= $first and cTime <= $end  )";
                    }
                }else{
		if(!empty($keyword) && !empty($province) && !empty($city)){
			$sql_where = " where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='$province' and city='$city'";
		}else if(!empty($keyword) && !empty($province)){
			$sql_where = " where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  ) and province='$province'";
		}else if(!empty($keyword)){
			$sql_where = " where title like '%".$keyword."%' and (cTime >= $first and cTime <= $end  )";
		}else if(!empty($province) && empty($city)){
			$sql_where = " where province='$province' and (cTime >= $first and cTime <= $end  )";
		}else if(!empty($province) && !empty($city)){
			$sql_where = " where (cTime >= $first and cTime <= $end  ) and province='$province' and city='$city'";
		}else{
			$sql_where = " where (cTime >= $first and cTime <= $end  )";
		}
                }
		$sql_group = " group by title,epg";
		$sql = $sql_select . $sql_from . $sql_where .$sql_group ;
		$res['res']= SQLManager::queryAll($sql);
		return $res;
	}
  	
}
