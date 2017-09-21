<?php
$admin = $this->getWxAdmin();
?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/jquery.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/myString.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/function.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicUser.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/WechatWatchGroups_Index.js"?>"></script>
<script charset="utf-8" type="text/javascript" src="/js/jdate/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="/js/jdate/jquery.datetimepicker.css" />
<style>
    .admin_border{
        min-height:800px;
        height:500px;
    }
    .content_top h3{
        margin:0 auto;
        width:200px;
    }
    .modules{
        height:30px;


    }
    .keyword{
width:200px;
    }
</style>
<!-- <input class="form-input keyword" type="text" placeholder="请输入关键字" name="keyword" value="">  -->
<select name="province" onchange="getregin(this)" id="w0" class="form-input province" style="width: 140px">
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
<span>开始日期</span>
<input  type="text" name="first" id="first" class="form-input w100" value="<?php echo !empty($_GET['first'])?$_GET['first']:''?>">
<span>结束日期</span>
<input type="text" name="end" id="end" class="form-input w100" value="<?php echo !empty($_GET['end'])?$_GET['end']:''?>">
<input class="btn btn1 btn-gray audit_search  " type="submit"  value="查找" name="" style="font-size: 14px">
<input class="btn btn2 btn-gray audit_search  " type="submit"  value="导出" name="" style="font-size: 14px">

<form method="post" action="" >
    <td>

    </td>
</table>
</form>
<div class="table" >

</div>
<script>
    $('#first,#end').datetimepicker({
        lang:'ch',
        validateOnBlur:false,
        timepicker:false,
        format:'Y-m-d',
        formatDate: 'Y-m-d',
        maxDate:'<?php echo date('Y-m-d',strtotime('0 day'))?>'
    });


    $('.btn1').click(function(){
        var province = $('.province').val();
        province =province.split('_');
        var provinceid=province[0];
        var user = '<?php echo $admin['nickname'];?>';
        user = user.split('_');
        userid = user[1];
        if(userid !=undefined){
            if(userid !=provinceid){
                alert('您没有权限查看该省市');
                return false;
            }else{
getData(1);
            }
        }else{
            getData(1);
        }
    })

    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num;//总记录数,每页条数,总页数


    function getData(page) { //获取当前页数据
        var province = $('.province').val();
        province =province.split('_');
        var provinceid=province[0];
        var user = '<?php echo $admin['nickname'];?>';
        user = user.split('_');
        userid = user[1];
        if(userid !=undefined){
            if(userid !=provinceid){
                alert('您没有权限查看该省市');
                return false;
            }
        }
        worker = $('select').val();
        first = $('input[name=first]').val();
        end = $('input[name=end]').val();
        var type=3;
        if(end.length > 0 && first.length == 0){
alert('请选择起始时间');
            return false;
        }

        if(first.length >0 && end.length == 0){
            alert('请选择结束时间');
            return false;
        }
        $('tbody').children('tr').eq( page_size ).remove();
        var my = layer.msg('加载中', {icon: 16,shade:0.3});
        $.ajax({
            type: 'GET',
            url: '/wechat/report/userlist?mid='+"<?php echo $_GET['mid'];?>"+"&first="+first+"&end="+end+"&province="+provinceid+"&type="+type,
            data: {'page': page - 1},
            dataType: 'json',
            success: function(json) {
                $('.table').empty();
                if(json.code==404){
                    total_num = json.count;//总记录数
                    page_size = json.page_size;//每页数量
                    page_cur = page;//当前页
                    page_total_num = json.page_total_num;//总页数
                    var li ='';
                    li += '<tr class="add"><td  colspan="8" align="center">暂无数据</td></tr>';
                    $('.table').html(li);
}else {
                    layer.close(my);
                    console.log(json);
                    total_num = json.count;//总记录数
                    page_size = 5;//每页数量
                    page_cur = page;//当前页
                    page_total_num = Math.ceil((total_num)/5);//总页数
                    var list = json.res;
                    var tr = "<tr>"+
                        "<th width='10%'>应用名称</th>"+
                        "<th width='10%'>分类</th>"+
                        "<th width='10%'>投屏次数</th>"+
                        "<th width='10%'>日期</th>"+
                        "</tr>";
                    var li = '';
                    var li = '<table class="mtable center tbadd" cellpadding="10" cellspacing="0" width="100%" height="300px">';
                    li += tr;
                    $.each(list, function (index, array) { //遍历返回json
                        li += "<tr class='add'><td>" + array['title'] + "</td><td>" + array['typeName'] + "</td><td>" + array['total'] + "</td><td>" + array['time'] + "</td></tr>";
                    });
                    li +='</table>';
                    $('.table').html(li);
                }
            },
 complete: function() {
                getPageBar();//js生成分页，可用程序代替
            },
            error: function() {
                alert("数据异常,请检查是否json格式");
            }
        });
    }
    function getPageBar() { //js生成分页
        if (page_cur > page_total_num)
            page_cur = page_total_num;//当前页大于最大页数
        if (page_cur < 1)
            page_cur = 1;//当前页小于1
        page_str = "<tr class='add'><td colspan='8'><span>共" + total_num + "条</span><span>" + page_cur + "/" + page_total_num + "</span>";
        if (page_cur == 1) {//若是第一页
            page_str += "<span>首页</span><span>上一页</span>";
        } else {
            page_str += "<span><a href='javascript:void(0)' data-page='1' onclick=getData(1)>首页</a></span><span><a href='javascript:void(0)' data-page='" + (page_cur - 1) + "' onclick=getData("+ (parseInt(page_cur) - 1) +")>上一页</a></span>";
        }
        if (page_cur >= page_total_num) {//若是最后页
            page_str += "<span>下一页</span><span>尾页</span>";
        } else {
page_str += "<span><a href='javascript:void(0)' data-page='" + (parseInt(page_cur) + 1) + "' onclick=getData("+ (parseInt(page_cur) + 1) +") >下一页</a></span><span><a href='javascript:void(0)' data-page='" + page_total_num + "'  onclick=getData("+ (page_total_num) +")>尾页</a></span></td></tr>";
        }
        $(".tbadd tbody").append(page_str);
    }

    $('.btn2').click(function(){
        var province = $('.province').val();
        province =province.split('_');
        var provinceid=province[0];
        var user = '<?php echo $admin['nickname'];?>';
        user = user.split('_');
        userid = user[1];
        if(userid !=undefined){
                if(userid !=provinceid){
                    alert('您没有权限查看该省市');
                    return false;
                }else{
                    out()
                }
        }else{
out();
        }

    })

    function out(){
        var province = $('.province').val();
        province =province.split('_');
        var provinceid=province[0];
        worker = $('select').val();
        keyword = $('input[name=keyword]').val();
        first = $('input[name=first]').val();
        end = $('input[name=end]').val();
        var type=3;
        if(end.length > 0 && first.length == 0){
            alert('请选择起始时间');
            return false;
        }

        if(first.length >0 && end.length == 0){
            alert('请选择结束时间');
            return false;
        }
        window.location.href = '/wechat/report/outs?mid=<?php echo $this->mid?>&first='+first+'&end='+end+'&province='+provinceid+'&type='+type;
        return false;
}

    function getregin(obj){
        var shengid=obj.value;
        var i = shengid.split('_');//分割
        var ns=obj.id;
        var wz=ns.charAt(ns.length - 1);
        var remo="c"+wz+' '+"option";

        $("#"+remo).remove();

        $.getJSON("/wechat/report/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#c"+wz).append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
            });
        });
    };
</script>


