<?php
/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2016/3/22
 * Time: 13:33
 */
class DefaulturlController extends WController{
    public function actionIndex(){

        $id=$_GET['nid'];
        if(!empty($id)){
            if($id==16){
                $cp = '1';
            }
            if($id==17){
                $cp = '2';
            }
            if($id==18){
                $cp = '3';
            }
            if($id==19){
                $cp = '4';
            }
            if($id==20){
                $cp = '5';
            }
            if($id==21){
                $cp = '6';
            }
            if($id==22){
                $cp = '7';
            }
            if($id==14){
                $cp = '8';
            }
        }

        //分页
        $page = 20;
        $data = $this->getPageInfo($page);
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        //$criteria->addCondition("msgtype = '$SearchMsgType' and cp = 2");
        $criteria->offset = $data['start'];
        $criteria->limit = $data['limit'];
        $criteria->addCondition("cp = '$cp'");
        $count = WxUrl::model()->count($criteria);
        $url = $this->createUrl($this->action->id);
        $arr = WxUrl::model()->findAll($criteria);
        $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);

        $this->render('index',array('arr'=>$arr,'page'=>$pagination));
        //$this->render("index");
    }

    public function actionAdd(){


        try{
            if(!empty($_GET['id'])){
                $wxurl = WxUrl::model()->findByPk($_GET['id']);
            }else{
                $wxurl = new WxUrl();
                $ids=$_GET['nid'];
                if(!empty($ids)){
                    if($ids==16){
                        $wxurl -> cp = '1';
                    }
                    if($ids==17){
                        $wxurl -> cp = '2';
                    }
                    if($ids==18){
                        $wxurl -> cp = '3';
                    }
                    if($ids==19){
                        $wxurl -> cp = '4';
                    }
                    if($ids==20){
                        $wxurl -> cp = '5';
                    }
                    if($ids==21){
                        $wxurl -> cp = '6';
                    }
                    if($ids==22){
                        $wxurl -> cp = '7';
                    }
                    if($ids==14){
                        $wxurl -> cp = '8';
                    }
                }
                //$wxurl -> cp     = $cp;
            }
            if(!empty($_POST)) {

                $menu = isset($_POST['menu']) ? trim($_POST['menu']) : '';

                $url  = isset($_POST['url']) ? trim($_POST['url']) : '';
                $urls = isset($_POST['urls']) ? trim($_POST['urls']) : '';

                $upde = isset($_POST['upde']) ? trim($_POST['upde']) : '';
                if($upde==2){
                    $filename = 'urls';

                    if (!empty($filename)) {
                        if ($_FILES[$filename]["error"] > 0) {
                            $this->error('上传文件错误! 错误代码:' . $_FILES[$filename]['error'], '', 3);
                        }
                        $dir = Yii::app()->basePath . '/../wxfile/wxhtml/';
                        //echo $dir;die();
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
                    $wxurl -> url    = 'http://' . $_SERVER['HTTP_HOST'] . '/wxfile/wxhtml/' . $path;
                }else{
                    $wxurl -> url    = $url;
                }
                $wxurl -> menu   = $menu;
                //$wxurl -> cp     = $cp;

//                if(isset($url)){
//                    $wxurl -> url    = $url;
//                }

                if (!$wxurl->save()) {
                    LogWriter::logModelSaveError($wxurl,__METHOD__,$wxurl->attributes);
                    throw new ExceptionEx('保存失败!');
                }
                $this->redirect($this->get_url('defaulturl', 'index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $menuname = array_map(create_function('$record','return $record->attributes;'),WxMenu::model()->findAll(array('select'=>array('title'))));
      //  print_r($menuname);die();

        $this->render("add",array('wxurl'=>$wxurl,'menuname'=>$menuname));
    }
    public function actionDel(){
        if(empty($_POST['id']) || !is_numeric($_POST['id'])){
            $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        }
        $wxurl = WxUrl::model()->deleteByPk($_POST['id']);
        if(!$wxurl){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }
    public function error(){
        echo "error";
    }
}