<form action="" method="post">
	<table class="mtable" width="50%" cellpadding="10" cellspacing="0">
		<tr>
			<td align="right">导航分级：</td>
			<td>
				<select name="pid" id="pid" class="form-input">
					<option value="0">顶级导航</option>
					<?php
					if(!empty($parent)){
						foreach($parent as $p){?>
							<option value="<?php echo $p['id'] ?>" <?php echo !empty($guide->pid) && $guide->pid == $p['id']?'selected="selected"':''?>><?php echo $p['name']?></option>
					<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">导航名称：</td>
			<td><input type="text" name="name" id="name" class="form-input" value="<?php echo !empty($guide->name)?$guide->name:''?>"></td>
		</tr>
		<tr>
			<td align="right">需要跳转：</td>
			<td>
				<label for="out"><input type="radio" name="uType" id="out" value="1" <?php echo !empty($guide->uType) && $guide->uType == 1?'checked="checked"':''?>> 是</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="in"><input type="radio" name="uType" id="in" value="2" <?php echo !empty($guide->uType) && $guide->uType == 2?'checked="checked"':''?>> 否</label>
			</td>
		</tr>
		<tr>
			<td align="right">链接：</td>
			<td><input type="text" name="url" id="url" class="form-input" value="<?php echo !empty($guide->url)?$guide->url:''?>"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="保存信息" class="btn">
				<input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('guide','index')?>'">
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$('#pid').change(function(){
		var v = $(this).val();
		if(empty(v)){
			$('#url').val("javascript:void(0)").attr('readonly',true);
		}else{
			$('#url').val("").attr('readonly',false);
		}
	});
</script>