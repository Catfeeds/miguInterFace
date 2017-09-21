<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/21 0021
 * Time: 17:09
 */
class SettingController extends MController
{

	/**
	 * 获取分类
	 */
	public function actionGetNav(){
		try{
			$criteria = new CDbCriteria();
			$criteria->select = '*';
			$ui = UiType::model()->findAll($criteria);
			$res = array();
			foreach($ui as $u){
				$tmp['title'] = $u->title;
				$tmp['altem'] = $u->altem;
				$tmp['id'] = $u->id;
				$res[] = $tmp;
			}
			$this->ReturnDate(MSG::SUCCESS,MSG::SUCCESS,$res);
		}catch (ExceptionEx $ex){
			$this->ReturnDate(MSG::ERROR,$ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
			$this->ReturnDate(MSG::ERROR,MSG::ERROR_INFO);
		}
	}

	/**
	 * 获取分类布局
	 */
	public function actionUi(){
		try{
			if(empty($_REQUEST['ui'])) throw new ExceptionEx('ui|不能为空');
			$ui = Ui::model()->findAllByAttributes(array('type'=>$_REQUEST['ui']));
			$res = array();
			if(!empty($ui)){
				foreach($ui as $u){
					$tmp['title'] = $u->title;
					$tmp['position'] = $u->position;
					$tmp['url'] = $u->url;
					$tmp['bigImg'] = $u->bigImg;
					$res[] = $tmp;
				}
			}
			$this->ReturnDate(MSG::SUCCESS,MSG::SUCCESS,$res);
		}catch (ExceptionEx $ex){
			$this->ReturnDate(MSG::ERROR,$ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
			$this->ReturnDate(MSG::ERROR,MSG::ERROR_INFO);
		}
	}
}