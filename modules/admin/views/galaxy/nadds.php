<link rel="stylesheet" href="/js/jquery.datetimepicker.css">
<!--<script type="text/javascript" charset="utf-8" src="/web/js/uploadify/jquery.uploadify.min.js"></script>-->
<script type="text/javascript" charset="utf-8" src="/js/jquery.datetimepicker.js"></script>
<form action="" method="post">
    <table width="100%" cellspacing="0" cellpadding="10" class="mtable">
        <tr>
            <td align="right" valign="top">公告内容：</td>
            <td><textarea name="notice" id="notice" class="form-input w400" style="height:200px;resize: none;"><?php echo !empty($notice->notice)?$notice->notice:''?></textarea></td>
        </tr>
        <tr>
            <td width="100" align="right">地址:</td>
            <td>
                <select name="province" onchange="getregin()" id="province" class="form-input w200">
                    <!--                    <option value="0">请选择省份</option>-->
                    <?php
                    if(!empty($province)){
                        foreach($province as $v){?>
                            <option <?php if($provinceCode==$v['provinceCode']){echo "selected=selected"; } ?> value ="<?php echo $v['provinceCode']?>_<?php echo $v['provinceName']?>"><?php echo $v['provinceName']?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
                <select name="city" id="city"  class="form-input w200">
                    <option value="0">请选择市</option>
                    <?php
                    if(!empty($city)){
                        foreach($city as $vv){?>
                            <option <?php if($cityCode==$vv['cityCode']){echo "selected=selected"; } ?> value ="<?php echo $vv['cityCode']?>_<?php echo $vv['cityName']?>"><?php echo $vv['cityName']?></option>

                        <?php
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="cityNo" id="cityNo" value="">
            </td>
        </tr>
        <tr>
            <td align="right">有效期：</td>
            <td>
                <span><input type="text" name="sTime" value="<?php echo !empty($notice->sTime)?date('Y-m-d',$notice->sTime):''?>" id="sTime" class="form-input w200"></span>
                <span> -- </span>
                <span><input type="text" name="eTime" id="eTime"  value="<?php echo !empty($notice->eTime)?date('Y-m-d',$notice->eTime):''?>" class="form-input w200"></span>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="发布公告" class="btn">
                <input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo Yii::app()->createUrl('/admin/galaxy/notice',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>'">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    function getregin(){
        var shengid=$("#province").val();

        var i = shengid.split('_');//分割
        $("#city option").remove();

        $.getJSON("/admin/galaxy/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#city").append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
            });
        });
    }
    $(function(){
        $('#sTime,#eTime').datetimepicker({
            validateOnBlur:false,
            format : 'Y-m-d',
            timepicker : false,
            minDate : '<?php echo date('Y-m-d')?>',
        })
    });
</script>
