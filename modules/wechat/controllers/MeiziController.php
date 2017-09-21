<?php
class MeiziController extends WController
{
    public function actionIndex()
    {
        $gid= $_REQUEST['nid'];
        $list = MeiziManager::getList();
        $totalpage = MeiziManager::getTotalPage();
        $fieldCp = MeiziManager::getCpinfo();
        $fieldType = MeiziManager::getTypeinfo();
        $fieldLanguage = MeiziManager::getLanguageinfo();
//        var_dump($fieldLanguage);die;
        $this->render('index',array('gid'=>$gid,'list'=>$list,'total'=>$totalpage,'fieldCp'=>$fieldCp,'fieldType'=>$fieldType,'fieldLanguage'=>$fieldLanguage));
    }


    public function actionPage()
    {
        $p = $_REQUEST['p'];
        $pagesize = 10;
        $list = MeiziManager::getPageList($p,$pagesize);
        echo json_encode($list);
    }

    public function actionSeach()
    {
        $keyword = $_REQUEST['keyword'];
        $cp = $_REQUEST['cp'];
        $language = $_REQUEST['language'];
        $type = $_REQUEST['type'];
        $list = MeiziManager::getSeach($keyword,$cp,$language,$type);
        echo json_encode($list);
    }

    public function actionSeachPage()
    {
        $keyword = $_REQUEST['keyword'];
        $cp = $_REQUEST['cp'];
        $language = $_REQUEST['language'];
        $type = $_REQUEST['type'];
        $p = $_REQUEST['p'];
        $pagesize = 10;
        $list = MeiziManager::getSeachPage($keyword,$cp,$language,$type,$p,$pagesize);
        echo json_encode($list);
    }

    public function actionAdd()
    {
        $id = $_REQUEST['id'];
        $list  = array();
        for($i = 0 ; $i<count($id) ; $i++){
             $list[] =  MeiziManager::getAddinfo($id[$i]);
        }
        for($j = 0 ; $j<count($list) ; $j++){
            $res = MeiziManager::doInsert($list[$j]);
        }
        echo json_encode($res);
    }

   /* public function actionField()
    {
        $field = $_REQUEST['field'];
        $list = MeiziManager::getFieldinfo($field);
        echo json_encode($list);
    }*/
}

