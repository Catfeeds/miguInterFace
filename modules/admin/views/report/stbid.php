<div class="mt10" style="margin-top: 20px;">
    <form action="" method="get">
        <div><a href="<?php echo Yii::app()->createUrl('/admin/report/detial',array('mid'=>$this->mid,'type'=>!empty($_GET['type'])?($_GET['type']):'','t'=>!empty($_GET['t'])?$_GET['t']:'0','nid'=>$_GET['nid']))?>" class="btn" style="display: inline-block;">返回上一级</a></div>
        <div style="font-size: 25px;padding:10px 0"><?php echo !empty($_GET['type'])?($_GET['type']):''?>总数：<?php echo !empty($_GET['t'])?$_GET['t']:'0'?></div>
        <input type="hidden" name="mid" value="<?php echo $this->mid?>">
        <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>设备号</th>
                <th>注册时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($stbid)){
                foreach($stbid as $val){?>
                    <tr>
                        <td><?php echo $val['stbid'];?></td>
                        <td><?php echo $val['cTime'];?></td>
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
