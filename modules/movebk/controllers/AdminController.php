<?php

/**
 * Created by PhpStorm.
 * User:
 * Date:
 * Time:
 */
class AdminController extends MController{

	public function actionIndex(){
		$page = 20;//每页有多少条数据
		$data = $this->getPageInfo($page);
		if(!empty($_GET['nick']))   $data['nick'] = trim($_GET['nick']);
		if(!empty($_GET['name']))   $data['name'] = trim($_GET['name']);
		//if(!empty($_GET['email']))  $data['email']= trim($_GET['email']);
		$admin = MvAdminManager::getAdminList($data);
		$url = $this->createUrl($this->action->id);//获取当前路径   $this->action->id获取当前action名
		$pagination = $this->renderPagination($url,$admin['count'],$page,$data['currentPage']);
		$this->render('index',array('list'=>$admin['list'],'page'=>$pagination));
	}

	public function actionAdd(){
		try{
			if(empty($_GET['id'])){//如果能够接收到id  则实行添加功能
				$admin = new MvAdmin();//实例化admin
				$admin->addTime = time();//因为是添加，所以这里网数据库添加字段的信息是添加信息时间
			}else{
				$admin = MvAdmin::model()->findByPk($_GET['id']);//根据接收到的id 查询出要修改的那条数据
				$admin->upTime = time();//修改upTime字段  也就是修改时间
			}

			if(!empty($_POST)){//如果接收的表单数据不为空
				$post = $_POST;
				if(empty($post['nick']))    throw new ExceptionEx('用户昵称不能为空');
				if(empty($post['user']))    throw new ExceptionEx('用户名称不能为空');
				if($admin->isNewRecord){//判断是不是个新记录  在add页面显示并判断   在update页面不显示且不判断
					if(empty($post['pass'])) throw new ExceptionEx('用户密码不能为空');
					if(empty($post['rePass'])) throw new ExceptionEx('用户重复密码不能为空');
					if( strcmp($post['pass'],$post['rePass']) <> 0){//strcmp(const char *s1,const char * s2)比较字符串s1和s2
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
                    //判断是否是新记录  并且  填写的数据库中是否已存在
					throw new ExceptionEx('邮箱已存在');
				}
				$admin->nickname    = trim($post['nick']);
				$admin->username    = trim($post['user']);
                if(!empty($post['pass'])){
                    if(empty($post['pass'])) throw new ExceptionEx('用户密码不能为空');
                    if(empty($post['rePass'])) throw new ExceptionEx('用户重复密码不能为空');
                    if( strcmp($post['pass'],$post['rePass']) <> 0){//strcmp(const char *s1,const char * s2)比较字符串s1和s2
                        throw new ExceptionEx('重复密码不一致');
                    }
                    $admin->password    = md5(trim($post['pass']));
                }
                //$admin->password    = md5(trim($post['pass']));
				$admin->auth        = intval($post['auth']);
				$admin->email       = trim($post['email']);
				//$admin->status        = MSG::ADMIN_STATUS_AUDITING;
				if(!$admin->save()){
					LogWriter::logModelSaveError($admin,__METHOD__,$admin->attributes);
					throw new ExceptionEx('信息保存失败');
				}
//				if(!empty($_GET['id'])){
//					$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$admin,'管理员',$admin->nickname);
//				}else{
//					$this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$admin,'管理员',$admin->nickname);
//				}
				$this->PopMsg('用户信息保存成功');
				$this->redirect($this->get_url('admin','index'));
			}
		}catch (ExceptionEx $ex){
			$this->PopMsg($ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
		}
		$group = MvGroup::model()->findAll();
		$this->render('add',array('admin'=>$admin,'group'=>$group));
	}

	public function actionDetail(){
		if(empty($_GET['id'])){
			$this->redirect($this->getPreUrl());
		}
        $group = MvGroup::model()->findAll();
		$admin = MvAdmin::model()->findByPk($_GET['id']);
		$this->render('detail',array('admin'=>$admin,'group'=>$group));
	}

	public function actionDell(){
		if(empty($_POST['id']) || !is_numeric($_POST['id'])){
			$this->die_json(array('code'=>404,'msg'=>'参数错误! 请联系站管'));
		}
		$del = MvAdmin::model()->findByPk($_POST['id']);
		if(empty($del)){
			$this->die_json(array('code'=>404,'msg'=>'用户不存在'));
		}
		$del->status = MSG::ADMIN_STATUS_DEL;
		if(!$del->save()){
			LogWriter::logModelSaveError($del,__METHOD__,$del->attributes);
			$this->die_json(array('code'=>404,'msg'=>'删除失败'));
		}
		//$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'管理员',$del->nickname);
		$this->die_json(array('code'=>200,'msg'=>'删除成功'));
	}

    public function actionDel(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = MvAdmin::model()->deleteByPk($_POST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $title = count($del) > 1 ? '' : $del[0]['name'];
        //$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'用户组',$title);
        $this->die_json(array('code'=>404,'msg'=>'删除成功'));
    }
}