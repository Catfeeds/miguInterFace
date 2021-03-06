<?php

/**
 * Created by PhpStorm.
 * User:
 * Date: 2016/6/29
 * Time: 14:24
 */
class GroupController extends WController{
    public function actionIndex(){
        $page = 20;
        $data = $this->getPageInfo($page);
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $count = WxGroup::model()->count($criteria);
        $criteria->offset = $data['start'];
        $criteria->limit = $data['limit'];
        $list = WxGroup::model()->findAll($criteria);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);
        $this->render('index',array('list'=>$list,'page'=>$pagination));
    }

    public function actionAdd(){
        try{
            if(!empty($_GET['id']) && is_numeric($_GET['id'])){
                $group = WxGroup::model()->findByPk($_GET['id']);

            }else{
                $group = new WxGroup();
                //var_dump($group);die();
                $group->addTime = time();
            }

            if(!empty($_POST)){
                $post = $_POST;
                if(empty($post['name']))throw new ExceptionEx('权限组名称不能为空');
                if(empty($post['auth']))throw new ExceptionEx('请选择权限');
                $group->name = trim($post['name']);
                $group->auth = join(',',$post['auth']);//将数组合成一个字符串，别名implode()

                if(!$group->save()){
                    var_dump($group->getErrors());
                    LogWriter::logModelSaveError($group,__METHOD__,$group->attributes);
                    throw new ExceptionEx('权限组保存失败');
                }
//                if(!empty($_GET['id'])){
//                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$group,'权限组',$group->name);
//                }else {
//                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD, $group, '权限组', $group->name);
//                }
                $this->PopMsg('添加成功');
                $this->redirect($this->get_url('group','index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }
        $auth = WxGuideManager::getList();

        //$fulei = WxGuide::model()->findAll("pid=0 order by `order` desc");
        $fulei = WxGuide::model()->findAll("pid=0 order by `order` desc");

        $this->render('add',array('group'=>$group,'auth'=>$auth,'fulei'=>$fulei));
    }

    public function actionDel(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = WxGroup::model()->deleteByPk($_POST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        //$title = count($del) > 1 ? '' : $del[0]['name'];
        //$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'权限组',$title);
        $this->die_json(array('code'=>404,'msg'=>'删除成功'));
    }

}
