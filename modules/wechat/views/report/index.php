<div class="mt10" style="margin-top: 20px;">
    <form action="" method="get">
        <div style="font-size: 25px;padding:10px 0">总数：<?php echo !empty($total)?$total:'0'?></div>
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


