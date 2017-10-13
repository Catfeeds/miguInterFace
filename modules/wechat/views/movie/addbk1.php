<form action="" method="post" enctype="multipart/form-data">
    <table class="mtable" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <input type="hidden" name="gid" value="<?php echo $_REQUEST['mid']?>">
            <td align="right">上传类型：</td>
            <td><select name="type" id="type" class="form-input w200">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($movie->type) && $movie->type ==1?'selected="selected"':''?> value="1">跳>转牌照方客户端</option>
                    <option <?php echo !empty($movie->type) && $movie->type ==3?'selected="selected"':''?> value="3">应>用商城</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">牌照方：</td>
            <td>
                <select name="cp" id="cp" class="form-input w200">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==1?'selected="selected"':''?> value="1">华数客>户端</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==2?'selected="selected"':''?> value="2">百视通>客户端</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==3?'selected="selected"':''?> value="3">未来电>视</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==4?'selected="selected"':''?> value="4">南传</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==7?'selected="selected"':''?> value="7">银河</option>
</select>
            </td>
        </tr>
        <tr>
            <td align="right">片名：</td>
            <td><input type="text" name="title" id="title" class="form-input w400" value="<?php echo !empty($movie->title)?$movie->title:''?>"></td>
        </tr>
        <tr>
            <td align="right">分类：</td>
            <td>
                <select name="classify" id="classify" class="form-input w200" onchange="aa()">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="电影"?'selected="selected"':''?> value="电影">电影</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="电视剧"?'selected="selected"':''?> value="电视剧">电视剧</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="综艺"?'selected="selected"':''?> value="综艺">综艺</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="少儿"?'selected="selected"':''?> value="少儿">少儿</option>
               <option <?php echo !empty($movie->classify) && $movie->classify =="甘肃蓝光"?'selected="selected"':''?> value="甘肃蓝光">甘肃蓝光</option>
               <option <?php echo !empty($movie->classify) && $movie->classify =="甘肃电影"?'selected="selected"':''?> value="甘肃电影">甘肃电影</option>
               <option <?php echo !empty($movie->classify) && $movie->classify =="甘肃电视剧"?'selected="selected"':''?> value="甘肃电视剧">甘肃电视剧</option>
               <option <?php echo !empty($movie->classify) && $movie->classify =="少儿多集"?'selected="selected"':''?> value="少儿多集">少儿多集</option>
</select>
            </td>
        </tr>
        <tr style="display:none" class="show adds">
                <td align="right">剧集数量：</td>
                <td><input type="text" name="num" class="num form-input w400" value="<?php if(count($episode)==1){
                        echo '1';
                     }else{
                        echo count($episode);
                    }?>"></td>
            </tr>
        <?php if(count($episode)>1){foreach($episode as $k=>$v){?>
        <tr style="display:none" class="show addr">
            <td align="right">选集名称:</td>
            <td><input type="text" name="mname[]" class="mname[] form-input w400" value="<?php echo !empty($v->mname)?$v->mname:''?>"></td>
        </tr>
        <tr style="display:none" class="show addrs">
            <td align="right">选集url:</td>
            <td><input type="text" name="url[]" class="url[] form-input w400" value="<?php echo !empty($v->url)?$v->url:''?>"></td>
        </tr>
        <?php }}else{?>
            <tr style="display:none" class="show addr">
                <td align="right">选集名称:</td>
                <td><input type="text" name="mname[]" class="mname[] form-input w400" value="<?php echo !empty($episode->mname)?$episode->mname:''?>"></td>
            </tr>
            <tr style="display:none" class="show addrs">

