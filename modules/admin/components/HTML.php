<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/20 0020
 * Time: 9:49
 */
class HTML
{
    public static function operating($val){
        $html = '
		<table class="mtable mt10" align="center" cellpadding="10" cellspacing="0" width="99%">
			<tr>
				<td align="right" width="100">昵称：</td>
				<td>'.$val['nickname'].'</td>
			</tr>
			<tr>
				<td align="right">用户组：</td>
				<td>'.$val['name'].'</td>
			</tr>
			<tr>
				<td align="right">操作：</td>
				<td>'.$val['edit'].'</td>
			</tr>
			<tr>
				<td align="right">操作内容：</td>
				<td>'.$val['content'].'</td>
			</tr>
			<tr>
				<td align="right">操作时间：</td>
				<td>'.date('Y-m-d H:i:s',$val['oTime']).'</td>
			</tr>
		</table>
		';
        return $html;
    }

    public static function yingshi($ui){
        $html = '
			<style type="text/css">
				#h-1,#h-2{width:75px;height:150px;background-color:#898989;text-align: center;}
				.h-4{height:150px;}
				#h-2{margin-top:10px;}
				#h-3{background-color:#898989;width:150px;height:310px;text-align:center;}
				#h-4{height:150px;background-color:#898989;text-align: center;width:310px;}
				#h-5,#h-6{width:150px;height:150px;background-color:#898989;text-align: center;}
				#h-5{margin-right:10px;}
				#h-7{background-color:#898989;height:310px;text-align: center;width:150px;}
				#h-8,#h-9{height:150px;background-color:#898989;text-align: center;width: 150px;}
				#h-9{margin-top:10px;}
			</style>
		';
        $html .= '<div class="modules" style="margin-top:20px;">
			<div class="fl model1 mr10">
				<div id="h-1" class="ui-a">';
        $arr = UiManager::getKey('h-1',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .='</div>
				<div id="h-2" class="ui-a">';
        $arr = UiManager::getKey('h-2',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '	</div>
			</div>
			<div class="fl model2 mr10">
				<div id="h-3" class="ui-a">';
        $arr = UiManager::getKey('h-3',$ui);

        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a>';

		$html .='</div>
			</div>
			<div class="fl model3 mr10">
				<div class="h-4">
					<div id="h-4" class="ui-a">';
        $arr = UiManager::getKey('h-4',$ui);

        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';

		$html.='</div>
				</div>
				<div class="h-4 mt6">
					<div class="fl ui-a" id="h-5">';
        $arr = UiManager::getKey('h-5',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>
					</div>
					<div class="fl ui-a" id="h-6">';
        $arr = UiManager::getKey('h-6',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>
					</div>
				</div>
			</div>
			<div class="fl model4 mr10">
				<div id="h-7" class="ui-a">';
        $arr = UiManager::getKey('h-7',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
		$html.='</div>
			</div>
			<div class="fl model5">
				<div id="h-8" class="ui-a">';
        $arr = UiManager::getKey('h-8',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-8">'.(empty($arr)?'点击上传':'点击修改').'</a>
				</div>
				<div id="h-9" class="ui-a">';
        $arr = UiManager::getKey('h-9',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-9">'.(empty($arr)?'点击上传':'点击修改').'</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>';
        return $html;
    }

    public static function dianshi($ui){
        $html = '
			<style type="text/css">
				#h-1{width:75px;height:150px;background-color:#898989;}
				#h-2{width:150px;height:150px;background-color:#898989;}
				#h-3{width:235px;height:150px;margin-top:10px;background-color:#898989;}
				#h-4,#h-8{width:150px;height:310px;background-color:#898989;}
				#h-5{width:310px;height:150px;background-color:#898989;}
				#h-6,#h-7{background-color:#898989;width:150px;height:150px;}
			</style>
		';
        $html .= '<div class="modules" style="margin-top:20px;">
					<div class="fl mr10">
						<div>
							<div id="h-1" class="fl mr10 ui-a">';
        $arr = UiManager::getKey('h-1',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div><div id="h-2" class="fl ui-a">';

        $arr = UiManager::getKey('h-2',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div class="clear"></div>
						</div>
						<div id="h-3" class=" ui-a">';

        $arr = UiManager::getKey('h-3',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					</div>
					<div class="fl mr10">
						<div id="h-4" class=" ui-a">';

        $arr = UiManager::getKey('h-4',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					</div>
					<div class="fl mr10">
						<div id="h-5" class=" ui-a">';

        $arr = UiManager::getKey('h-5',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
						<div class="mt6">
							<div id="h-6" class="fl mr10 ui-a">';
        $arr = UiManager::getKey('h-6',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div id="h-7" class="fl ui-a">';

        $arr = UiManager::getKey('h-7',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="fl">
						<div id="h-8" class=" ui-a">';

        $arr = UiManager::getKey('h-8',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-8">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					</div>
					<div class="clear"></div>
				</div>';
        return $html;
    }

    public static function tuijian($ui){
        $html = '
			<style type="text/css">
				#h-1{width:75px;height:150px;background-color:#898989;overflow:hidden;position:relative}
				#h-2{width:150px;height:150px;background-color:#898989;overflow:hidden;position:relative}
				#h-3{width:235px;height:150px;margin-top:10px;background-color:#898989;overflow:hidden;position:relative}
				#h-4,#h-8{width:150px;height:310px;background-color:#898989;overflow:hidden;position:relative}
				#h-7{width:310px;height:150px;background-color:#898989;overflow:hidden;position:relative;}
				#h-5,#h-6{background-color:#898989;width:150px;height:150px;overflow:hidden;position:relative}
			</style>
		';
        $html .= '<div class="modules" style="margin-top:20px;">
					<div class="fl mr10">
						<div>
							<div id="h-1" class="fl mr10 ui-a">';
        $arr = UiManager::getKey('h-1',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div><div id="h-2" class="fl ui-a">';

        $arr = UiManager::getKey('h-2',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div class="clear"></div>
						</div>
						<div id="h-3" class=" ui-a">';

        $arr = UiManager::getKey('h-3',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					</div>
					<div class="fl mr10">
						<div id="h-4" class=" ui-a">';

        $arr = UiManager::getKey('h-4',$ui);
        $html .='<ul>';
        $html .= empty($arr)?'':'<li><img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .='</li></ul>';
        $html .= '</div>
					</div>
					<div class="fl mr10">
					<div class="">

							<div id="h-5" class="fl mr10 ui-a">';
        $arr = UiManager::getKey('h-5',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div id="h-6" class="fl ui-a">';

        $arr = UiManager::getKey('h-6',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div class="clear"></div>
						</div>
						<div id="h-7" class="mt6 ui-a" >';
        $arr = UiManager::getKey('h-7',$ui);
        //if(count($arr) == 1){
        	$html .='<ul>';
			$html .= empty($arr)?'':'<li><img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
			$html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
			$html .='</li></ul>';
		/*}else{
			$html .='<ul>';
			foreach($arr as $key=>$val){
				$html .='<li><img src="'.$val['bigImg'].'" width="100%" height="100%" >';
				$html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($val)?'点击上传':'点击修改').'</a>';
			}
			$html .='</li></ul>';
		}*/
        $html .= '</div>
       
					</div>
					<div class="fl">
						<div id="h-8" class=" ui-a">';

        $arr = UiManager::getKey('h-8',$ui);
        $html .='<ul>';
        $html .= empty($arr)?'':'<li><img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-8">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .='</li></ul>';
        $html .= '</div>
					</div>
					<div class="clear"></div>
				</div>';
        return $html;
    }

    public static function shaoer($ui){
        $html = '
			<style type="text/css">
				#h-1{width:75px;height:150px;background-color:#898989;}
				#h-2{width:150px;height:150px;background-color:#898989;}
				#h-3{width:235px;height:150px;margin-top:10px;background-color:#898989;}
				#h-4{width:150px;height:310px;background-color:#898989;}
				#h-5{width:310px;height:150px;background-color:#898989;}
				#h-6,#h-7,#h-8,#h-9{background-color:#898989;width:150px;height:150px;}
			</style>
		';
        $html .= '<div class="modules" style="margin-top:20px;">
					<div class="fl mr10">
						<div>
							<div id="h-1" class="fl mr10 ui-a">';
        $arr = UiManager::getKey('h-1',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div><div id="h-2" class="fl ui-a">';

        $arr = UiManager::getKey('h-2',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div class="clear"></div>
						</div>
						<div id="h-3" class=" ui-a">';

        $arr = UiManager::getKey('h-3',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					</div>
					<div class="fl mr10">
						<div id="h-4" class=" ui-a">';

        $arr = UiManager::getKey('h-4',$ui);
        $html.='<ul>';
        $html .= empty($arr)?'':'<li><img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html.='</li></ul>';
        $html .= '</div>
					</div>
					<div class="fl mr10">
						<div id="h-5" class="ui-a">';

        $arr = UiManager::getKey('h-5',$ui);
        $html.='<ul>';
        $html .= empty($arr)?'':'<li><img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .='</li></ul>';
        $html .= '</div>
					<div class="mt6">
					<div id="h-6" class="fl mr10 ui-a">';
        $arr = UiManager::getKey('h-6',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div id="h-7" class="fl ui-a">';

        $arr = UiManager::getKey('h-7',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="fl">
						<div id="h-8" class=" ui-a">';

        $arr = UiManager::getKey('h-8',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-8">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					<div id="h-9" class="mt6 ui-a">';

        $arr = UiManager::getKey('h-9',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-9">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					</div>
					<div class="clear"></div>
				</div>';
        return $html;
    }

    public static function yingyong($ui){
        $html = '
			<style type="text/css">
				#h-1,#h-2{background-color:#898989;width:75px;height:150px;}
				#h-3{height:80px;width:100px;background-color:#898989;}
				#h-4{height:75px;width:100px;background-color:#898989; margin-top: 10px;}
				#h-5{height:75px;width:100px;background-color:#898989; margin-top: 10px;}
				#h-6{width:430px;height:100px;background-color: #898989;}
				#h-a{width:430px;height:100px;}
                #h-7,#h-8,#h-9,#h-10,#h-11,#h-12,#h-13,#h-14{width: 100px;height: 95px;background-color:#898989;}
				#h-15{width:235px;height:150px;background-color:#898989;}
				#h-16,#h-17{width:150px;height:150px;background-color:#898989;}
				#h-17{width: 75px;}
				#uu{position: absolute;top: 68px;left: 0;background-color: #898989;padding: 5px 10px;}
			</style>
		';
        $html .= '
			<div class="modules" style="margin-top:20px;">
				<div class="fl mr10">
					<div id="h-1" class="ui-a">';
        $arr = UiManager::getKey('h-1',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					<div id="h-2" class="mt6 ui-a">';

        $arr = UiManager::getKey('h-2',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
				</div>
				<div class="fl mr10">
				    <div style="height:20px; margin-bottom: 10px;" class="ui-a">我的应用</div>
					<div id="h-3" class="ui-a">';

        $arr = UiManager::getKey('h-3',$ui);
        //$html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<img src="../../file/myapp_im01.png" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-4" class="ui-a">';

        $arr = UiManager::getKey('h-4',$ui);
        $html .= '<img src="../../file/myapp_im02.png" width="100%" height="100%">';
        //$html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-5" class="ui-a">';

        $arr = UiManager::getKey('h-5',$ui);
        $html .= '<img src="../../file/myapp_im03.png" width="100%" height="100%">';
        //$html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        //$html .= '<a href="javascript:void(0)" id="uu" style="">'.('更多').'</a>';
        $html .= '</div>
                    <div style="height:20px; margin-top: 10px;" class="ui-a">更多</div>
				</div>
				<div class="fl mr10">
					<div id="h-6" class="ui-a">';

        $arr = UiManager::getKey('h-6',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                <div id="h-a">
					<div id="h-7" class="mt6 ui-a">';

        $arr = UiManager::getKey('h-7',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-8" class="mt6 ui-a cc">';

        $arr = UiManager::getKey('h-8',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-8">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-9" class="mt6 ui-a cc">';

        $arr = UiManager::getKey('h-9',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-9">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-10" class="mt6 ui-a cc">';

        $arr = UiManager::getKey('h-10',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-10">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                </div>
                <div id="h-a">
                    <div id="h-11" class="mt7 ui-b">';

        $arr = UiManager::getKey('h-11',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-11">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                <div id="h-12" class="mt7 ui-b cc">';

        $arr = UiManager::getKey('h-12',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-12">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-13" class="mt7 ui-b cc">';

        $arr = UiManager::getKey('h-13',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-13">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
                    <div id="h-14" class="mt7 ui-b cc">';

        $arr = UiManager::getKey('h-14',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        $html .= '<a href="javascript:void(0)" style="" pos="h-14">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
				</div>
				</div>
				<div class="fl">
					<div id="h-15" class="ui-a">';

        $arr = UiManager::getKey('h-15',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-15">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
					<div class="mt6">
						<div id="h-16" class="fl mr10 ui-a">';

        $arr = UiManager::getKey('h-16',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-16">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
						<div id="h-17" class="fl ui-a">';

        $arr = UiManager::getKey('h-17',$ui);
        $html .= empty($arr)?'':'<img src="'.$arr[0]['bigImg'].'" width="100%" height="100%">';
        //$html .= '<a href="javascript:void(0)" style="" pos="h-17">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		';
        return $html;
    }

public static function henan($henan){
   $html='<style type="text/css">
            #h-1{width:210px;height:200px;background-color:#898989;}
            #h-2{width:210px;height:150px;margin-top:10px;background-color:#898989;}
            #h-3{width:392px;height:200px;background-color:#898989;margin-left: 20px;}
            #h-4,#h-5,#h-7{background-color:#898989;width:210px;height:150px;}
            #h-6{background-color:#898989;width:210px;height:200px;}
            #h-7{ margin-top: 10px;}
        </style>';

   $html .='     <div class="modules" style="margin-top:20px;">
            <div class="fl mr10">
                <div id="h-1" class=" ui-a">';
        $arr = UiHenanManager::getKey('h-1',$henan);
       // print_r($arr);
   $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
   $html .= '</div>
        <div class="clear"></div>
        <div id="h-2" class=" ui-a">';
        $arr = UiHenanManager::getKey('h-2',$henan);

   $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
   $html .= ' </div>
        </div>
        <div class="fl mr10">
        <div id="h-3" class="ui-a">';
        $arr = UiHenanManager::getKey('h-3',$henan);

   $html .= empty($arr)?'':'<li><img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a></li>';
   $html .= '  </div>
            <div class="mt6">
                <div id="h-4" class="fl mr10 ui-a">';
            $arr = UiHenanManager::getKey('h-4',$henan);

   $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';
   $html .= '  </div>
                <div id="h-5" class="fl ui-a">';
             $arr = UiHenanManager::getKey('h-5',$henan);
   $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>';
   $html .= '  </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="fl">
            <div id="h-6" class=" ui-a">';
            $arr = UiHenanManager::getKey('h-6',$henan);
   $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>';
   $html .= '  </div>
            <div id="h-7" class="mt6 ui-a">';
            $arr = UiHenanManager::getKey('h-7',$henan);
   $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
   $html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
   $html .= '</div>
        </div>
        <div class="clear"></div>
        </div>';
        return $html;
   }
   
public static function nanchuan($nanchuan){
    $html='<style type="text/css">
            #h-1{width:210px;height:200px;background-color:#898989;}
            #h-2{width:210px;height:150px;margin-top:10px;background-color:#898989;}
            #h-3{width:392px;height:200px;background-color:#898989;margin-left: 20px;}
            #h-4,#h-5,#h-7{background-color:#898989;width:210px;height:150px;}
            #h-6{background-color:#898989;width:210px;height:200px;}
            #h-7{ margin-top: 10px;}
        </style>';

    $html .='     <div class="modules" style="margin-top:20px;">
            <div class="fl mr10">
                <div id="h-1" class=" ui-a">';
    $arr = UiHenanManager::getKey('h-1',$nanchuan);
    // print_r($arr);
    $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
    $html .= '</div>
        <div class="clear"></div>
        <div id="h-2" class=" ui-a">';
    $arr = UiHenanManager::getKey('h-2',$nanchuan);

    $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-2">'.(empty($arr)?'点击上传':'点击修改').'</a>';
    $html .= ' </div>
        </div>
        <div class="fl mr10">
        <div id="h-3" class="ui-a">';
    $arr = UiHenanManager::getKey('h-3',$nanchuan);

    $html .= empty($arr)?'':'<li><img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-3">'.(empty($arr)?'点击上传':'点击修改').'</a></li>';
    $html .= '  </div>
            <div class="mt6">
                <div id="h-4" class="fl mr10 ui-a">';
    $arr = UiHenanManager::getKey('h-4',$nanchuan);

    $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-4">'.(empty($arr)?'点击上传':'点击修改').'</a>';
    $html .= '  </div>
                <div id="h-5" class="fl ui-a">';
    $arr = UiHenanManager::getKey('h-5',$nanchuan);
    $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-5">'.(empty($arr)?'点击上传':'点击修改').'</a>';
    $html .= '  </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="fl">
            <div id="h-6" class=" ui-a">';
    $arr = UiHenanManager::getKey('h-6',$nanchuan);
    $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-6">'.(empty($arr)?'点击上传':'点击修改').'</a>';
    $html .= '  </div>
            <div id="h-7" class="mt6 ui-a">';
    $arr = UiHenanManager::getKey('h-7',$nanchuan);
    $html .= empty($arr)?'':'<img src="'.$arr[0]['pic'].'" width="100%" height="100%">';
    $html .= '<a href="javascript:void(0)" style="" pos="h-7">'.(empty($arr)?'点击上传':'点击修改').'</a>';
    $html .= '</div>
        </div>
        <div class="clear"></div>
        </div>';
    return $html;
}

}
