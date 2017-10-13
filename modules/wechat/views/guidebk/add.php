<form action="" method="post">
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
		<span class="s">
            <tr id="addr">
				<td width="100" align="right">地址：</td>
				<td>
					<select name="province[]" onchange="getregin(this)" id="w0" class="form-input" style="width: 140px">
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
					<select name="city[]" id="c0" class="form-input"  style="width: 140px">
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
				</td>
			</tr>
        </span>
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
</script>
<script>
	function checks(obj){
		var num=$("#xuanze").val();
		$('.addr').remove();
		for (var i=1;i<num;i++){
			//这里可以用ajax获取省的数据 然后组装成 append里面的数据
			// $(".s").append("<select class='aa' name='province[]' style='width: 200px;height: 33px;'><option>省</option> </select>");
			//alert(i);
			$("#addr").after("<tr class='addr'><td width='100' align='right'>地址:</td><td><select onchange='getregin(this)' id=w"+i+" name='province[]' class='form-input aa' style='width: 140px;height: 33px;'></select><select id=c"+i+" name='city[]' class='form-input cc' style='width: 140px;height: 33px;'></select></td></tr>");
			//console.log("#w"+i);
			$.ajax({
				type: "POST",
				url: '/wechat/guide/getpro?mid=<?php echo $_GET['mid']?>',
				async : false,//是否为同步
				dataType: "json",
				success: function(data){
					var weizhi=i;
					//console.log("#w"+i);
					$.each(data,function(i){
						$("#w"+weizhi).append("<option value="+data[i]["provinceCode"]+'_'+data[i]['provinceName']+">"+data[i]["provinceName"]+"</option>");
					});
					$("#c"+weizhi).append('<option>请选择市</option>');
				}
			});
		}
	}

	function getregin(obj){
		var shengid=obj.value;
		var i = shengid.split('_');//分割
		var ns=obj.id;
		var wz=ns.charAt(ns.length - 1);
		var remo="c"+wz+' '+"option";

		$("#"+remo).remove();

		$.getJSON("/wechat/guide/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

			$.each(data,function(i){
				$("#c"+wz).append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
			});
		});
	};
</script>
