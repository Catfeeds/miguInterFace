<link rel="stylesheet" type="text/css" href="/js/uploadify/uploadify.css">
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.min.js"></script>
<div>
    <div id="admin_border">
        <form name="myForm" action="" method="post" enctype="multipart/form-data">
            <table width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <td width="100" align="right">版本：</td>
                    <td>
                        <div style="width:300px;">
                            <?php echo $detail['version']?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">包名：</td>
                    <td>
                        <div style="width:300px;">
                            <?php echo $detail['pname']?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">版本代号：</td>
                    <td>
                        <div style="width:300px;">
                            <?php echo $detail['verStr']?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right">下载地址：</td>
                    <td>
                        <div style="width:500px;">
                            <?php
                            echo $detail['path'];
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="164" align="right">客户端大小：</td>
                    <td>
                        <div class="tame not_img" style="width:300px;">
                            <?php echo round($detail['size']/1024000)?>M
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">平台标识：</td>
                    <td>
                        <input type="radio" name="app" value="1"<?php  if($detail['app']==1) echo 'checked'?> >
                        <label>安卓</label>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">新特性：</td>
                    <td>
                        <div style="width:600px;">
                            <textarea id="per" class="form-input w400" rows="4"  readonly name="per"><?php echo $detail['per']?></textarea>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" class="btn btn-blue btn-padding20 contentSave" onclick="history.go(-1)" value="返回"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
