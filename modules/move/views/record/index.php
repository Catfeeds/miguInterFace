<div class="mt10">
	<form action="" method="get">
		<input type="hidden" name="mid" value="<?php echo $this->mid?>">
		<table class="mtable " cellpadding="10" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>编号</th>
					<th>操作类型</th>
					<th>操作内容</th>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($list)){
				foreach($list as $l){?>
					<tr id="<?php echo $l['id'];?>" class="trdata">
						<td><?php echo $l['id']?></td>
						<td width='60px'><?php echo $l['recordType']?></td>
						<td><?php echo $l['content']?></td>
					</tr>
				<?php
				}
			}else{?>
				<tr>
					<td colspan="6" align="center">暂无操作记录</td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</form>
	<div class="interpret">
        <div class="page">
            <div class="page m-page">
                <ul class="page-ul-init mr5 ">
                    <li class="mr10" title="首页">
                        <a class="first one first-page" val="1" href="javascript:void(0)">首页</a>
                    </li>
                    <li class="mr10" title="上一页">
                        <a class="first one prev-page" val="0" href="javascript:void(0)">上一页</a>
                    </li>
                    <li class="mr10" title="下一页">
                        <a class="first one next-page" val="2" href="javascript:void(0)">下一页</a>
                    </li>
                    <li class="mr10" title="尾页">
                        <a class="first one last-page" val="4" href="javascript:void(0)">尾页</a>
                    </li>
                    <li class="mr10 go" title="go">
                        <input class='pageGo' type="number" name="go"  placeholder="输入要去的页数点击go~~"/>
                        <a class="first  one go-page" val="3" href="javascript:void(0)">go</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="nowpage">当前第1页</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="num">共<b class="totalPage"><?php echo $totalPage ;?></b>页</a>
                    </li>
                </ul>
                <div class="clear">

                </div>
            </div>
        </div>
    </div>
</div>

<div><?php //echo $page;?></div>
<script type="text/javascript" charset="utf-8">

	var p=1;
    $('.one').click(function()
    {
    	
        if($(this).attr('val') == 1){
            p=1;
        }else if($(this).attr('val') == 0 ){
            p = parseInt(p)-1;
            if(p<1){
                p=1;
            }
        }else if($(this).attr('val') == 2){
            p = parseInt(p)+1;

        }else if($(this).attr('val') == 3){
            var goP = $('.pageGo').val();
            p =parseInt(goP);
        }else if($(this).attr('val') == 4){
            var totalPage = $('.totalPage').text();
            p = parseInt(totalPage);
        }
        var maxP = $('.totalPage').text();
        if(p > maxP){
        	return false;
        }
        if( $('.btn').hasClass('seachFlag') == true){
            seach(p);
            $('.nowpage').text("当前第"+p+"页");
            return false;
        }
        $('.choseNum').hide();
        $('.nowpage').text("当前第"+p+"页");
        $.ajax
         ({
             type:'post',
             url:'/move/record/page/mid/<?php echo $_REQUEST['mid'] ;?>/p/'+p,
             success:function(data)
             {
                   data = jQuery.parseJSON(data);
                   console.log(data);
                   $('.trdata').remove();
                   for(var i = 0 ; i<data.length ; i++){                    
                         $('.mtable').append
                         (
                             "<tr class='trdata' id='"+(i+1)+"'>"+
                             "<td align='left'>"+data[i].id+"</td>"+
                             "<td align='left' width='60px'>"+data[i].recordType+"</td>"+
                             "<td align='left'>"+data[i].content+"</td>"+
                             "</tr>"
                         )
                   }
             }
         })
    })
</script>

