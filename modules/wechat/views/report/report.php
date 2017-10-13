<div class="mt10" style="margin-top: 50px;">
    <form action="" method="get">
        <input type="hidden" name="mid" value="<?php echo $this->mid?>">
        <div style="font-size: 25px;padding:10px 0">总数：<?php echo $num['num']?></div>
        <table class="mtable center" cellpadding="10" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>省份</th>
                <th>用户数量</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)){
                foreach($list as $val){?>
                    <tr>
                        <td><?php
                            if($val['pro']=='请选择省份'){
                                echo '全国';
                            }else{
                                echo $val['pro'];
                            }
                        ?></td>
                        <td><a href="<?php echo Yii::app()->createUrl('/wechat/report/reports',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'pro'=>$val['province']))?>"><?php echo $val['num']?></a></td>
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

