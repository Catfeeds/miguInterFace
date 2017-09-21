<div class="mt10">
	<table class="mtable" cellpadding="0" cellspacing="0" width="99%">
		<tr>
			<td align="right" valign="top" width="200">编号：</td>
			<td><?php echo $admin->id?></td>
		</tr>
		<tr>
			<td align="right" valign="top" width="200">昵称：</td>
			<td><?php echo $admin->nickname?></td>
		</tr>
		<tr>
			<td align="right">用户名：</td>
			<td><?php echo $admin->username?></td>
		</tr>
		<tr>
			<td align="right">邮箱：</td>
			<td><?php echo $admin->email?></td>
		</tr>
		<tr>
			<td align="right">权限组：</td>
			<td><?php
                if(!empty($group)){
                foreach($group as $g){
                    if($g->id == $admin->auth)echo $g->name;
                }}
                ?></td>
		</tr>
		<tr>
			<td align="right">注册时间：</td>
			<td><?php echo date('Y-m-d H:i:s',$admin->addTime)?></td>
		</tr>
		<tr>
			<td align="right">最近更新时间：</td>
			<td><?php echo date('Y-m-d H:i:s',$admin->upTime)?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="button" value="返回上一页" class="gray" onclick="window.location.href='<?php echo $this->get_url('admin','index',array('nid'=>$_GET['nid']))?>'"></td>
		</tr>
	</table>
</div>