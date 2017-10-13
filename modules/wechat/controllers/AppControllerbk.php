<?php

class AppController extends WController{
    public function actionDefault(){
        $this->render('default');
    }

    public function actionIndex(){
        $gid = $_REQUEST['nid'];
        $type = $_REQUEST['classify'];
        $tmp = WxSeapp::Model()->findAll("type='$type' and gid='$gid'");
        $app=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $app[]= $val->attributes;
            }
        }
        $this->render('index',array('app'=>$app));
    }

    public function actionIndexlist(){
        $gid = $_REQUEST['nid'];
        $type = $_REQUEST['classify'];
        $tmp = WxSeapp::Model()->findAll("type='$type' and gid=$gid");
        $app=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $app[]= $val->attributes;
            }
        }
        $this->render('indexlist',array('app'=>$app));
    }

    public function actionApp(){
        $gid = $_REQUEST['nid'];
        $type = $_REQUEST['classify'];
        $tmp = WxApp::Model()->findAll("type='$type'");
        $app=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $app[]= $val->attributes;
            }
        }
        //var_dump($app);die;
        $this->render('app',array('app'=>$app));
    }
    public function actionApplist(){
        $gid = $_REQUEST['nid'];
        $type = $_REQUEST['classify'];
        $tmp = WxApp::Model()->findAll("type='$type'");
        $app=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $app[]= $val->attributes;
            }
        }
        //var_dump($app);die;
        $this->render('applist',array('app'=>$app));
    }

    public function actionDetail(){
        //$type = $_REQUEST['classify'];
        $tmp = WxApp::Model()->findAll(array('order'=>'addTime desc'));
        $app=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $app[]= $val->attributes;
            }
        }
        //var_dump($app);die;
        $this->render('detail',array('app'=>$app));
    }
    public function actionAdd(){
        try{

            if(!empty($_GET['id']) && is_numeric($_GET['id'])){
                $app = WxApp::model()->findByPk($_GET['id']);

            }else{
                $app = new WxApp();
                $app -> addTime = time();
            }



            if(!empty($_POST)){
                $post = $_POST;
                $app -> type = $post['type'];
                $app -> downloadUrl = $post['downloadUrl'];
                $app -> name = $post['name'];
                $app -> appid = $post['appid'];
                $app -> packageName = $post['packageName'];
                $app -> creatorName = $post['creatorName'];
                $app -> size = $post['size'];
                $app -> action = $post['action'];
                $app -> param = $post['param'];
                $app -> description = $post['description'];
                $app -> version = $post['version'];
                $app -> tType = 3;
                if(!empty($_FILES['imgs']['tmp_name'])){
                    $filename = 'imgs';
                    $path = $this->up($filename);
                    $app -> imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
//                    print_r('http://' . $_SERVER['HTTP_HOST'] . '/wx/' . $path);
                }
                if(!$app->save()){
                    LogWriter::logModelSaveError($app,__METHOD__,$app->attributes);
                    throw new ExceptionEx('信息保存失败');
                }
                $this->PopMsg('保存成功');
                //$this->redirect($this->get_url('app','detail'));
                $this->redirect($this->createUrl('/wechat/app/index',array('mid'=>$_REQUEST['mid'],'nid'=>$_REQUEST['nid'],'classify'=>$post['type'])));
            }

        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $this->render("add",array('app'=>$app));
    }

    public function actionAppadd(){
        $gid=$_REQUEST['nid'];
        $arr=explode(' ',$_REQUEST['ids']);
        $type=$_REQUEST['classify'];
        foreach($arr as $k=>$v){
            if(!empty($v)){
                $wxmov = new WxSeapp();
                $result = WxApp::model()->find("id=$v");
                $sql = "select `orders` from yd_wx_seapp where type='$type' and gid=$gid order by `orders` desc limit 1";
                $return = Yii::app()->db->createCommand($sql)->queryRow();
                //var_dump($return);die;
                $wxmov->name = $result->name;
                $wxmov->imageUrl = $result->imageUrl;
                $wxmov->type = $result->type;
                $wxmov->downloadUrl = $result->downloadUrl;
                $wxmov->appid = $result->appid;
                $wxmov->gid = $gid;
                $wxmov -> action = $result->action;
                $wxmov -> param = $result->param;
                $wxmov->packageName = $result->packageName;
                $wxmov->creatorName = $result->creatorName;
                $wxmov->description = $result->description;
                $wxmov->size = $result->size;
                $wxmov->version = $result->version;
                $wxmov-> tType = 3;
                $wxmov->addTime = time();
                if($return){
                    $wxmov->orders = $return['orders']+1;
                }else{
                    $wxmov->orders='1';
                }
                if(!$wxmov->save()){
                    var_dump($wxmov->getErrors());
                }
            }
        }
    }
    public function actionDel(){
        if(!empty($_REQUEST['id'])){
            $id=$_REQUEST['id'];
            $wxmov=WxSeapp::model()->deleteByPk($id);
            if($wxmov){
                echo json_encode(array('code'=>200,'msg'=>'删除成功'));
            }else{
                echo json_encode(array('code'=>404,'msg'=>'删除失败'));
            }
        }

    }
    public function actionDels(){
        if(!empty($_REQUEST['id'])){
            $id=$_REQUEST['id'];
            $wxmov=WxApp::model()->deleteByPk($id);
            if($wxmov){
                echo json_encode(array('code'=>200,'msg'=>'删除成功'));
            }else{
                echo json_encode(array('code'=>404,'msg'=>'删除失败'));
            }
        }

    }
    public function actionUpdate(){
        if(!empty($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            $order=$_REQUEST['order'];
            $tmp=array_combine($id,$order);
            foreach($tmp as $key=>$val){
                $wxmov = WxSeapp::model()->find("id='$key'");
                $wxmov->orders = $val;
                if(!$wxmov->save()){
                    var_dump($wxmov->getErrors());
                }
            }
        }
        echo json_encode(array('code'=>'200'));

    }
    public function up($filename){
        if (!empty($filename)) {
            if ($_FILES[$filename]["error"] > 0) {
                $this->error('上传文件错误! 错误代码:' . $_FILES[$filename]['error'], '', 3);
            }
            $dir = Yii::app()->basePath . '/../file/';
            $name = date('YmdHis') . mt_rand(0000, 9999);
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
        return $path;
    }
    
}
