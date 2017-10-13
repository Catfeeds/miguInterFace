<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<style type="text/css">
    *{padding: 0;margin: 0;}
    #head{width: 100%;background-color: #C3D69B;}
    #head,#top,#button{font-size: 20px;}
    #center{height: 250px; border: 2px #385D8A solid;border-radius: 30px;width: 80%;}
    #top,#center,#botton{margin: 5% 10% 0 10%;}
    #head,#botton{height:70px;text-align: center;line-height: 70px;}
    #button{width: 55%;height: 40px; background-color: #0070C0; color: #FFFFFF; border-radius: 8px; font-size: 20px;}
    #text{margin: 5% 5% 0 5%;width: 89%;height: 180px;BORDER-BOTTOM-STYLE: none; BORDER-LEFT-STYLE: none; BORDER-RIGHT-STYLE: none; BORDER-TOP-STYLE: none;resize : none;}
</style>
<body>
<form action="./add" method="post">
    <div id="head">
        <span>云消息</span>
    </div>
    <div id="body">
        <p id="top">请输入信息，本信息将发送至您绑定的设备上</p>
        <p id="center">
            <textarea id="text" name="info"></textarea>
        </p>
        <p id="botton">
            <input type="submit" id="button" onclick="aa()" value="发送">
        </p>

        <input type="hidden" name="name" value="<?php echo !empty($list[0]['number'])?$list[0]['number']:'' ?>">
        <input type="hidden" name="stbid" value="<?php echo !empty($list[0]['stbid'])?$list[0]['stbid']:'' ?>">

    </div>
</form>
<script type="text/javascript">
    function aa(){
        alert("发送成功");
    }
</script>
</body>
</html>