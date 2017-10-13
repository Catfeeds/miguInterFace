<div class="btn-parent">
	<a href="<?php echo Yii::app()->createUrl('/move/admin/add',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn">添加用户</a>
</div>
<div class="mt10">
	<form action="" method="get">
		<input type="hidden" name="mid" value="<?php echo $this->mid?>">
		<table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>编号</th>
					<th>登录名</th>
					<th>昵称</th>
					<th>权限组</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($list)){
				foreach($list as $l){?>
					<tr id="<?php echo $l['id'];?>">
						<td><?php echo $l['id']?></td>
						<td><?php echo $l['username']?></td>
						<td><?php echo $l['nickname']?></td>
						<td><?php echo $l['name']?></td>
						<td>
							<a href="<?php echo $this->get_url('admin','detail',array('id'=>$l['id'],'nid'=>$_GET['nid']))?>">查看</a>
							<a href="<?php echo $this->get_url('admin','add',array('id'=>$l['id'],'nid'=>$_GET['nid']))?>">编辑</a>
							<a href="javascript:void(0)" aid="<?php echo $l['id']?>"  class="del">删除</a>
						</td>
					</tr>
				<?php
				}
			}else{?>
				<tr>
					<td colspan="6" align="center">未查询到管理员</td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</form>
</div>
<div><?php echo $page;?></div>
<script type="text/javascript" charset="utf-8">

	$('.del').click(function(){
		var k = $(this);
		var v = $(k).attr('aid');
		if(empty(v)) return false;
		$.post('<?php echo $this->get_url('admin','del')?>',{id:v},function(d){
			if(d.code == 200){
                $(k).remove();
				layer.alert(d.msg,{icon:1});
			}else{
				layer.alert(d.msg,{icon:0});
			}
		},'json');
        $("#"+v).remove();
	})
</script>