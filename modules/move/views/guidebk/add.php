<form action="" method="post" enctype="multipart/form-data">
	<table class="mtable" width="50%" cellpadding="10" cellspacing="0">
		<tr>
			<td align="right">导航分级：</td>
			<td>
				<select name="pid" id="pid" class="form-input">
					<option value="0">顶级导航</option>
					<?php
					if(!empty($parent)){
						foreach($parent as $p){?>
							<option value="<?php echo $p['id'] ?>" <?php echo !empty($guide->pid) && $guide->pid == $p['id']?'selected="selected"':''?>><?php echo $p['name']?></option>
					<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">导航名称：</td>
			<td><input type="text" name="name" id="name" class="form-input" value="<?php echo !empty($guide->name)?$guide->name:''?>"></td>
		</tr>
		<tr>
			<td align="right">需要跳转：</td>
			<td>
				<label for="out"><input type="radio" name="uType" id="out" value="1" <?php echo !empty($guide->uType) && $guide->uType == 1?'checked="checked"':''?>> 是</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="in"><input type="radio" name="uType" id="in" value="2" <?php echo !empty($guide->uType) && $guide->uType == 2?'checked="checked"':''?>> 否</label>
			</td>
		</tr>
		<tr>
			<td align="right">链接：</td>
			<td><input type="text" name="url" id="url" class="form-input" value="<?php echo !empty($guide->url)?$guide->url:''?>"></td>
		</tr>
        <tr>
            <td align="right">vip：</td>
            <td>
                <label for="outs"><input type="radio" name="vip" id="outs" value="1" <?php echo !empty($guide->vip) && $guide->vip == 1?'checked="checked"':''?>> 是</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="ins"><input type="radio" name="vip" id="ins" value="0" <?php echo !empty($guide->vip) && $guide->vip == 2?'checked="checked"':''?>> 否</label>
            </td>
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
            <td width="100" align="right">选中的图片：</td>
            <td>
                <input name="ico_true" type="file" class="form-input">
                <input name="ico_trues" type="text" class="form-input" value="<?php echo !empty($guide->ico_true)?$guide->ico_true:''?>">
            </td>
        </tr>
        <tr>
            <td width="100" align="right">未选中的图片：</td>
            <td>
                <input id="ico_false" name="ico_false" type="file" value="">
                <input name="ico_falses" type="text" class="form-input" value="<?php echo !empty($guide->ico_false)?$guide->ico_false:''?>">
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