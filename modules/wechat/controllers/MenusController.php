<?php
/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2016/3/7
 * Time: 13:35
 */
class MenusController extends WController{

    public function actionDefault(){
        $this->render("default");
    }

    public function actionIndex()
    {

//        $ListOne = WxMenu::model()->findAll(array('condition' => 'data_status=:data_status AND father_id=:father_id', 'params' => array(':data_status' => '1', ':father_id' => '0'), 'order' => 'data_sort ASC,id ASC'));
        $ListOne = WxMenu::model()->findAll(array('condition' => ' father_id=:father_id', 'params' => array(':father_id' => '0'), 'order' => 'data_sort ASC,id ASC'));
        $_list = array();
        foreach ($ListOne as $key => $value) {
            if(($value["data_type"]=="media_id" or $value["data_type"]=="view_limited") and !empty($value["media_id"]) ){
                $getoneWechatMaterialOne = WxMaterial::model()->findAll("media_id='$value[media_id]'");
                //print_r($getoneWechatMaterialOne);die();
                $value['MaterialTitle'] = isset($getoneWechatMaterialOne) ? $getoneWechatMaterialOne[0]['title'] : '';
            }
//            $ListTwo = WxMenu::model()->findAll(array('condition' => 'data_status=:data_status AND father_id=:father_id', 'params' => array(':data_status' => '1', ':father_id' => $value['id']), 'order' => 'data_sort ASC,id ASC'));
            $ListTwo = WxMenu::model()->findAll(array('condition' => ' father_id=:father_id', 'params' => array(':father_id' => $value['id']), 'order' => 'data_sort ASC,id ASC'));
            $_ListTwo = array();
            foreach ($ListTwo as $k => $val) {
                $val['MaterialTitle'] = '';
                if (($val["data_type"] == "media_id" or $val["data_type"] == "view_limited") and !empty($val["media_id"])) {
                    $getoneWechatMaterialTwo = WxMaterial::model()->findAll("media_id='$val[media_id]'");
                    $val['MaterialTitle'] = !empty($getoneWechatMaterialTwo) ? $getoneWechatMaterialTwo[0]['title'] : '';
                    //$val['MaterialTitle'] = isset($getoneWechatMaterialTwo) ? $getoneWechatMaterialTwo[0]['title'] : '';
                }
                $_ListTwo[] = $val;
            }
            $value["ChildrenList"]=$_ListTwo;
            $_list[]=$value;
        }
        $this -> render('index',array('arr'=>$_list));
    }

    public function actionAdd(){

        try{
            if(!empty($_GET['id'])){
                $wxmenu = WxMenu::model()->findByPk($_GET['id']);
                //print_r($wxmenu['father_id']);die();
                $wxmenu -> update_time = time();
            }else{
                $wxmenu = new WxMenu();
                $wxmenu -> create_time = time();
            }
            if(!empty($_POST)) {

                $father_id = isset($_POST['father_id']) ? trim($_POST['father_id']) : '';
                $data_type = isset($_POST['data_type']) ? trim($_POST['data_type']) : '';
                $title     = isset($_POST['title']) ? trim($_POST['title']) : '';
                $url       = isset($_POST['url']) ? trim($_POST['url']) : '';
                $btn_key   = isset($_POST['btn_key']) ? trim($_POST['btn_key']) : '';
                $media_id  = isset($_POST['media_id']) ? trim($_POST['media_id']) : '';
                $data_sort = isset($_POST['data_sort']) ? trim($_POST['data_sort']) : '';
                $description = isset($_POST['description']) ? trim($_POST['description']) : '';

                $wxmenu -> father_id   = $father_id;
                $wxmenu -> data_type   = $data_type;
                $wxmenu -> title       = $title;
                $wxmenu -> url         = $url;
                $wxmenu -> btn_key     = $btn_key;
                $wxmenu -> media_id    = $media_id;
                $wxmenu -> data_sort   = $data_sort;
                $wxmenu -> description = $description;
                $wxmenu -> data_status = 1;

                if (!$wxmenu->save()) {
                    LogWriter::logModelSaveError($wxmenu, __METHOD__, $wxmenu->attributes);
                    throw new ExceptionEx('保存失败!');
                }
                $this->redirect($this->get_url('menus', 'index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }


        //父类菜单
        $connection = Yii::app()->db;
        $sql="select * from yd_wx_menu where data_status=1 AND father_id=0 order by data_sort asc,id asc";
        $command = $connection->createCommand($sql);
        $ListWxMenu = $command->queryAll();


        //图片素材
        $connection = Yii::app()->db;
        $sql="select * from yd_wx_material where data_type='image' order by create_time DESC limit 0,10";
        $command = $connection->createCommand($sql);
        $ListWxMaterialImages = $command->queryAll();

        //视频素
        $connection = Yii::app()->db;
        $sql="select * from yd_wx_material where data_type='video' order by create_time DESC limit 0,10";
        $command = $connection->createCommand($sql);
        $ListWxMaterialVideo = $command->queryAll();


        //语音素材
        $connection = Yii::app()->db;
        $sql="select * from yd_wx_material where data_type='voice' order by create_time DESC limit 0,10";
        $command = $connection->createCommand($sql);
        $ListWxMaterialVoice = $command->queryAll();


        //图文素材
        $connection = Yii::app()->db;
        $sql="select * from yd_wx_material where data_type='news' OR data_type='atricles' order by create_time DESC limit 0,10";
        $command = $connection->createCommand($sql);
        $ListWxMaterialArticles = $command->queryAll();



        $connection = Yii::app()->db;
        $sql="select * from yd_wx_material where data_type='thumb' order by create_time DESC limit 0,10";
        $command = $connection->createCommand($sql);
        $ListWechatMaterialThumb = $command->queryAll();

        //print_r($ListWxMaterialArticles);
        $this -> render("add",array('ListWxMenu'=>$ListWxMenu,'ListWxMaterialArticles'=>$ListWxMaterialArticles,'ListWxMaterialVideo'=>$ListWxMaterialVideo,'ListWxMaterialVoice'=>$ListWxMaterialVoice,'wxmenu'=>$wxmenu));
    }

    public function actionDel(){
        if(empty($_POST['id']) || !is_numeric($_POST['id'])){
            $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        }
        $wxmenu = WxMenu::model()->deleteByPk($_POST['id']);
        if(!$wxmenu){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }




}