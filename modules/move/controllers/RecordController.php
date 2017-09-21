<?php
class RecordController extends MController
{
	public function actionIndex()
	{
		$list = MvUserrecordManager::getList();
		$totalPage = MvUserrecordManager::getTotalPage();
		$this->render('index',array('list'=>$list,'totalPage'=>$totalPage));
	}

	public function actionPage()
    {
        $p = $_REQUEST['p'];
        $pagesize = 10;
        $list = MvUserrecordManager::getPageList($p,$pagesize);
        echo json_encode($list);
    }

}
