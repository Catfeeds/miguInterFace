<div class="btn-parent">
	<?php
	$pid = !empty($p) ? $p->pid : 0 ;
	if(!empty($_GET['id'])){?>
		<a href="<?php echo Yii::app()->createUrl('/move/guide/index',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'id'=>$pid,'pid'=>$_GET['pid']))?>" class="btn" style="display: inline-block;float: left;">返回上一级</a>
		<?php
	}
	?>
	<a href="<?php echo $this->get_url('guide','add')?>" class="btn">新建导航</a>
</div>
<div>
	<table class="mtable mt10" cellpadding="10" cellspacing="0" width="100%">
		<tr>
			<th>编号</th>
			<th>导航名称</th>
			<th>模块</th>
			<th>操作</th>
		</tr>
		<?php
		if(!empty($guide)){
			foreach($guide as $g){?>
				<tr gid="<?php echo $g['id']?>">
					<td align="center"><?php echo $g['id']?></td>
					<td align="center"><?php echo $g['name']?></td>
					<td align="center"><?php echo $g['module']?></td>
					<td align="center" class="edit" width="300">
						<a href="<?php echo Yii::app()->createUrl('/move/guide/index',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'pid'=>$g['pid'],'id'=>$g['id']))?>">查看子集</a>
						<a href="<?php echo $this->get_url('guide','add',array('id'=>$g['id']))?>">编辑</a>
						<a href="<?php echo $this->get_url('guide','del',array('id'=>$g['id']))?>">删除</a>
					</td>
				</tr>
		<?php
			}
		}else{?>
			<tr>
				<td colspan="4" align="center">该分类下没有子分类</td>
			</tr>
		<?php
		}
		?>
	</table>
</div>