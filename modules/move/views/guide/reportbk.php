<div class="mt10" style="margin-top: 50px;">
    <form action="" method="get">
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
            <tr>
                <td>额外人数</td>
                <td><?php echo ($total['total']-$num['num'])?></td>
            </tr>
            </tbody>
        </table>
    </form>
    <div><?php echo $page;?></div>
</div>
