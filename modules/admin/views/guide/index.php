<div class="btn-parent">
	<?php
	$pid = !empty($p) ? $p->pid : 0 ;
	if(!empty($_GET['id'])){?>
		<a href="<?php echo Yii::app()->createUrl('/admin/guide/index',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'id'=>$pid,'pid'=>$_GET['pid']))?>" class="btn" style="display: inline-block;float: left;">返回上一级</a>
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
						<a href="<?php echo Yii::app()->createUrl('/admin/guide/index',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'pid'=>$g['pid'],'id'=>$g['id']))?>">查看子集</a>
						<a href="javascript:void(0)" class="up" edit="up" gid="<?php echo $g['id']?>">前移</a>
						<a href="javascript:void(0)" class="down" edit="down" gid="<?php echo $g['id']?>">后移</a>
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
<script type="text/javascript">

    $('.up').click(function(){
        var k = $(this);
        var newV = $(k).parent().parent().attr('nid');
        var prev = $(k).parent().parent().prev().attr('nid');
        var url = '<?php echo Yii::app()->createUrl('/admin/guide/up',array('mid'=>$_GET['mid']))?>';
        if(empty(prev)){
            alert('你已经排在最前面了');
            return false;
        }

        $.post(url,{nid:newV,prev:prev},function(d){
            if(d.code == 200){
                $(k).parent().parent().insertBefore($(k).parent().parent().prev());
            }else{
                alert(newV+':'+prev);
            }
        },'json');
    });

    $('.down').click(function(){
        var k = $(this);
        var newV = $(k).parent().parent().attr('nid');
        var prev = $(k).parent().parent().next().attr('nid');
        var url = '<?php echo Yii::app()->createUrl('/admin/guide/down',array('mid'=>$_GET['mid']))?>';
        if(empty(prev)){
            alert('你已经排在最后了');
            return false;
        }

        $.post(url,{nid:newV,next:prev},function(d){
            if(d.code == 200){
                $(k).parent().parent().insertAfter($(k).parent().parent().next());
            }else{
                alert(newV+':'+prev);
            }
        },'json');
    });
</script>
