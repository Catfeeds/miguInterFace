<?php
$admin = $this->getAdmin();
$gu = $this->group;
?>
<div class="admin_top">
	<div class="wr">
		<div class="top_logo left">
			<a href="#" class="admin_logo" title="趣萌后台logo"></a>
			<p class="logo-line"></p>
			<h2>后台管理系统</h2>
		</div>
		<div class="top_nav">
			<div class="t_toolbar">
				<?php echo $admin['nickname']?>，您好! |
				<a href="<?php echo Yii::app()->createUrl('/admin/default/logout')?>">[退出]</a>
			</div>
			<ul>
				<?php 
				if(!empty($gu)){
					foreach($gu as $n){
						if($n->pid == 0){
						?>
						<li class="<?php echo !empty($_GET['mid']) && $_GET['mid'] == $n['id']?'active':''?>">
							<a href="<?php echo Yii::app()->createUrl($n['url'], array('mid' => $n['id'])); ?>" class="<?php echo $this->mid == $n['id']?'a_menu':''?>"><?php echo $n['name']?></a>
						</li>
				<?php   }
					}
				}?>
			</ul>
		</div>
	</div>
</div>
