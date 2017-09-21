<?php
class ProvinceManager extends Province{
    public static function getList(){
        $sql = 'select * from yd_province';
        $list = SQLManager::queryAll($sql);
        return $list;
    }
}
