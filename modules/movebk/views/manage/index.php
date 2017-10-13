<div class="btn-parent">
    <a href="<?php echo Yii::app()->createUrl('/admin/manage/add',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn">新增管理</a>
</div>
<div class="mt10">
    <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>编号</th>
            <th>牌照方</th>
            <th>省</th>
            <th>市</th>
            <th>板块</th>
            <th>位置</th>
            <th>内容描述</th>
            <th>有效期</th>
            <th>编辑人</th>
            <th>操作</th>
        </tr>
        <?php
        if(!empty($list)){
            foreach($list as $l){?>
                <tr <?php if($l['time']<strtotime(date('Y-m-d', time()))) echo "style='background-color:#D4DADB'";?>>
                    <td><?php echo $l['id']?></td>
                    <td><?php echo $l['cp']?></td>
                    <td><?php echo $l['province'] ?></td>
                    <td><?php echo $l['city'] ?></td>
                    <td><?php echo $l['plate'] ?></td>
                    <td><?php echo $l['position'] ?></td>
                    <td><?php echo $l['content'] ?></td>
                    <td><?= date('Y-m-d',$l['time']); ?></td>
                    <td><?php echo $l['editor'] ?></td>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('/admin/manage/add',array('mid'=>$this->mid,'bid'=>$l['id'],'nid'=>$_GET['nid']))?>">编辑</a>
                    </td>
                </tr>
            <?php
            }
        }else{
            echo '<tr><td colspan="10" align="center">暂时还未有管理信息</td></tr>';
        }
        ?>
    </table>
</div>
<div><?php echo $page;?></div>