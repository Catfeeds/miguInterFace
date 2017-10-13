<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/18 0018
 * Time: 14:29
 */
class OperatingController extends AController
{
	const PAGE_SIZE = 20;
	public function actionIndex(){
		$data = $this->getPageInfo(self::PAGE_SIZE);
		if(!empty($_GET['nickname']))   $data['nickname'] = trim($_GET['nickname']);
		if(!empty($_GET['edit']))       $data['edit']     = trim($_GET['edit']);
		if(!empty($_GET['link']))       $data['link']     = trim($_GET['link']);
		if(!empty($_GET['group']))       $data['group']     = trim($_GET['group']);
		if(!empty($_GET['first']) && !empty($_GET['end'])){
			$data['first'] = strtotime($_GET['first']);
			$data['end'] = strtotime($_GET['end']);
		}
		$list = OperatingManager::getLogList($data);
		$url = $this->createUrl($this->action->id);
		$pagination = $this->renderPagination($url,$list['count'],self::PAGE_SIZE,$data['currentPage']);
		$group = GroupManager::getGroup(true);
		$this->render('index',array('list'=>$list['list'],'page'=>$pagination,'group'=>$group));
	}

	public function actionDetail(){
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect($this->getPreUrl());
		}
		if(empty($_GET['val']) && !is_numeric($_GET['val'])){
			$this->die_json(array('code'=>404,'msg'=>'参数错误,请重新提交'));
		}
		$operating = OperatingManager::getDetail($_GET['val']);
		if(empty($operating)){
			$this->die_json(array('code'=>404,'msg'=>'系统错误,请稍后再试'));
		}

		$this->die_json(array('code'=>200,'msg'=>HTML::operating($operating)));
	}
}