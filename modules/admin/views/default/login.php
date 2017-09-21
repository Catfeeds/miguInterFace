<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>登陆</title>
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/style.css"?>">
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/common.css"?>">
		<script src="/js/jquery-1.9.1.min.js"></script>
		<script src="/js/layer/layer.js"></script>
                <script src="/js/md5.js"></script>
	</head>
	<body id="body">
		<div class="main">
			<div class="login">
				<h3>后台管理</h3>
					<div class="mt20 w">
						<span>用户名：</span>
                                                <span><input class="form-input w300" name="username" id="AdminForm_username" type="text"></span>
					</div>
					<div class="mt20 w">
						<span>密　码：</span>
                                                <span><input class="form-input w300" name="password" id="AdminForm_password" type="password"></span>
					</div>
                                        <div class="mt20 w">
						<span>验证码：</span>
                                                <span><input class="form-input w100" name="code" id="AdminForm_code" type="text"></span>
						<span><img src="<?php echo Yii::app()->createUrl('/admin/default/code') ?>" style="display:inline;" onclick="this.src='/admin/default/code?tm='+Math.random()"></span>
					</div>
					<div class="mt20 w" style="text-align:right;"><input type="submit" id="submit" value="登　陆"></div>
			</div>
			<div class="back"></div>
		</div>
		<script type="text/javascript">
			(function(){
				<?php
				if($flash = Yii::app()->user->getFlashes()){
					foreach($flash as $k=>$v){
						if ($k != 'counters') {
			               printf('layer.alert("%s", {title:"%s", icon:0});', $v['message'],$v['title']);
			            }
					}
				}
				?>
			})()
                        $('#submit').click(function(){
                var username=$('input[name=username]').val();
                var password=hex_md5($('input[name=password]').val());
                var code=$('input[name=code]').val();
                var AdminForm={username:username,password:password,code:code}
                var AdminForm={AdminForm:AdminForm};
                $.post('/admin/default/login.html?mid=-1',AdminForm,function(data){
                    location.reload();
                })
            })
		</script>
	</body>
</html>
