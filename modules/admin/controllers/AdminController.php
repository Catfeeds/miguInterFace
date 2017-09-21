<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/10 0010
 * Time: 13:09
 */
class AdminController extends AController{

	public function actionIndex(){
		$page = 20;
		$data = $this->getPageInfo($page);
		if(!empty($_GET['nick']))   $data['nick'] = trim($_GET['nick']);
		if(!empty($_GET['name']))   $data['name'] = trim($_GET['name']);
		if(!empty($_GET['email']))  $data['email']= trim($_GET['email']);
		$admin = AdminManager::getAdminList($data);
		$url = $this->createUrl($this->action->id);
		$pagination = $this->renderPagination($url,$admin['count'],$page,$data['currentPage']);
		$this->render('index',array('list'=>$admin['list'],'page'=>$pagination));
	}

	public function actionAdd(){
		try{
			if(empty($_GET['id'])){
				$admin = new Admin();
				$admin->addTime = time();
			}else{
				$admin = Admin::model()->findByPk($_GET['id']);
				$admin->upTime = time();
			}

			if(!empty($_POST)){
				$post = $_POST;
				if(empty($post['nick']))    throw new ExceptionEx('用户昵称不能为空');
				if(empty($post['user']))    throw new ExceptionEx('用户名称不能为空');
				if($admin->isNewRecord){
					if(empty($post['pass'])) throw new ExceptionEx('用户密码不能为空');
					if(empty($post['rePass'])) throw new ExceptionEx('用户重复密码不能为空');
					if( strcmp($post['pass'],$post['rePass']) <> 0){
						throw new ExceptionEx('重复密码不一致');
					}
					$admin->password    = md5(trim($post['pass']));
				}
				if(empty($post['email']))   throw new ExceptionEx('用户邮箱不能为空');
				if(empty($post['auth']))    throw new ExceptionEx('用户权限组不能为空');
				if($admin->isNewRecord && Admin::model()->exists('username=:user',array(':user'=>$post['user']))){
					throw new ExceptionEx('登陆账号已存在');
				}
				if($admin->isNewRecord && Admin::model()->exists('email=:email',array(':email'=>$post['email']))){
					throw new ExceptionEx('邮箱已存在');
				}
				$admin->nickname    = trim($post['nick']);
				$admin->username    = trim($post['user']);
                if(!empty($post['pass'])){
                    if(empty($post['pass'])) throw new ExceptionEx('用户密码不能为空');
                    if(empty($post['rePass'])) throw new ExceptionEx('用户重复密码不能为空');
                    if( strcmp($post['pass'],$post['rePass']) <> 0){
                        throw new ExceptionEx('重复密码不一致');
                    }
                    $admin->password    = md5(trim($post['pass']));
                }
				$admin->auth        = intval($post['auth']);
				$admin->email       = trim($post['email']);
				if(!$admin->save()){
					LogWriter::logModelSaveError($admin,__METHOD__,$admin->attributes);
					throw new ExceptionEx('信息保存失败');
				}
				if(!empty($_GET['id'])){
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$admin,'管理员',$admin->nickname);
				}else{
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$admin,'管理员',$admin->nickname);
				}
				$this->PopMsg('用户信息保存成功');
				$this->redirect($this->get_url('admin','index'));
			}
		}catch (ExceptionEx $ex){
			$this->PopMsg($ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
		}
		$group = Group::model()->findAll();
		$this->render('add',array('admin'=>$admin,'group'=>$group));
	}

	public function actionDetail(){
		if(empty($_GET['id'])){
			$this->redirect($this->getPreUrl());
		}
        $group = Group::model()->findAll();
		$admin = Admin::model()->findByPk($_GET['id']);
		$this->render('detail',array('admin'=>$admin,'group'=>$group));
	}

	public function actionDell(){
		if(empty($_POST['id']) || !is_numeric($_POST['id'])){
			$this->die_json(array('code'=>404,'msg'=>'参数错误! 请联系站管'));
		}
		$del = Admin::model()->findByPk($_POST['id']);
		if(empty($del)){
			$this->die_json(array('code'=>404,'msg'=>'用户不存在'));
		}
		$del->status = MSG::ADMIN_STATUS_DEL;
		if(!$del->save()){
			LogWriter::logModelSaveError($del,__METHOD__,$del->attributes);
			$this->die_json(array('code'=>404,'msg'=>'删除失败'));
		}
		$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'管理员',$del->nickname);
		$this->die_json(array('code'=>200,'msg'=>'删除成功'));
	}

    public function actionDel(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = Admin::model()->deleteByPk($_POST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $title = count($del) > 1 ? '' : $del[0]['name'];
        $this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'用户组',$title);
        $this->die_json(array('code'=>404,'msg'=>'删除成功'));
    }
}