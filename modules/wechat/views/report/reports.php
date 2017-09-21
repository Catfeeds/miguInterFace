<div class="mt10" style="margin-top: 20px;">
    <form action="" method="get">
        <div><a href="<?php echo Yii::app()->createUrl('/wechat/report/report',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn" style="display: inline-block;">返回上一级</a></div>
        <input type="hidden" name="mid" value="<?php echo $this->mid?>">
        <div style="font-size: 25px;padding:10px 0">总数：<?php echo $total['total']?></div>
        <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>版本号</th>
                <th>牌照方</th>
                <th>绑定数量</th>
                <th>用户数量</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)){
                foreach($list as $val){?>
                    <tr>
                        <td><?php echo $val['vname']?></td>
                        <td><?php
                           if($val['cp']=='1'){
                                echo '华数';
                            }elseif($val['cp']=='2'){
                                echo '百视通';
                            }elseif($val['cp']=='3'){
                                echo '未来电视';
                            }
                        ?></td>
<td><?php echo $val['bd']?></td>
                        <td><?php echo $val['num']?></td>
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


