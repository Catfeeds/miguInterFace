<?php
/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2016/3/15
 * Time: 17:44
 */
class AresController extends WController{
    public function actionIndex(){
        $SearchMsgType = isset($_GET['SearchMsgType']) ? $_GET['SearchMsgType'] : '';
        if(empty($SearchMsgType)){ $SearchMsgType="video";}
        // $arr = AutomaticReply::model()->findAll("msgtype = '$SearchMsgType'");

        //分页
        $page = 20;
        $data = $this->getPageInfo($page);
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->addCondition("msgtype = '$SearchMsgType' and cp = 1");
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

                $automaticreply->msgtype = $msgtype;
                $automaticreply->key_word = $key_word;
                $automaticreply->data_type = '1';
                $automaticreply->data_status = '1';
                $automaticreply->update_time = $gettime;
                $automaticreply->cp = 1;


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
                $this->redirect($this->get_url('ares', 'index'));
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