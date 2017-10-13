<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>登陆</title>
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/style.css"?>">
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/common.css"?>">
		<script src="/js/jquery-1.9.1.min.js"></script>
		<script src="/js/layer/layer.js"></script>
	</head>
	<body id="body">
		<div class="main">
			<div class="login">
				<h3>移动后台管理</h3>
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'login-form',
						'enableClientValidation'=>true,
						'clientOptions'=>array(
						'validateOnSubmit'=>true,
						),
				)); ?>
					<div class="mt20 w">
						<span>用户名：</span>
						<span><?php echo $form->textField($model,'username',array('class'=>'form-input w300'))?></span>
					</div>
					<div class="mt20 w">
						<span>密　码：</span>
						<span><?php echo $form->passwordField($model,'password',array('class'=>'form-input w300'))?></span>
					</div>
					<div class="mt20 w">
						<span>验证码：</span>
						<span><?php echo $form->textField($model,'code',array('class'=>'form-input w100'))?></span>
						<span><img src="<?php echo Yii::app()->createUrl('/move/default/code') ?>" style="display:inline;" onclick="this.src='/move/default/code?tm='+Math.random()"></span>
					</div>
					<div class="mt20 w" style="text-align:right;"><input type="submit" id="submit" value="登　陆"></div>
				<?php $this->endWidget(); ?>
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
		</script>
	</body>
</html>