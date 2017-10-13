<?php

/*
 *
 */
class MessageController extends Controller{

    public function actionIndex(){
        $sql = "select * from yd_wxbox where number = '1111'";
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        $this->render('index');
    }
    public function actionAdd(){
        try{
            $message = new Message();
            if(!empty($_POST)){
                $message ->name  = trim($_POST['name']);
                $message ->stbid = trim($_POST['stbid']);
                $message ->info  = trim($_POST['info']);
                $message ->time  = time();
                if(!$message->save()){
                    LogWriter::logModelSaveError($message,__METHOD__,$message->attributes);
                    throw new ExceptionEx('数据发送失败');
                }
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $sql = "select * from yd_wxbox where number = '1111'";
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        $this->render('index',array('list'=>$list));

        //$this->render('index');
    }


    public function actionGetMessage(){
        if(empty($_REQUEST['stbid'])) return $this->ReturnData(['list'=>array(),'total'=>0]);
        $stbid = $_REQUEST['stbid'];
        $time = time();
        $qtime = time()-5;
        $criteria = new CDbCriteria();
        $criteria->condition = 'time>:qtime and time<:time and stbid =:stbid';
        $criteria->params = array(':qtime'=>$qtime,':time'=>$time,':stbid'=>$stbid);
        $criteria->order = 'time desc';
        $tmp = Message::model()->find($criteria);

        if(empty($tmp)){
            $res['name'] = '';
            $res['info'] = '';
        }else{
            $res['name'] = $tmp['name'];
            $res['info'] = $tmp['info'];
        }

        $num = MessageRead::model()->findAll("rTime < '$time' and rTime > '$qtime' and stbid ='$stbid'");

        if(empty($num)){
            $res['num'] = '';
        }else{
            $res['num'] = $num;
        }
        echo json_encode($res);
    }

    public function actionGetRead(){
        if(empty($_REQUEST['stbid'])) return $this->ReturnData(['list'=>array(),'total'=>0]);

        $stbid = $_REQUEST['stbid'];

        $page = 10;
        $data = $this->getPageInfo($page);
        $data['stbid'] = trim($_REQUEST['stbid']);
        $list = MessageReadManager::getReadList($data);

        $info = MessageRead::model()->find("stbid ='$stbid'");

        if(empty($info)){
            $info = new MessageRead();
            $info -> stbid = $stbid;
            $info -> rTime = time();

        }else{
            $info ->rTime = time();
        }
        $info ->save();

        $res['list'] = $list['list'];
        $res['total'] = ceil($list['count'] / $page);
        echo json_encode($res);
    }
}