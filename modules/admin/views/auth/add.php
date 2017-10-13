<form action="" method="post">
	<table class="mtable" width="100%" cellpadding="10" cellspacing="0">
		<tr>
			<td align="right">权限名称：</td>
			<td><input type="text" name="title" id="title" value="<?php echo !empty($auth->title)?$auth->title:''?>" class="form-input w400"></td>
		</tr>
		<tr>
			<td align="right">模块：</td>
			<td><input type="text" name="model" id="model" value="<?php echo !empty($auth->model)?$auth->model:''?>" class="form-input w400"></td>
		</tr>
		<tr>
			<td align="right">类：</td>
			<td><input type="text" name="class" id="class" value="<?php echo !empty($auth->class)?$auth->class:''?>" class="form-input w400"></td>
		</tr>
		<tr>
			<td align="right">方法：</td>
			<td><input type="text" name="action" id="action" value="<?php echo !empty($auth->action)?$auth->action:''?>" class="form-input w400"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="保存权限" class="btn">
				<input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('auth','index',array('nid'=>$_GET['nid']))?>'">
			</td>
		</tr>
	</table>
</form>