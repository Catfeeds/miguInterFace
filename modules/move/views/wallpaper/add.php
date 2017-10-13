<form action="" method="post" enctype="multipart/form-data">
    <table class="mtable" width="50%" cellpadding="10" cellspacing="0">
        <tr>
            <td width="100" align="right">选中的图片：</td>
            <td>
                <input name="pic" type="file" class="form-input">
                <input name="pics" type="text" class="form-input" value="<?php echo !empty($wallpaper->pic)?$wallpaper->pic:''?>">
            </td>
        </tr>
        <tr>
            <td width="100" align="right">标题</td>
            <td><input name="title" type="text" class="form-input" value="<?php echo !empty($wallpaper->title)?$wallpaper->title:''?>"></td>
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
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="保存信息" class="btn">
                <input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('guide','index')?>'">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $('#pid').change(function(){
        var v = $(this).val();
        if(empty(v)){
            $('#url').val("javascript:void(0)").attr('readonly',true);
        }else{
            $('#url').val("").attr('readonly',false);
        }
    });


    function getregin(){
        var shengid=$("#province").val();

        var i = shengid.split('_');//分割
        $("#city option").remove();

        $.getJSON("/move/guide/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#city").append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
            });
        });
    }
</script>
