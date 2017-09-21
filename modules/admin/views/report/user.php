<div class="mt10" style="margin-top: 30px;">
    <form action="" method="get">
        <div style="font-size: 25px;padding:10px 0">总数：<?php echo $total?></div>
        <input type="hidden" name="mid" value="<?php echo $this->mid?>">
        <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>牌照方</th>
                <th>用户数</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>华数</td>
                <td><a href="<?php echo Yii::app()->createUrl('/admin/report/detial',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'type'=>'华数','t'=>!empty($huashu)?$huashu:'0'))?>"><?php echo !empty($huashu)?$huashu:'0'?></a></td>
            </tr>
            <tr>
                <td>南传</td>
                <td><a href="<?php echo Yii::app()->createUrl('/admin/report/detial',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'type'=>'南传','t'=>!empty($nanchuan)?$nanchuan:'0'))?>"><?php echo !empty($nanchuan)?$nanchuan:'0'?></a></td>
            </tr>
            <tr>
                <td>百视通</td>
                <td><a href="<?php echo Yii::app()->createUrl('/admin/report/detial',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'type'=>'百视通','t'=>!empty($baishi)?$baishi:'0'))?>"><?php echo !empty($baishi)?$baishi:'0'?></a></td>
            </tr>
            <tr>
                <td>银河</td>
                <td><a href="<?php echo Yii::app()->createUrl('/admin/report/detial',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'type'=>'银河','t'=>!empty($yinhe)?$yinhe:'0'))?>"><?php echo !empty($yinhe)?$yinhe:'0'?></a></td>
            </tr>
            </tbody>
        </table>
    </form>
</div>