<style type="text/css">
	.hr:first-child{
		border-bottom:none;
	}
	.hr{
		border:1px solid #ccc;
	}
</style>
<script src="<?php echo Yii::app()->request->baseUrl?>/js/jquery-1.8.2.min.js"></script>
<form action="" method="post">
	<table class="mtable" cellpadding="10" width="100%" cellspacing="0">
		<tr>
			<td width="100" align="right">组名称：</td>
			<td><input type="text" name="name" id="name" class="form-input w400" value="<?php echo !empty($group->name)?$group->name:''?>"></td>
		</tr>
		<tr>
			<td align="right" valign="top">组权限：</td>
			<td id="authList">
                <?php
                $auths = array();
                if(!empty($group->auth)) $auths = explode(',',$group->auth);
                foreach($fulei as $key => $v){
                ?>
                	<div class="hr">
                		<label for="auth<?php echo $v['id']?>">
                			<input type="checkbox" value="<?php echo $v['id']?>" <?php echo in_array($v['id'],$auths)?'checked="checked"':''?> name="auth[]" id="<?php echo $v['id']?>" onclick="check(this);"> <?php echo $v['name']?>
                		</label>
                		<br /><span style="width:100px;display: inline-block;"></span>
                		<?php
                             $id=$v['id'];
                             $zilei = Guide::model()->findAll("pid=$id order by `order` asc");
                             foreach($zilei as $key=>$val){?>
                					<label for="auth<?php echo $val['id']?>">
                						<input type="checkbox" value="<?php echo $val['id']?>" <?php echo in_array($val['id'],$auths)?'checked="checked"':''?> name="auth[]" id="auth<?php echo $val['id']?>" class="ziji<?php echo $v['id'];?>"  rel="<?php echo $v['id'];?>"  onclick="ziji(this);"> <?php echo $val['name']?>
                					</label>
                             <?php
                					}}
                			 ?>
                	</div>

			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" value="保存权限组" class="btn">
				<input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('group','index',array('nid'=>$_GET['nid']))?>'">
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">

    function check(obj){
        id=obj.id;
        //判断父级有没有被选中  如果被选中 就选择子级
        if(document.getElementById(id).checked){
            var checkBox =document.getElementsByClassName("ziji"+id+[]);
            for (var i = 0; i< checkBox.length; i++){
                var temp = checkBox[i];
                //如果该值为true，说明选中
                temp.checked = true;
            }
        }else{
            var checkBox =document.getElementsByClassName("ziji"+id+[]);
            for (var i = 0; i< checkBox.length; i++){
                var temp = checkBox[i];
                //如果该值为true，说明选中
                temp.checked = false;
            }
        }

    }
    function ziji(obj){
        //这个a其实是父类的id
        a=obj.getAttribute("rel");
        if(obj.checked){
            $("#"+a).attr("checked",true);
        }else{
//            $("#"+a).attr("checked",false);
        }
    }
</script>