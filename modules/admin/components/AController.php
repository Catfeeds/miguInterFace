<?php
/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/4 0004
 * Time: 16:08
 */
class AController extends Controller{

	public $layout = 'application.modules.admin.views.layouts.main';
	public $pageTitle = '移动后台管理系统';
	public $mid = -1;
	public $group;
	public function beforeAction($action){
		if(parent::beforeAction($action)){
			$arr = array('login','logout','code','captcha');
			if(in_array($this->action->id,$arr)) return true;
			$admin = Yii::app()->user->getState('admin');
                        if(!$admin){
				$this->redirect($this->createUrl('/admin/default/login',array('mid'=>$this->mid)));
			}
                        
                        
			$group = $this->getGroup($admin['auth']);
			$this->group = $this->getAuth($group->auth);
			if(!isset($_GET['mid']) || empty($_GET['mid'])){
				$this->redirect($this->createUrl('/admin/default/index',array('mid'=>$this->mid)));
			}
			$this->mid = (int) $_GET['mid'];
		}
		return true;
	}

	private function getGroup($id){
		return Group::model()->findByPk($id);
	}

	private function getAuth($str){
		$criteria = new CDbCriteria();
		$criteria->select = 'id,pid,name,url';
		$criteria->addInCondition('id',explode(',',$str));
		$criteria->order = '`order` asc';
		return Guide::model()->findAll($criteria);
	}

	private function check($str,$auth){
		if(!is_array($auth)) return false;
		$return = true;
		foreach($auth as $v){
			if(strtolower($str) === strtolower($v->addres)){
				return $return;
			}
		}
		return false;
	}

	public function getAdmin(){
		$admin = Yii::app()->user->getState('admin');
		if(empty($admin)){
			return false;
		}
		return $admin;
	}

	public function getAid(){
		$admin = $this->getAdmin();
		return $admin['id'];
	}



	public function die_json($arr = array()){
		if(empty($arr)) $arr = array();
		die(json_encode($arr));
	}

	public function get_url($controller,$action,$data=array()){
		$model = $this->module->id;
		if(empty($controller))  $controller = $this->id;
		if(empty($action))      $action = $this->action->id;
		if(!isset($data['mid']))$data['mid'] = $this->mid;
		if(!isset($data['nid']) && isset($_GET['nid'])) $data['nid'] = $_GET['nid'];
		return $this->createUrl('/' . $model . '/' . $controller . '/' . $action , $data);
	}
        
    public function array_column($input, $columnKey, $indexKey = NULL){
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();

        foreach ((array)$input AS $key => $row){
            if ($columnKeyIsNumber){
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            }else{
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if ( ! $indexKeyIsNull){
                if ($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                }else{
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key] = $tmp;
        }

        return $result;
    }

}
