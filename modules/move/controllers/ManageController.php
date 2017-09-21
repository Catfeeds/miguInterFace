<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/12/10
 * Time: 11:07
 */
class ManageController extends AController{

    public function actionIndex(){
        $page = 20;
        $data = $this->getPageInfo($page);
        $manage = ManageManager::getManageList($data);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$manage['count'],$page,$data['currentPage']);
        $this->render('index',array('list'=>$manage['list'],'page'=>$pagination));
    }

    public function actionAdd(){

        try{

            if(!empty($_GET['bid']) && is_numeric($_GET['bid'])){
                $manage = Manage::model()->findByPk($_GET['bid']);
            }else{
                $manage = new Manage();
            }
            if(!empty($_POST)){

                if(empty($_POST['cp']))       throw new ExceptionEx('牌照方不能为空');
                //if(empty($_POST['province'])) throw new ExceptionEx('省份不能为空');
                //if(empty($_POST['city']))     throw new ExceptionEx('地市不能为空');
                if(empty($_POST['plate']))    throw new ExceptionEx('板块不能为空');
                if(empty($_POST['position'])) throw new ExceptionEx('位置不能为空');
                if(empty($_POST['content']))  throw new ExceptionEx('内容描述不能为空');
                if(empty($_POST['time']))     throw new ExceptionEx('有效期不能为空');
                if(empty($_POST['editor']))   throw new ExceptionEx('编辑人不能为空');

                $manage -> cp       = trim($_POST['cp']);
                $manage -> province = trim($_POST['province']);
                $manage -> city     = trim($_POST['city']);
                $manage -> plate    = trim($_POST['plate']);
                $manage -> position = trim($_POST['position']);
                $manage -> content  = trim($_POST['content']);
                $manage -> time     = strtotime($_POST['time']);
                $manage -> editor   = trim($_POST['editor']);

                if(!$manage->save()){
                    LogWriter::logModelSaveError($manage,__METHOD__,$manage->attributes);
                    throw new ExceptionEx('保存失败!');
                }

                if(!empty($_GET['bid'])){
                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$manage,'分省管理',$manage->cp);
                }else{
                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$manage,'分省管理',$manage->cp);
                }

                $this->redirect($this->get_url('manage','index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }
        $this->render('add',array('manage'=>$manage));
    }
}