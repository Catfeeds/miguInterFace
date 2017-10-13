<div class="mt10" style="margin-top: 20px;">
    <form action="" method="get">
        <div><a href="<?php echo Yii::app()->createUrl('/admin/report/user',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn" style="display: inline-block;">返回上一级</a></div>
        <div style="font-size: 25px;padding:10px 0"><?php echo !empty($_GET['type'])?($_GET['type']):''?>总数：<?php echo !empty($_GET['t'])?$_GET['t']:'0'?></div>
        <input type="hidden" name="mid" value="<?php echo $this->mid?>">
        <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>省份</th>
                <th>用户数</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($province)){
                foreach($province as $val){?>
                    <tr>
                        <td><?php echo $val['provinceName']?></td>
                        <td><a href="<?php echo Yii::app()->createUrl('/admin/report/stbid',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'type'=>!empty($_GET['type'])?($_GET['type']):'','province'=>$val['province'],'t'=>!empty($_GET['t'])?$_GET['t']:'0','num'=>$val['num']))?>"><?php echo $val['num']?></a></td>
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
