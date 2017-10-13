<?php

/**
 * Created by PhpStorm.
 * User: xzm
 */
class SendController extends AController{

    public function actionIndex(){
        if(!empty($_POST['content'])){
            include "XMPP.php";
            $content = trim($_POST['content']);
            $message = '{body:{operation:"2",userId:"3332",terminalId:"3332",srcJid:"miguwechat@imshine.itv.cmvideo.cn",sesionId:"333",type:"1",message:"'.$content.'"}}';

            $conn = new XMPPHP_XMPP('imshine.itv.cmvideo.cn', 5222, 'miguwechat', 'miguwechat', 'xmpphp', 'imshine.itv.cmvideo.cn', $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);           
            $stbids =array_map(create_function('$record','return $record->attributes;'), Viptmp::model()->findAllBySql("select distinct stbid from yd_viptmp"));
            $stbid =array_map(create_function('$record','return $record->attributes;'), Wxbox::model()->findAllBySql("select distinct stbid from yd_wxbox"));
            $sum = Wxbox::model()->findBySql("select count(distinct stbid) as stbid from yd_wxbox");
          
            try {
                $conn->connect();
                $conn->processUntil('session_start');
                $conn->presence();
                foreach($stbids as $keys => $vals){
                    $conn->message(''.$vals['stbid'].'@imshine.itv.cmvideo.cn', $message);
                    usleep(8000);
                }
                foreach($stbid as $key => $val){
                    $conn->message(''.$val['stbid'].'@imshine.itv.cmvideo.cn', $message);
                    usleep(8000);
                }
                $conn->disconnect();
                $this->render("index",array('message'=>$message,'cnt'=>$sum->attributes['stbid']));
            } catch(XMPPHP_Exception $e) {
                die($e->getMessage());
            }
        }else{
            $sum = Wxbox::model()->findBySql("select count(distinct stbid) as stbid from yd_wxbox");
            $this->render("index",array('cnt'=>$sum->attributes['stbid']));
        }
    }
}
