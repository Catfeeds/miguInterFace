<form action="" method="post">
	<table width="100%" cellspacing="0" cellpadding="10" class="mtable">
		<tr>
			<td width="100" align="right">标题：</td>
			<td><input type="text" name="title" id="title" class="form-input w400" value="<?php echo !empty($bull->title)?$bull->title:''?>"></td>
		</tr>
		<tr>
			<td align="right" valign="top">公告内容：</td>
			<td><textarea name="info" id="info" class="form-input w400" style="height:200px;resize: none;"><?php echo !empty($bull->info)?$bull->info:''?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="发布公告" class="btn">
				<input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo Yii::app()->createUrl('/admin/bulletin/index',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>'">
			</td>
		</tr>
	</table>
</form>