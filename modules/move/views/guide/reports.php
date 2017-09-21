<div class="mt10" style="margin-top: 20px;">
    <form action="" method="get">
        <div><a href="<?php echo Yii::app()->createUrl('/move/guide/report',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn" style="display: inline-block;">返回上一级</a></div>
        <input type="hidden" name="mid" value="<?php echo $this->mid?>">
        <div style="font-size: 25px;padding:10px 0">总数：<?php echo $total['total']?></div>
        <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>版本号</th>
                <th>用户数量</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)){
                foreach($list as $val){?>
                    <tr>
                        <td><?php echo $val['vname']?></td>
                        <td><a href="<?php echo Yii::app()->createUrl('/move/guide/stbid',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'province'=>$_GET['pro'],'version'=>$val['vname']))?>"><?php echo $val['num']?></a></td>
                    </tr>
                <?php
                }
            }else{?>
                <tr>
                    <td colspan="7" align="center">暂无数据</td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </form>
    <div><?php echo $page;?></div>
</div>
