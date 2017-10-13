<?php
$nav = $this->wxgroup;
?>
<div class="admin_left">
	<div id="menubox">
		<ul id="J_navlist">
			<?php
			if(!empty($nav)){
				foreach($nav as $v){
					$mid = 0;
					if(!empty($_GET['mid'])) $mid = $_GET['mid'];
					if(!empty($mid) && $mid == $v->pid){
					?>
						<li class="<?php echo !empty($_GET['nid']) && $_GET['nid'] == $v['id']?'thismenu':''?>">
							<span><a href="<?php echo $v['url'] == '#'?'#':Yii::app()->createUrl($v['url'],array('mid'=>$_GET['mid'],'nid'=>$v['id']))?>" class="<?php echo !empty($_GET['nid']) && $_GET['nid'] == $v['id']?'hovered':''?>"><?php echo $v['name']?></a></span>
						</li>
				<?php
					}
				}
			}else{
			?>
				<li class="">
					<span><a href="#" style="color:;">待添加<em></em></a></span>
					<div class="submenu none" style="">
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
						<a href="#">待添加</a>
					</div>
                    <a href="<?php echo Yii::app()->createUrl('/wechat/test/index',array('mid'=>$_GET['mid'],'nid'=>1))?>" style="color:;">自动回复<em></em></a>
				</li>
			<?php
			}?>
		</ul>
		<script type="text/javascript" language="javascript">
			navList(12);
		</script>
	</div>
	<div class="left_ico left_active"><a href="#"></a></div>
</div>
<script type="text/javascript">
	window.onload = function(){
		$('li.thismenu div.submenu').show();
	};
	$('.left_ico').click(function(){
		$(this).toggleClass('left_active');
		$("#menubox").toggle();
	});
</script>