<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?php echo CHtml::encode($this->pageTitle) ?></title>
		<?php $this->renderPartial('application.modules.wechat.views.layouts.header')?>
	</head>
	<body>
		<div>
			<?php $this->renderPartial('application.modules.wechat.views.layouts.top')?>
			<?php $this->renderPartial('application.modules.wechat.views.layouts.left')?>
			<div class="admin_right ">
				<div class="ad_current" style="height: 14px;"></div>
				<div class="admin_border" style="height:800px;overflow-y: scroll;">
					<?php echo $content;?>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="admin_foot">©2003-2014 pma.tools.sinaapp.com, All Rights Reserved. 本站发布的所有内容，未经许可，不得转载</div>
		<div id="pop-msg-from-bankend" style="display: none"></div>
		<?php $this->renderPartial('application.modules.wechat.views.layouts.script')?>
	</body>
</html>