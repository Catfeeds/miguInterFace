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
                $criteria -> addCondition('title = :title');
                $criteria -> params[':title'] = $_GET['title'];
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
        $classify='轮播';
        $tmp = WxSelect::model()->findAll("classify='$classify' and gid='$gid'");
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
                $movie = WxSelect::model()->findByPk($_GET['id']);
            }else{
                $movie = new WxSelect();
                $movie -> addTime = time();
            }


            if(!empty($_POST)){
                $post = $_POST;
                $sql = 'select `orders` from yd_wx_select where classify="轮播" order by `orders` desc limit 1';
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
                $movie -> gid = $_REQUEST['gid'];
                $movie -> mid = 0;
                if($movie->isNewRecord){
                    $movie->orders = $return['orders']+1;
                }
                //print_r($_FILES['imgs']['tmp_name']);die();

                if(!empty($_FILES['imgs']['tmp_name'])){
                    $filename = 'imgs';
                    $path = $this->up($filename);
                    //$movie -> img = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                    $movie -> img = 'http://portalpic.itv.cmvideo.cn:8088/file/'. $path;
                    Common::synchroPic($path);
//                    print_r('http://' . $_SERVER['HTTP_HOST'] . '/wx/' . $path);
                }
                if(!$movie->save()){
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
                    $movie -> img = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
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

