<form action="" method="post">
	<table class="mtable" cellpadding="10" cellspacing="0" width="100%">
		<tr>
			<td align="right">登录名：</td>
			<td><input type="text" name="user" id="user" class="form-input w400" value="<?php echo !empty($admin->username)?$admin->username:''?>"> 请输入6-18位字母或者数字组合</td>
		</tr>
		<tr>
			<td align="right">昵称：</td>
			<td><input type="text" name="nick" id="nick" class="form-input w400" value="<?php echo !empty($admin->nickname)?$admin->nickname:''?>"> 请输入姓名或者工号</td>
		</tr>
        <?php if(empty($_GET['id'])){?><!--如果有接收的id则不显示-->
            <tr>
                <td align="right">密码：</td>
                <td><input type="password" name="pass" id="pass" value="" class="form-input w400"> 请输入6-18位字母或者数字组合</td>
            </tr>
            <tr>
                <td align="right">重复密码：</td>
                <td><input type="password" name="rePass" id="rePass" value="" class="form-input w400"> 请输入6-18位字母或者数字组合</td>
            </tr>
		<?php }else{?>
            <tr>
                <td align="right">是否修改密码：</td>
                <td>
                    <input type="radio" value="1" name="upde" onclick="xianshi()" id="yes">是
                    <input type="radio" value="2" name="upde" onclick="hidd()" id="no">否
                </td>
            </tr>
            <tr style="display: none" id="xian">
                <td align="right">密码：</td>
                <td><input type="password" name="pass" id="pass" value="" class="form-input w400"> 请输入6-18位字母或者数字组合</td>
            </tr>
            <tr style="display: none" id="shi">
                <td align="right">重复密码：</td>
                <td><input type="password" name="rePass" id="rePass" value="" class="form-input w400"> 请输入6-18位字母或者数字组合</td>
            </tr>
        <?php } ?>
        <script>
           // var val=$('input:radio[name="upde"]:checked').val();
            function xianshi(){
                $("#xian").show();
                $("#shi").show();
            }
            function hidd(){
                $("#xian").hide();
                $("#shi").hide();
            }
        </script>
		<tr>
			<td align="right">电子邮件：</td>
			<td><input type="text" name="email" id="email" class="form-input w400" value="<?php echo !empty($admin->email)?$admin->email:''?>"> 请输入6-18位电子邮件 格式如：expload@yidong.com</td>
		</tr>
		<tr>
			<td align="right">权限组：</td>
			<td>
				<select name="auth" id="auth" class="form-input w400">
					<option value="a">请选择</option>
					<?php
					if(!empty($group)){
						foreach($group as $g){?>
							<option value="<?php echo $g->id ?>" <?php if($g->id == $admin->auth){ echo "selected=selected";}?>><?php echo $g->name?></option>
					<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="添加/保存用户" class="btn">
				<input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('admin','index',array('nid'=>$_GET['nid']));?>'">
			</td>
		</tr>
	</table>
</form>
<script charset="utf-8" type="text/javascript">
	$('input[type=submit]').click(function(){
		var name = $('#user').val();
		if(name.match(/^\w{6,20}$/) == null){
			layer.alert('登录名不能为空或者格式错误',{icon:0});
			return false;
		}

		var nick = $('#nick').val();
		if(nick.match(/^.{1,30}$/) == null){
			layer.alert('昵称不能为空或者格式错误');
			return false;
		}
		<?php if(empty($_GET['id'])){?>
		var pass = $('#pass').val();
		if(pass.match(/^[a-zA-Z0-9]{6,18}$/) == null){
			layer.alert('密码不能为空或者格式错误',{icon:0});
			return false;
		}

		var rePass = $('#rePass').val();
		if(rePass.match(/^[a-zA-Z0-9]{6,18}$/) == null){
			layer.alert('重复密码不能为空或者格式错误',{icon:0});
			return false;
		}

		if(pass !== rePass){
			layer.alert('重复密码不一致',{icon:0});
			return false;
		}
		<?php }?>

		var email = $('#email').val();
		if(email.match(/^[a-zA-Z0-9]+@[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+/) == null){
			layer.alert('邮箱不能为空或者格式错误',{icon:0});
			return false;
		}
		var auth = $('#auth').val();
		if(empty(auth)){
			layer.alert('请选择权限组',{icon:0});
			return false;
		}
		$(this).submit();
	})
</script>
