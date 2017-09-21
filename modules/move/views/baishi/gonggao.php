<div class="btn-parent">
    <a href="<?php echo Yii::app()->createUrl('/admin/baishi/adds',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn">新增公告</a>
</div>
<div class="mt10">
    <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>编号</th>
            <th>公告内容</th>
            <th>有效开始时间</th>
            <th>有效结束时间</th>
            <th>操作</th>
        </tr>
        <?php
        if(!empty($list)){
            foreach($list as $l){?>
                <tr>
                    <td><?php echo $l['id']?></td>
                    <td><?php echo $l['notice']?></td>
                    <td><?php echo date('Y-m-d',$l['sTime']);?></td>
                    <td><?= date('Y-m-d',$l['eTime']); ?></td>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('/admin/baishi/adds',array('mid'=>$this->mid,'bid'=>$l['id'],'nid'=>$_GET['nid']))?>">编辑</a>
                        <a href="javascript:void(0)" bid="<?php echo $l['id']?>" class="del">删除</a>
                    </td>
                </tr>
            <?php
            }
        }else{
            echo '<tr><td colspan="5" align="center">暂时还未有公告</td></tr>';
        }
        ?>
    </table>
</div>
<div><?php echo $page;?></div>
<script type="text/javascript">
    $('.del').click(function(){
        var k = $(this);
        var v = $(k).attr('bid');
        if(empty(v)) return false;
        $.post('/admin/baishi/del?mid=<?php echo $this->mid?>',{id:v},function(d){
            if(d.code == 200){
                $(k).parent().parent().remove();
                layer.alert(d.msg,{icon:1});
            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json')
    });
</script>