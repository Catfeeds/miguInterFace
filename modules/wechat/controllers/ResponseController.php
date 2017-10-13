<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/28
 * Time: 17:11
 */
class ResponseController extends WController{


    public function actionDefault(){
        $this->render("default");
    }

    public function actionIndex(){
        $SearchMsgType = isset($_GET['SearchMsgType']) ? $_GET['SearchMsgType'] : '';
        if(empty($SearchMsgType)){ $SearchMsgType="video";}
       // $arr = AutomaticReply::model()->findAll("msgtype = '$SearchMsgType'");

        $id=$_GET['nid'];
        if(!empty($id)){
            if($id==12){
                $cp = '1';
            }
            if($id==23){
                $cp = '2';
            }
            if($id==24){
                $cp = '3';
            }
            if($id==25){
                $cp = '4';
            }
            if($id==26){
                $cp = '5';
            }
            if($id==27){
                $cp = '6';
            }
            if($id==28){
                $cp = '7';
            }
            if($id==11){
                $cp = '8';
            }
        }


        //分页
        $page = 20;
        $data = $this->getPageInfo($page);
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->addCondition("msgtype = '$SearchMsgType' and cp = '$cp'");
        $criteria->offset = $data['start'];
        $criteria->limit = $data['limit'];
        $count = AutomaticReply::model()->count($criteria);
        $url = $this->createUrl($this->action->id);
        $arr = AutomaticReply::model()->findAll($criteria);
        $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);

        $this->render('index',array('SearchMsgType'=>$SearchMsgType,'arr'=>$arr,'page'=>$pagination));
    }

    public function actionAdd(){
        try{
            if(!empty($_GET['id'])){
                $automaticreply = AutomaticReply::model()->findByPk($_GET['id']);
            }else{
                $automaticreply = new AutomaticReply();
                $ids=$_GET['nid'];
                if(!empty($ids)){
                    if($ids==12){
                        $automaticreply -> cp = '1';
                    }
                    if($ids==23){
                        $automaticreply -> cp = '2';
                    }
                    if($ids==24){
                        $automaticreply -> cp = '3';
                    }
                    if($ids==25){
                        $automaticreply -> cp = '4';
                    }
                    if($ids==26){
                        $automaticreply -> cp = '5';
                    }
                    if($ids==27){
                        $automaticreply -> cp = '6';
                    }
                    if($ids==28){
                        $automaticreply -> cp = '7';
                    }
                    if($ids==11){
                        $automaticreply -> cp = '8';
                    }
                }
            }

            if(!empty($_POST)) {

                $msgtype = trim($_POST['msgtype']);
                $key_word = isset($_POST['key_word']) ? trim($_POST['key_word']): '';
                $gettime = time();


                $text_description = isset($_POST['text_description']) ? trim($_POST['text_description']) : '';

                //图片素材的media_id
                $image_media_id = isset($_POST['image_media_id']) ? trim($_POST['image_media_id']) : '';
                //图片素材的url
                $image_link_url = isset($_POST['image_link_url']) ? trim($_POST['image_link_url']) : '';




                $video_title = isset($_POST['video_title']) ? trim($_POST['video_title']) : '';
                $video_description = isset($_POST['video_description']) ? trim($_POST['video_description']) : '';

                //视频素材的media_id
                $video_media_id = isset($_POST['video_media_id']) ? trim($_POST['video_media_id']) : '';




                //语音素材的media_id
                $voice_media_id = isset($_POST['voice_media_id']) ? trim($_POST['voice_media_id']) : '';


                $attention_description = isset($_POST['attention_description']) ? trim($_POST['attention_description']) : '';

                $auto_description = isset($_POST['auto_description']) ? trim($_POST['auto_description']) : '';

                if ($msgtype == "text") {
                    if (empty($text_description)) throw new ExceptionEx('文本不能为空！');
                } elseif ($msgtype == "image") {
                    $filename = 'image_link_url';
                } elseif ($msgtype == "voice") {
                    $filename = 'voice_link_url';
                } elseif ($msgtype == "video") {
                    $filename = 'video_link_url';
                } elseif ($msgtype == "attention"){
                    if (empty($attention_description)) throw new ExceptionEx('描述不能为空！');
                } elseif ($msgtype == "auto"){
                    if (empty($auto_description)) throw new ExceptionEx('描述不能为空！');
                }


                //验证上传内容
                /*if (!empty($filename)) {
                    if ($_FILES[$filename]["error"] > 0) {
                        $this->error('上传文件错误! 错误代码:' . $_FILES[$filename]['error'], '', 3);
                    }
                    $dir = Yii::app()->basePath . '/../wxfile/';
                    $name = date('YmdHis') . mt_rand(0000, 9999);
                    //$expand_arr = explode('/',$_FILES['media']['type']);
                    //$expand = '.'.$expand_arr[1];
                    $expand = '.' . pathinfo($_FILES[$filename]['name'], PATHINFO_EXTENSION);
                    if (is_uploaded_file($_FILES[$filename]["tmp_name"])) {
                        if (move_uploaded_file($_FILES[$filename]["tmp_name"], $dir . $name . $expand)) {
                            $path = $name . $expand;
                            //$path = isset($name) ? $name . $expand : '';
                        } else {
                            $this->error('上传服务器临时错误');
                        }
                    } else {
                        $this->error('非法上传方法');
                    }
                }
                */

                $automaticreply->msgtype = $msgtype;
                $automaticreply->key_word = $key_word;
                $automaticreply->data_type = '1';
                $automaticreply->data_status = '1';
                $automaticreply->update_time = $gettime;
                //$automaticreply->cp = 2;


                if ($automaticreply->isNewRecord) {
                    $automaticreply->create_time = $gettime;
                }

                if ($msgtype == 'text') {//文本消息
                    $automaticreply->description = $text_description;
                } elseif ($msgtype == "image") {//图片消息

                        $automaticreply->link_url = $image_link_url;
                        $automaticreply->media_id = $image_media_id;


                } elseif ($msgtype == "voice") {//语音消息

                        $automaticreply->media_id = $voice_media_id;


                } elseif ($msgtype == "video") {//视频消息
                    $automaticreply->description = $video_description;
                    $automaticreply->title = $video_title;
                    $automaticreply->media_id = $video_media_id;
                } elseif($msgtype == "attention"){
                    $automaticreply->description = $attention_description;
                } elseif($msgtype == "auto"){
                    $automaticreply->description = $auto_description;
                }

                if (!$automaticreply->save()) {
                    LogWriter::logModelSaveError($automaticreply, __METHOD__, $automaticreply->attributes);
                    throw new ExceptionEx('保存失败!');
                }
                $this->redirect($this->get_url('response', 'index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }



        $MsgType = isset($_GET['msgtype']) ? $_GET['msgtype'] : '';
        //print_r($_GET['msgtype']);die();
        $this->render('add'.$MsgType,array('MsgType'=>$MsgType,'automaticreply'=>$automaticreply));
    }


    public function actionDel(){
        if(empty($_POST['id']) || !is_numeric($_POST['id'])){
            $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        }
        $AutomaticReply = AutomaticReply::model()->deleteByPk($_POST['id']);
        if(!$AutomaticReply){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }
    public function error(){
        echo "error";
    }

}