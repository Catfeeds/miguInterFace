<div class="btn-parent">
	<a href="<?php echo $this->get_url('group', 'add',array('nid'=>$_GET['nid'])) ?>" class="btn">添加用户组</a>
</div>
<div class="mt10">
	<table width="100%" cellspacing="0" cellpadding="10" class="mtable center">
		<tr>
			<th>编号</th>
			<th>组名称</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
		<?php
		if(!empty($list)){
			foreach($list as $l){?>
				<tr id="<?php echo $l->id;?>">
					<td><?php echo $l->id?></td>
					<td><?php echo $l->name?></td>
					<td><?php echo date('Y-m-d H:i',$l->addTime)?></td>
					<td>
						<a href="<?php echo $this->get_url('group','add',array('id'=>$l->id,'nid'=>$_GET['nid']))?>">编辑</a>
						<a href="javascript:void(0)" gid="<?php echo $l->id?>" class="del">删除</a>
					</td>
				</tr>
		<?php
			}
		}
		?>
	</table>
</div>
<div><?php echo $page;?></div>
<script type="text/javascript" charset="utf-8">
	$('.del').click(function(){
		var k = $(this);
		var v = $(k).attr('gid');
		if(empty(v)) return false;
		$.post('/admin/group/del?mid=<?php echo $_GET['mid']?>',{id:v},function(d){
			if(d.code == 200){
				$(k).parent().parent().remove();

				layer.alert(d.msg,{icon:1});

			}else{
				layer.alert(d.msg,{icon:0});
			}
		},'json');
        $("#"+v).remove();

	})
</script>
