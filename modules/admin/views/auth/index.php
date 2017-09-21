<style type="text/css">
	/*.reset{display:none;}*/
	.minit{border:1px solid #ccc;height:26px;}
	.button{padding:5px;height:28px;cursor:pointer;}
	.text{width:200px;}
	.title{cursor: pointer;}
	.title:hover{text-decoration: underline;color:#f00;}
	.reset{display:none;}
</style>
<div class="btn-parent">
	<a href="<?php echo $this->get_url('auth','update',array('nid'=>$_GET['nid']))?>" class="btn">更新权限</a>
	<a href="<?php echo $this->get_url('auth','add',array('nid'=>$_GET['nid']))?>" class="btn">添加权限</a>
</div>
<div class="mt10">
	<table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="5%">编号</th>
				<th width="30%">权限名称</th>
				<th width="10%">板块</th>
				<th width="10%">模块</th>
				<th width="10%">方法</th>
				<th width="25%">地址</th>
				<th width="10%">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(!empty($list)){
				foreach($list as $v){?>
					<tr>
						<td><?php echo $v->id?></td>
						<td>
							<div class="title"><?php echo $v->title?></div>
							<div class="reset">
								<input type="text" class="minit text" id="name">
								<input type="hidden" name="aid" value="<?php echo $v->id?>">
								<input type="button" class="minit button save" value="保存">
								<input type="button" class="minit button close" value="取消">
							</div>
						</td>
						<td><?php echo $v->model?></td>
						<td><?php echo $v->class?></td>
						<td><?php echo $v->action?></td>
						<td><a href="<?php echo $this->get_url($v->class,$v->action)?>"><?php echo $v->addres?></a></td>
						<td>
							<a href="<?php echo Yii::app()->createUrl('/admin/auth/add',array('mid'=>$this->mid,'id'=>$v->id,'nid'=>$_GET['nid']))?>">编辑</a>
							<a href="<?php echo Yii::app()->createUrl('/admin/auth/del',array('mid'=>$this->mid,'id'=>$v->id))?>">删除</a>
						</td>
					</tr>
			<?php
				}
			}else{
			?>
				<tr>
					<td colspan="4" align="center">未有权限生成</td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<div><?php echo $page?></div>
<script type="text/javascript">
	$('.title').dblclick(function(){
		var k = $(this);
		$(k).hide();
		$(k).next('.reset').show().find('#name').val($(k).html());
	});
	$('.close').click(function(){
		var k =$(this);
		$(k).parent().hide();
		$(k).parent().prev().show();
	});
	$('.save').click(function(){
		var k = $(this);
		var v = $(k).parent().find('#name').val();
		var id = $(k).parent().find('input[name=aid]').val();
		if(empty(v) || empty(id)) return false;
		$.post('/admin/auth/reset?mid=<?php echo $this->mid?>',{name: v,id:id},function(d){
			if(d.code == 200){
				$(k).parent().hide();
				$(k).parent().prev().html(v).show();
			}else{
				layer.alert(d.msg,{icon:0})
			}
		},'json')
	})
</script>