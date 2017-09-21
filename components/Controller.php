<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/main.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function beforeAction($action){
		return true;
	}

	public function PopMsg($message,$title='温馨提示',$info=0){
		$rand = rand(1,9999999);
		if(is_numeric($title)) $info = $title;
		Yii::app()->user->setFlash($rand,array('title'=>$title,'message'=>$message,'info'=>$info));
	}

	public function log($message){
		Yii::log('未知错误：'.$message,'error');
	}

	/**
	 * 分页组件
	 * @param $url
	 * @param $total
	 * @param $limit
	 * @param $currentPage
	 * @return string
	 */
	public function renderPagination($url, $total, $limit = 20, $currentPage = 1)
	{
		if (intval($total) <= 0) return '';
		$currentPage = empty($currentPage) ? 1 : $currentPage;
		$limit = intval($limit) <= 0 ? 20 : $limit;
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->limit = $limit;
		$pagination->page = $currentPage;
		$GET = $_GET;
		$GET['page'] = '{page}';
		$query = '&';
		foreach ($GET as $k => $v) {
			$query .= $k . '=' . $v . '&';
		}
		$bts = parse_url($url);
		$pagination->url = __ROOT__ . $bts['path'] . '?' . trim($query, '&');
		return $pagination->render();
	}

	/**
	 * 获取分页信息
	 * @param int $pageCount
	 * @return array
	 */
	public function getPageInfo($pageCount = 20)
	{
		$data = array();
		$data['limit'] = $pageCount;
		if (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 1) {
			$page = 1;
			$data['prePage'] = 1;
		} else {
			$page = intval($_REQUEST['page']);
			$data['prePage'] = $page - 1;
		}
		$data['start'] = ($page - 1) * $data['limit'];
		if($data['start'] <= 0) $data['start'] = 0;
		$data['currentPage'] = $page;
		$data['nextPage'] = $page + 1;
		return $data;
	}

	public function getPreUrl(){
		return Yii::app()->request->urlReferrer;
	}
        public function WeixinUser($code){
        echo $code;
    	$appid = "wx3f9bb59f5ba78010";
        $secret = "5f17728db47200477af5b2d9943211b0";
        
        include 'Help.php';
        //获取access_token和openid
            $https_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
            echo $https_url;
 $gettokenInfo  = file_get_contents($https_url);//如果不行换成 file_get_contents();
 //$gettokenInfo  =Help::curl($https_url);//如果不行换成 file_get_contents();
            var_dump($gettokenInfo);
            $wei_info = json_decode($gettokenInfo,true);//这边注意一下这个json格式，可能要两次转换
            var_dump($wei_info);
            $access_token = $wei_info['access_token'];//获取access_token
            $openid = $wei_info['openid'];//获取openid
            //获取用户信息
            $user_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}";
           //$user_info = file_get_contents($user_url);//如果不行换成 file_get_contents();
            $user_info = curl($user_url);//如果不行换成 file_get_contents();
            $user_info = json_decode($user_info,true);//这边注意一下这个json格式，可能要两次转换
        die;    
        return $user_info;
    }

	/**
	 * @param $edit
	 * @param $info
	 * @param $type
	 * @param string $title
	 * 操作日志记录
	 */
	public function RecordOperatingLog($edit,$info,$type='',$title=''){
		$model = $this->module->id;
		switch($model){
			case 'admin':
				$admin = Yii::app()->user->getState('admin');
				break;
			default:
				$admin = Yii::app()->user->getState('user');
				break;
		}
		$log = new OperatingLog();
		$log->edit = $edit;
		$log->aid = $admin['id'];
		$log->model = $this->module->id;
		$log->group = $admin['auth'];
		$log->referrer = $this->getPreUrl();
		$log->link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$log->oTime = time();
		$log->info = CJSON::encode($info);
		$log->ip = $_SERVER['REMOTE_ADDR'];
		if($edit == '添加'){
			$log->content = strtr(MSG::OP_LOG_ADD,array('{username}'=>$admin['nickname'],'{datetime}'=>date('Y-m-d H:i:s'),'{type}'=>$type,'{title}'=>$title));
		}elseif($edit == '删除'){
			$log->content = strtr(MSG::OP_LOG_DEL,array('{username}'=>$admin['nickname'],'{datetime}'=>date('Y-m-d H:i:s'),'{type}'=>$type,'{title}'=>$title));
		}elseif($edit == '编辑'){
			$log->content = strtr(MSG::OP_LOG_EDIT,array('{username}'=>$admin['nickname'],'{datetime}'=>date('Y-m-d H:i:s'),'{type}'=>$type,'{title}'=>$title));
		}elseif($edit == '登陆'){
			$log->content = strtr(MSG::OP_LOG_LOGIN,array('{username}'=>$admin['nickname'],'{datetime}'=>date('Y-m-d H:i:s')));
		}elseif($edit == '退出'){
			$log->content = strtr(MSG::OP_LOG_LOGOUT,array('{username}'=>$admin['nickname'],'{datetime}'=>date('Y-m-d H:i:s')));
		}else{
			$log->content = strtr(MSG::OP_LOG_UN,array('{username}'=>$admin['nickname'],'{datetime}'=>date('Y-m-d H:i:s')));
		}
		if(!$log->save()){
			LogWriter::logModelSaveError($log,__METHOD__,$log->attributes);
		}
	}
}
