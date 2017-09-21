<script charset="utf-8" type="text/javascript" src="/js/jdate/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="/js/jdate/jquery.datetimepicker.css" />
<div>
	<form action="" method="get">
		<input type="hidden" name="mid" value="<?php echo $_GET['mid']?>">
		<input type="hidden" name="nid" value="<?php echo $_GET['nid']?>">
		<table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
			<tr>
				<th width="10%">编号</th>
				<th width="10%">用户</th>
				<th width="10%">用户组</th>
				<th width="10%">操作</th>
				<th width="40%">标题</th>
				<th width="20%">操作时间</th>
				<th width="10%">操作</th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="text" name="nickname" value="<?php echo !empty($_GET['nickname'])?$_GET['nickname']:''?>" id="nickname" class="form-input"></td>
				<td>
					<select name="group" id="group" class="form-input">
						<option value="0">请选择</option>
						<?php
						if(!empty($group)){
							foreach($group as $g){?>
								<option value="<?php echo $g['id'] ?>" <?php echo !empty($_GET['group']) && $_GET['group'] == $g['id']?'selected="selected"':''?>><?php echo $g['name']?></option>
						<?php }
						}?>
					</select>
				</td>
				<td>
					<select name="edit" id="edit" class="form-input">
						<option value="0">请选择</option>
						<option value="添加" <?php echo !empty($_GET['edit']) && $_GET['edit'] == '添加'?'selected="selected"':''?>>添加</option>
						<option value="编辑" <?php echo !empty($_GET['edit']) && $_GET['edit'] == '编辑'?'selected="selected"':''?>>编辑</option>
						<option value="删除" <?php echo !empty($_GET['edit']) && $_GET['edit'] == '删除'?'selected="selected"':''?>>删除</option>
					</select>
				</td>
				<td><input type="text" name="link" id="link" class="form-input" value="<?php echo !empty($_GET['link'])?$_GET['link']:''?>"></td>
				<td>
					<input type="text" name="first" id="first" class="form-input w100" value="<?php echo !empty($_GET['first'])?$_GET['first']:''?>">
					--
					<input type="text" name="end" id="end" class="form-input w100" value="<?php echo !empty($_GET['end'])?$_GET['end']:''?>">
				</td>
				<td><input type="submit" value="查询" class="seo-gray"></td>
			</tr>
			<?php
			if(!empty($list)){
				foreach($list as $a){?>
					<tr>
						<td><?php echo $a['id']?></td>
						<td><?php echo $a['nickname']?></td>
						<td><?php echo $a['name']?></td>
						<td><?php echo $a['edit']?></td>
						<td><?php echo $a['content']?></td>
						<td><?php echo date('Y-m-d H:i:s',$a['oTime'])?></td>
						<td><a href="javascript:void(0)" class="detail" oid="<?php echo $a['id']?>">查看</a></td>
					</tr>
					<?php
				}
			}else{?>
				<tr>
					<td colspan="7" align="center">没有人干了什么</td>
				</tr>
				<?php
			}
			?>
		</table>
	</form>
</div>
<div><?php echo $page;?></div>
<script type="text/javascript">
	$('#first,#end').datetimepicker({
		lang:'ch',
		validateOnBlur:false,
		timepicker:false,
		format:'Y-m-d',
		formatDate: 'Y-m-d',
		maxDate:'<?php echo date('Y-m-d',strtotime('+1 day'))?>'
	});
	$('.detail').click(function(){
		var k = $(this);
		var v = $(k).attr('oid');
		if(empty(v)) return false;
		var index = layer.load(1,{
			shade : [0.3,'#000']
		});
		$.getJSON('/admin/operating/detail?mid=<?php echo $this->mid?>',{val:v},function(d){
			if(d.code == 200){
				layer.close(index);
				layer.open({
					type: 1,
					skin: 'layui-layer-rim', //加上边框
					area: ['700px', '400px'], //宽高
					content: d.msg
				});
			}else{
				layer.close(index);
				layer.alert(d.msg);
			}
		})
	})
</script>
