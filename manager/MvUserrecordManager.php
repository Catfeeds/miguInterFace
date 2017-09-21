<?php
class MvUserrecordManager extends MvNav
{
	public static function getList()
	{
		$sql_select = "select id,adminId,type,recordType,content,addTime,recordName ";
		$sql_from = " from yd_mv_userrecord ";
		$sql_order = " order by addTime desc";
		$sql_limit = " limit 10";
		$res = array();
		$query = $sql_select.$sql_from.$sql_order.$sql_limit;
		$res =  SQLManager::queryAll($query);
		return $res;		
	}

	public static function getPageList($p,$pagesize)
    {
        $res = array();
        $pageList_sql = "select id,adminId,type,recordType,content,addTime,recordName FROM yd_mv_userrecord order by addTime desc limit ".(($p-1)*$pagesize).",10";
        $res = SQLManager::queryAll($pageList_sql);
        return $res;
    }

    public static function getTotalPage()
    {
        $getTotalPage_sql = "select count(*) from yd_mv_userrecord";
        $res = SQLManager::queryAll($getTotalPage_sql);
        $total = ceil($res[0]['count(*)']/10);
        return $total;
    }
}
