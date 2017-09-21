<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4 0004
 * Time: 13:51
 */
class MovieController extends WController{

    public function actionDefault(){
        $this->render("default");
    }

    public function actionIndex(){
            $gid = !empty($_REQUEST['mid'])?$_REQUEST['mid']:'0';
            $page = 5;
            $data = $this->getPageInfo($page);
            $criteria = new CDbCriteria();
            $criteria->select = '*';

            if(!empty($_GET['cp']) && $_GET['cp'] ==1){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 1;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==2){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 2;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==3){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 3;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==4){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 4;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==5){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 5;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==6){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 6;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==7){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 7;
            }elseif(!empty($_GET['cp']) && $_GET['cp'] ==8){
                $criteria -> addCondition('cp = :cp');
                $criteria -> params[':cp'] = 8;
            }
            if(!empty($_GET['title'])){
                //$criteria -> addCondition('title = :title');
                //$criteria -> params[':title'] = $_GET['title'];
                $criteria -> addSearchCondition('title',$_GET['title']);
            }
            if(!empty($_GET['classify'])){
                $criteria -> addCondition('classify = :classify');
                $criteria -> params[':classify'] = $_GET['classify'];
            }
            $count = WxMovie::model()->count($criteria);
            $criteria->addNotInCondition('classify', array('0'=>'轮播'));
            //$criteria->compare('gid', $gid);
            $criteria->offset = $data['start'];
            $criteria->limit = $data['limit'];
            $criteria->order = 'addTime desc';
            //$criteria->params = array(':gid' => $gid);
            //var_dump($criteria);die;
            $list = WxMovie::model()->findAll($criteria);
            //var_dump($list);die;
            $url = $this->createUrl($this->action->id);
            $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);
            $this->render('index',array('list'=>$list,'page'=>$pagination));
    }

    public function actionLunbo(){
        $gid= $_REQUEST['nid'];
        //$classify='轮播';
        $tmp = WxLunbo::model()->findAll("gid='$gid'");
        //var_dump($tmp);die;
        $lunbo=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $lunbo[]= $val->attributes;
            }
        }
        $this->render('lunbo',array('lunbo'=>$lunbo));
    }
    
    public function actionLunboadd(){
        try{

            if(!empty($_GET['id']) && is_numeric($_GET['id'])){
                $movie = WxLunbo::model()->findByPk($_GET['id']);
            }else{
                $movie = new WxLunbo();
                $movie -> addTime = time();
            }


            if(!empty($_POST)){
                $post = $_POST;
                //$sql = 'select `orders` from yd_wx_select where classify="轮播" order by `orders` desc limit 1';
                //$return = Yii::app()->db->createCommand($sql)->queryRow();
                $movie -> type = $post['type'];
                $movie -> cp = $post['cp'];
                $movie -> title = $post['title'];
                $movie -> classify = $post['classify'];
                $movie -> action = $post['action'];
                $movie -> param = $post['param'];
                $movie -> director = $post['director'];
                $movie -> actor = $post['actor'];
                $movie -> info = $post['info'];
                $movie -> gid = $_REQUEST['gid'];
                $movie -> addTime = time();
                if(!empty($_FILES['imgs']['tmp_name'])){
                    $filename = 'imgs';
                    $path = $this->up($filename);
                    $movie -> img = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                    //$movie -> img = 'http://portalpic.itv.cmvideo.cn:8088/file/' . $path;
                    //Common:fspost($path);
//                    print_r('http://' . $_SERVER['HTTP_HOST'] . '/wx/' . $path);
                }
                if(!$movie->save()){
                    var_dump($movie->getErrors());
                    LogWriter::logModelSaveError($movie,__METHOD__,$movie->attributes);
                    throw new ExceptionEx('信息保存失败');
                }
                $this->PopMsg('保存成功');
                $this->redirect($this->get_url('movie','lunbo'));
            }

        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $this->render("lunboadd",array('movie'=>$movie));
    }
    

    public function actionAdd(){
        try{
            if(!empty($_GET['id']) && is_numeric($_GET['id'])){
                $movie = WxMovie::model()->findByPk($_GET['id']);
                $episode = WxEpisode::model()->findAll("mid={$_GET['id']}");
            }else{
                $movie = new WxMovie();
                $episode = new WxEpisode();
                $movie -> addTime = time();
            }

            if(!empty($_POST)){
                $post = $_POST;
                $sql = 'select `orders` from yd_wx_movie order by `orders` desc limit 1';
                $return = Yii::app()->db->createCommand($sql)->queryRow();
                $movie -> type = $post['type'];
                $movie -> cp = $post['cp'];
                $movie -> title = $post['title'];
                $movie -> classify = $post['classify'];
                $movie -> action = $post['action'];
                $movie -> param = $post['param'];
                $movie -> director = $post['director'];
                $movie -> actor = $post['actor'];
                $movie -> info = $post['info'];
                //$movie -> gid = $_REQUEST['gid'];
                //var_dump($movie);die;
                if($movie->isNewRecord){
                    $movie->orders = $return['orders']+1;
                }
                //print_r($_FILES['imgs']['tmp_name']);die();
                if(!empty($_FILES['imgs']['tmp_name'])){
                    $filename = 'imgs';
                    $path = $this->up($filename);
                    //$movie -> img = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                    $movie -> img = 'http://portalpic.itv.cmvideo.cn:8088/file/' . $path;
                    //Common::synchroPic($path);
                    Common::fspost($path);
//                    print_r('http://' . $_SERVER['HTTP_HOST'] . '/wx/' . $path);
                }
                if(!$movie->save()){
                    var_dump($movie->getErrors());
                    LogWriter::logModelSaveError($movie,__METHOD__,$movie->attributes);
                    throw new ExceptionEx('信息保存失败');
                }
                if(!isset($_POST['url']) && empty($_GET['id'])){
                    $mid = $movie->attributes['id'];
                    //$mid = 1;
                    //var_dump($_POST['url']);
                    for($i=0;$i<$_POST['num'];$i++){
                        $episode = new WxEpisode();
                        $episode->mid=$mid;
                        $episode->mname=$_POST['mname'][$i];
                        $episode->url = $_POST['url'][$i];
                        $episode->num = $_POST['num'];
                        if(!$episode->save()){
                            var_dump($episode->getErrors());
                            LogWriter::logModelSaveError($episode,__METHOD__,$episode->attributes);
                            throw new ExceptionEx('信息保存失败s');
                        }
                    }

                }else if(isset($_POST['url']) && !empty($_GET['id'])){
                    $mid = $_GET['id'];
                    Yii::app()->db->createCommand()->delete('{{wx_episode}}', "mid=$mid");
                    for($i=0;$i<$_POST['num'];$i++){
                        $episode = new WxEpisode();
                        $episode->mid=$mid;
                        $episode->mname=$_POST['mname'][$i];
                        $episode->url = $_POST['url'][$i];
                        $episode->num = $_POST['num'];
                        //$episode->action = $_POST['actions'][$i];
                        if(!$episode->save()){
                            var_dump($episode->getErrors());
                            LogWriter::logModelSaveError($episode,__METHOD__,$episode->attributes);
                            throw new ExceptionEx('信息保存失败');
                        }
                    }
                }
                /*if(!empty($path)){
                $url = './file/' . $path;
                //$url = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                $expand = pathinfo($path,PATHINFO_EXTENSION);
                $expand = strtolower($expand);
                switch($expand)
                {
                    case 'png':$image=imagecreatefrompng($url);break;
                    case 'jpg':$image=imagecreatefromjpeg($url);break;
                    case 'jpeg':$image=imagecreatefromjpeg($url);break;
                    case 'gif':$image=imagecreatefromgif($url);break;
                    case 'wbmp':$image=imagecreatefromwbmp($url);break;
                }
                //$image=imagecreatefromjpeg($url);
                //var_dump($image);die;
                imagejpeg($image,$url,10);
                Common::synchroPic($path);
                }*/
 
                $this->PopMsg('保存成功');
                $this->redirect($this->get_url('movie','index'));
            }

        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $this->render("add",array('movie'=>$movie,'episode'=>$episode));
    }

    public function actionApp(){
        $this->render('app');
    }

    public function actionLead(){
        $nid=$_REQUEST['nid'];
        $word=!empty($_REQUEST['word'])?$_REQUEST['word']:'';
        $cp=!empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        $type='视频类节目';
        $page = 5;
        $data = $this->getPageInfo($page);
        $list = WxMovManager::getList($data,$type,$cp,$word);
        //var_dump($list);die;
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$list['count'],$page,$data['currentPage']);
        var_dump($list['list']);die;
        $this->render('lead',array('nid'=>$nid,'page'=>$pagination,'total'=>$list['count'],'list'=>$list['list']));
    }

    public function actionRecommend(){
        $this->render('recommend');
    }


    public function actionDel(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = WxMovie::model()->deleteByPk($_POST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }
    public function actionLunbodel(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = WxLunbo::model()->deleteByPk($_POST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    public function actionList(){
        $list = WxVersion::model()->findAll("delFlag=0 order by id desc");
        $this->render('list',array('list'=>$list));
    }

    public function actionSee(){
        $id = $_REQUEST['id'];
        $detail = WxVersion::model()->findByPk($id);
        $this->render('see',array('detail'=>$detail));
    }

    public function actionAppadd(){
        //echo 1;die;
        $targetFolder ='App';
        if(!is_dir($targetFolder)){
            mkdir($targetFolder);
        }
        $tempFile = $_FILES['Filedata']['tmp_name'];

        //图片重命名
        $name = $_FILES['Filedata']['name'];
        //保存文件
        move_uploaded_file($tempFile, $targetFolder . '/' . $name);

        if (file_exists($targetFolder . '/' . $name)) {
            $res['url'] = 'http://'. $_SERVER['HTTP_HOST'].'/' . $targetFolder . '/' . $name;
            //import('@.ORG.Apkparser');//
            $appObj = new Apkparser();
            $appObj->open($targetFolder.'/'.$name);
            $res['apk'] = $appObj->getPackage();    // 应用包名
            $res['bate'] = $appObj->getVersionName();  // 版本名称
            $res['codes'] = $appObj->getVersionCode();  // 版本代码
            //var_dump($res);die;
            $res['code'] = 200;
        } else {
            $res['code'] = 404;
            $res['msg'] = '网速较慢，请刷新稍后在试';
        }
        die(json_encode($res));

    }

    public function actionUpload(){
        if(!empty($_POST)){
            //var_dump($_POST);die;
            $version = new WxVersion();
            $version ->app = $_POST['app'];
            $version ->path = $_POST['path'];
            $version ->version = $_POST['version'];
            $version ->pname = $_POST['pname'];
            $version ->verStr = $_POST['verStr'];
            $version ->per = $_POST['per'];
            $version ->size = $_POST['size'];
            $version ->cTime = time();
            if(!$version->save()){
                var_dump($version->getErrors());
                LogWriter::logModelSaveError($version,__METHOD__,$version->attributes);
                throw new ExceptionEx('信息保存失败');
            }
            $this->PopMsg('保存成功');
            $this->redirect($this->get_url('movie','list'));
        }else{
            $this->render('upload');
        }

    }

    public function actionDelApp(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $id =$_REQUEST['id'];
        $del = WxVersion::model()->deleteByPk($id);
        if($del){
            $res['code']=200;
            $res['msg']='删除成功';
        }else{
            $res['code']=404;
            $res['msg']='删除失败';
        }

        echo json_encode($res);
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

