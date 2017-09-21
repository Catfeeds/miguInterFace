<style>
.interpret{
        /*width: 97.8%;
        height: 35px;
        line-height: 35px;
        margin-left: 15px;
        background: #f9f9f9;
        border: 1px solid #e4e3e3;
        border-top: none;
        padding: 10px 0 10px 8px;*/
    }
    .page {
        margin-left: 11px;
        margin-top: 2px;
    }
    .page {
        width: 99%;
        height: 37px;
        line-height: 37px;
        margin: 0 auto;
        text-align: center;
    }
    .m-page {
        margin: 20px auto;
        text-align: center;
        clear: both;
        overflow: hidden;
    }
    .page ul li {
        float: left;
        line-height: 37px;
        height: 37px;
        font-size: 15px;
    }
    .pageGo{
        width:180px;
        height:33px;
        /*background:#52CAF4;*/
        border:1px solid #ccc;
    }
    label{
        width:10%;
        height:10%;
        display:block;

    }
    #search{
        width:200px;
    }
    .adddiv{
        margin-top: 1rem;
    }
    .add {
        background-color: #0099CC;
        padding: 8px 20px;
        display: inline-block;
        border-radius: 4px;
        border: 1px solid #6699CC;
        color: #fff;
        font-family: "microsoft yahei";
        font-size: 18px;
        background-image: -moz-linear-gradient(top, #00CCFF,#0099CC);
        background-image: -webkit-gradient(linear,left top,left bottom, color-stop(0, #00CCFF), color-stop(1, #0099CC));
        cursor: pointer;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00CCFF', endColorstr='#0099CC', GradientType='0');
        /*display: block;*/
        float: left;
        margin-left: 1rem;
    }
    .choseNum{

        background-color: #0099CC;
        padding: 8px 20px;
        display: none;
        border-radius: 4px;
        border: 1px solid #6699CC;
        color: #fff;
        font-family: "microsoft yahei";
        font-size: 18px;
        background-image: -moz-linear-gradient(top, #00CCFF,#0099CC);
        background-image: -webkit-gradient(linear,left top,left bottom, color-stop(0, #00CCFF), color-stop(1, #0099CC));
        cursor: pointer;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00CCFF', endColorstr='#0099CC', GradientType='0');
        /*display: block;*/
        float: left;
    }
</style>
<body>
<div>
    <select name="cp" id="cp" onchange="cpChose1()"  class="form-input w200 field">
        <option value="0">-----------请选择节牌照方--------</option>
        <option onclick='cpChose(this)' value="642001">华数</option>
        <option onclick='cpChose(this)' value="BESTVOTT">百视通</option>
        <option onclick='cpChose(this)' value="ICNTV">未来电视</option>
        <option onclick='cpChose(this)' value="youpeng">南传</option>
        <option onclick='cpChose(this)' value="HNBB">芒果</option>
        <option onclick='cpChose(this)' value="CIBN">国广</option>
        <option onclick='cpChose(this)' value="YGYH">银河</option>
    </select>

    <select name="language"  id="language" class="form-input w200 field">
        <option value="0">---------------请选择语言-------------</option>
        <?php
            foreach($fieldLanguage as $k=>$v){
                echo "<option value='".$v['language']."''>".$v['language']."</option>";
            }


        ?>
        <!--<option  value="1"></option>
        <option  value="中文">中文</option>
        <option  value="国语">国语</option>
        <option  value="粤语">粤语</option>
        <option  value="原声">原声</option>
        <option  value="原音">原音</option>
        <option  value="英语">英语</option>
        <option  value="日语">日语</option>
        <option  value="韩语">韩语</option>
        <option  value="Chinese">Chinese</option>-->
        <!--        <option  value="6">国广</option>-->
        <!--        <option  value="7">银河</option>-->
    </select>
    <select name="type"  id="type" class="form-input w200 field">
        <option value="0">----------请选择节目类型---------</option>
        <?php
        foreach($fieldType as $k=>$v){
            echo "<option value='".$v['type']."''>".$v['type']."</option>";
        }

        ?>
       <!-- <option  value="动漫">动漫</option>
        <option  value="娱乐">娱乐</option>
        <option  value="少儿">少儿</option>
        <option  value="教育">教育</option>
        <option  value="新闻">新闻</option>
        <option  value="新闻资讯">新闻资讯</option>
        <option  value="法治">法治</option>
        <option  value="生活">生活</option>
        <option  value="电影">电影</option>
        <option  value="电影">电竞</option>
        <option  value="纪实">纪实</option>
        <option  value="综艺">综艺</option>
        <option  value="财经">财经</option>
        <option  value="音乐">音乐</option>
        <option  value="高清">高清</option>
        <option  value="体育">体育</option>
        <option  value="其他">其他</option>
        <option  value="电视剧">电视剧</option>
        <option  value="记录专题">记录专题</option>
        <option  value="其他栏目">其他栏目</option>
        <option  value="电视剧类节目">电视剧类节目</option>
        <option  value="电影类节目">电影类节目</option>
        <option  value="视频类节目">视频类节目</option>
        <option  value="录制类节目">录制类节目</option>-->
    </select>

    <input type="text" name="select" id="search" class="form-input w100" value='' placeholder="输入片名搜索" onfocus="if(value==defaultValue){value='';this.style.color='#000'}" onblur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999">
    <button class="btn">搜索</button>
</div>
<div>
    <table class="mtable mt10" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>勾选</th>
            <th>编号</th>
            <th>牌照方</th>
            <th>影片名称</th>
            <th>语言</th>
<!--            <th>short</th>-->
<!--            <th>关键字</th>-->
            <th>导演</th>
            <th>演员</th>
<!--            <th>年份</th>-->
<!--            <th>节目类型</th>-->
            <th>cate</th>
<!--            <th>时间</th>-->
        </tr>

        <?php
        if(!empty($list)){
            $num=1;
            foreach($list as $key=>$val){
//                    $val['cp'] = substr($val['cp'],5);
                    switch($val['cp'])
                    {
                        case '642001' : $val['cp']='华数' ; break;
                        case 'BESTVOTT' : $val['cp']='百事通' ; break;
                        case 'ICNTV' : $val['cp']='未来电视' ; break;
                        case 'youpeng' : $val['cp']='南传' ; break;
                        case 'HNBB' : $val['cp']='芒果' ; break;
                        case 'CIBN' : $val['cp']='国广' ; break;
                        case 'YGYH' : $val['cp']='银河' ; break;
                    }
                ?>
                <tr class="trdata" id="<?php echo $num++?>">
                    <td align="center"><label><input type="checkbox" class='chosetr' name="id" onclick='chose(this)' value="<?php echo $val['id'] ;?>"/></label></td>
                    <td align="center"><?php echo $val['id']?></td>
                    <td align="center"><?php echo $val['cp']?></td>
                    <td align="center"><?php echo $val['title']?></td>
                    <td align="center"><?php echo $val['language']?></td>
<!--                    <td align="center" width="20%">--><?php //echo $val['short']?><!--</td>-->
<!--                    <td align="center">--><?php //echo $val['keyword']?><!--</td>-->
                    <td align="center"><?php echo $val['director']?></td>
                    <td align="center"><?php echo $val['actor']?></td>
<!--                    <td align="center">--><?php //echo $val['year']?><!--</td>-->
<!--                    <td align="center">--><?php //echo $val['type']?><!--</td>-->
                    <td align="center"><?php echo $val['cate']?></td>
<!--                    <td align="center">--><?php //echo date("Y-m-d",$val['cTime'])?><!--</td>-->
                </tr>
            <?php }
        }


        ?>
    </table>

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
                        <a class="first one go-page" val="3" href="javascript:void(0)">go</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="nowpage">当前第1页</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="num">共<b class="totalPage"><?php echo $total ;?></b>页</a>
                    </li>
                </ul>
                <div class="clear">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="adddiv">
    <div class="choseNum">已选择 1 条数据</div>
    <a  class="add" onclick="add(this)">导入</a>

</div>
</body>
<script>
	
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
             url:'/wechat/meizi/page/mid/<?php echo $_REQUEST['mid'] ;?>/p/'+p,
             success:function(data)
             {
                   data = jQuery.parseJSON(data);
                   $('.trdata').remove();
                   for(var i = 0 ; i<data.length ; i++){
//                       data[i].cp = data[i].cp.substr(5);
                       switch( data[i].cp )
                       {
                           case '642001' : data[i].cp='华数' ; break;
                           case 'BESTVOTT' : data[i].cp='百事通' ; break;
                           case 'ICNTV' : data[i].cp='未来电视' ; break;
                           case 'youpeng' : data[i].cp='南传' ; break;
                           case 'HNBB' : data[i].cp='芒果' ; break;
                           case 'CIBN' : data[i].cp='国广' ; break;
                           case 'YGYH' : data[i].cp='银河' ; break;
                       }
                         $('.mtable').append
                         (
                             "<tr class='trdata' id='"+(i+1)+"'>"+
                             "<td align='center'><label><input type='checkbox' class='chosetr' name='id' value="+data[i].id+" onclick='chose(this)'/></label></td>"+
                             "<td align='center'>"+data[i].id+"</td>"+
                             "<td align='center'>"+data[i].cp+"</td>"+
                             "<td align='center'>"+data[i].title+"</td>"+
                             "<td align='center'>"+data[i].language+"</td>"+
                             "<td align='center'>"+data[i].director+"</td>"+
                             "<td align='center'>"+data[i].actor+"</td>"+
                             "<td align='center'>"+data[i].cate+"</td>"+
                             "</tr>"
                         )

                   }
             }
         })
    })


    $('.btn').click(function()
    {
        $('.choseNum').hide();
        $('.btn').addClass('seachFlag');
        $('.pageGo').remove();
        $('.go-page').before(" <input class='pageGo' type='number' name='go'  placeholder='输入要去的页数点击go~~'/>");
        p=1;
        $('.nowpage').text("当前第"+p+"页");
        var keyword = $('#search').val();
        var cp = $('#cp').val();
        var language = $('#language').val();
        if(language == 1){
            language = "";
        }
        var type = $('#type').val();
        if(keyword.length==0 && cp==0 && language==0 && type==0){
            alert('您还没有选择任何搜索条件！');
            return false;
        }
//        alert(cp);
        $.ajax
        ({
            type:'post',
            url:"/wechat/meizi/seach/mid/<?php echo $_REQUEST['mid'] ;?>/keyword/"+keyword+"/cp/"+cp+"/language/"+language+"/type/"+type,
            success:function(data)
            {

                data = jQuery.parseJSON(data);
//                console.log(data);
                if(data.res.length == 0){
                    alert('暂时没有符合条件的数据');
                }else{
                    $('.trdata').remove();
                    seachpage = data.seachPage;
//                    console.log(seachpage);
                    $('.totalPage').text(seachpage);
                    data = data.res;
                    for(var i = 0 ; i<10 ; i++){
//                        data[i].cp = data[i].cp.substr(5);
                        switch( data[i].cp )
                        {
                            case '642001' : data[i].cp='华数' ; break;
                            case 'BESTVOTT' : data[i].cp='百事通' ; break;
                            case 'ICNTV' : data[i].cp='未来电视' ; break;
                            case 'youpeng' : data[i].cp='南传' ; break;
                            case 'HNBB' : data[i].cp='芒果' ; break;
                            case 'CIBN' : data[i].cp='国广' ; break;
                            case 'YGYH' : data[i].cp='银河' ; break;
                        }
                        $('.mtable').append
                        (
                            "<tr class='trdata' id='"+(i+1)+"'>"+
                            "<td align='center'><label><input type='checkbox'  class='chosetr' name='id' value="+data[i].id+" onclick='chose(this)'/> </label></td>"+
                            "<td align='center'>"+data[i].id+"</td>"+
                            "<td align='center'>"+data[i].cp+"</td>"+
                            "<td align='center'>"+data[i].title+"</td>"+
                            "<td align='center'>"+data[i].language+"</td>"+
                            "<td align='center'>"+data[i].director+"</td>"+
                            "<td align='center'>"+data[i].actor+"</td>"+
                            "<td align='center'>"+data[i].cate+"</td>"+
                            "</tr>"
                        )

                    }
                }
            }

        })
    })

    function seach(p)
    {
        var keyword = $('#search').val();
        var cp = $('#cp').val();
        /*if(cp>0){
            cp = '64200'+cp;
        }*/
        var language = $('#language').val();
        var type = $('#type').val();
        $('.choseNum').hide();
        $.ajax
        ({
            type:'post',
            url:"/wechat/meizi/seachPage/mid/<?php echo $_REQUEST['mid'] ;?>/keyword/"+keyword+"/cp/"+cp+"/language/"+language+"/type/"+type+"/p/"+p,
            success:function(data)
            {

                data = jQuery.parseJSON(data);
//                console.log(data);
                if(data.length == 0){
                    alert('暂时没有符合条件的数据');
                }else{
                    $('.trdata').remove();
                    $('.totalPage').text(data.seachPage);
                    for(var i = 0 ; i<data.length ; i++){
//                        data[i].cp = data[i].cp.substr(5);
                        switch( data[i].cp )
                        {
                            case '642001' : data[i].cp='华数' ; break;
                            case 'BESTVOTT' : data[i].cp='百事通' ; break;
                            case 'ICNTV' : data[i].cp='未来电视' ; break;
                            case 'youpeng' : data[i].cp='南传' ; break;
                            case 'HNBB' : data[i].cp='芒果' ; break;
                            case 'CIBN' : data[i].cp='国广' ; break;
                            case 'YGYH' : data[i].cp='银河' ; break;
                        }
                        $('.mtable').append
                        (
                            "<tr class='trdata' id='"+(i+1)+"'>"+
                            "<td align='center'><label><input type='checkbox' class='chosetr' name='id' value="+data[i].id+" onclick='chose(this)' /></label></td>"+
                            "<td align='center'>"+data[i].id+"</td>"+
                            "<td align='center'>"+data[i].cp+"</td>"+
                            "<td align='center'>"+data[i].title+"</td>"+
                            "<td align='center'>"+data[i].language+"</td>"+
                            "<td align='center'>"+data[i].director+"</td>"+
                            "<td align='center'>"+data[i].actor+"</td>"+
                            "<td align='center'>"+data[i].cate+"</td>"+
                            "</tr>"
                        )

                    }
                }
            }

        })
    }


    function chose(obj)
    {
        $(obj).parent().addClass('choseFlag');
//        var videoid = $(obj).val();
        if( $(obj).hasClass('choseFlag') == true){
            $(obj).removeClass('choseFlag');
        }
        var num = $('.choseFlag').length;
        $('.choseNum').show();
        $('.choseNum').text("已选择 "+num+" 条数据");

    }


    function add(obj)
    {
        var idData = new Array();
        var num = $('.choseFlag').length;
        for(var i = 0 ; i<num ; i++){
            idData[i] = $('.choseFlag').eq(i).children('input').val();
        }
        $.post('/wechat/meizi/add?mid=<?php echo $this->mid?>',{id:idData},function(data)
        {
//            console.log(data);
            if(data == 1){
                alert('添加成功！');
                location.reload();
            }
        },'json')

    }


    function cpChose(obj)
    {
//        alert($(obj).val());
        var cp = $(obj).val();
        if(cp == 'BESTVOTT'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (

                '<option  value="娱乐">娱乐</option>'+
                '<option  value="少儿">少儿</option>'+
                '<option  value="新闻">新闻</option>'+
                '<option  value="法治">法治</option>'+
                '<option  value="生活">生活</option>'+
                '<option  value="电影">电影</option>'+
                '<option  value="电影">电竞</option>'+
                '<option  value="纪实">纪实</option>'+
                '<option  value="综艺">综艺</option>'+
                '<option  value="财经">财经</option>'+
                '<option  value="音乐">音乐</option>'+
                '<option  value="高清">高清</option>'+
                '<option  value="体育">体育</option>'+
                '<option  value="电视剧">电视剧</option>'

            )

        }else if(cp == '642001'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (
                '<option  value="其他栏目">其他栏目</option>'+
                '<option  value="电视剧类节目">电视剧类节目</option>'+
                '<option  value="电影类节目">电影类节目</option>'+
                '<option  value="视频类节目">视频类节目</option>'+
                '<option  value="录制类节目">录制类节目</option>'+
                '<option value=" " \'=""> </option>'
            )
        }else if(cp == 'CIBN'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (


                '<option  value="生活">生活</option>'+
                '<option  value="电影">电影</option>'+
                '<option  value="综艺">综艺</option>'+
                '<option  value="电视剧">电视剧</option>'+
                '<option  value="动漫">动漫</option>'+
                '<option  value="记录专题">记录专题</option>'+
                '<option  value="其他栏目">其他栏目</option>'+
                '<option  value="音乐">音乐</option>'+
                '<option  value="新闻资讯">新闻资讯</option>'

            )
        }else if(cp == 'HNNB'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (
                '<option value=" 动漫 " \'=""> 动漫 </option>'+
                '<option value=" 电影 " \'=""> 电影 </option>'+
                '<option value=" 纪实 " \'=""> 纪实 </option>'+
                '<option value=" 综艺 " \'=""> 综艺 </option>'+
                '<option value=" 音乐 " \'=""> 音乐 </option>'

            )
        }else{
            $('#type').children('option').eq(0).siblings('option').remove();
        }
    }
   

    function cpChose1()
    {
        var vs = $('select  option:selected').val();
        if(vs == 'BESTVOTT'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (

                '<option  value="娱乐">娱乐</option>'+
                '<option  value="少儿">少儿</option>'+
                '<option  value="新闻">新闻</option>'+
                '<option  value="法治">法治</option>'+
                '<option  value="生活">生活</option>'+
                '<option  value="电影">电影</option>'+
                '<option  value="电影">电竞</option>'+
                '<option  value="纪实">纪实</option>'+
                '<option  value="综艺">综艺</option>'+
                '<option  value="财经">财经</option>'+
                '<option  value="音乐">音乐</option>'+
                '<option  value="高清">高清</option>'+
                '<option  value="体育">体育</option>'+
                '<option  value="电视剧">电视剧</option>'

            )

        }else if(vs == '642001'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (
                '<option  value="其他栏目">其他栏目</option>'+
                '<option  value="电视剧类节目">电视剧类节目</option>'+
                '<option  value="电影类节目">电影类节目</option>'+
                '<option  value="视频类节目">视频类节目</option>'+
                '<option  value="录制类节目">录制类节目</option>'+
                '<option value=" " \'=""> </option>'
            )
        }else if(vs == 'CIBN'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (


                '<option  value="生活">生活</option>'+
                '<option  value="电影">电影</option>'+
                '<option  value="综艺">综艺</option>'+
                '<option  value="电视剧">电视剧</option>'+
                '<option  value="动漫">动漫</option>'+
                '<option  value="记录专题">记录专题</option>'+
                '<option  value="其他栏目">其他栏目</option>'+
                '<option  value="音乐">音乐</option>'+
                '<option  value="新闻资讯">新闻资讯</option>'

            )
        }else if(vs == 'HNNB'){
            $('#type').children('option').eq(0).siblings('option').remove();
            $('#type').children('option').eq(0).after
            (
                '<option value=" 动漫 " \'=""> 动漫 </option>'+
                '<option value=" 电影 " \'=""> 电影 </option>'+
                '<option value=" 纪实 " \'=""> 纪实 </option>'+
                '<option value=" 综艺 " \'=""> 综艺 </option>'+
                '<option value=" 音乐 " \'=""> 音乐 </option>'

            )
        }else{
            $('#type').children('option').eq(0).siblings('option').remove();
        }
    }	
		
</script>
