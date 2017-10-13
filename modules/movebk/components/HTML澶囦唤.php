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



    public static function move($mvui,$xiaotu){
        $html = '
			<style type="text/css">
				.ui-a{background-color:#898989;height:320px;text-align: center;width:175px;}
				#b-2{background-color:#898989;height:320px;text-align: center;width:175px;}
				#h-8,#h-9,#h-10{height:100px;background-color:#898989;text-align: center;width: 175px;}
				#h-9,#h-10{margin-top:10px;}
				.box{height: 320px;-moz-columns:150px;-webkit-columns:100px;columns:100px;-moz-column-gap:10px;-webkit-column-gap:40px;column-gap:40px;}
				.box div{}
                .box div img{width: 175px;height:105px;display:block;}
                .box div:nth-child(3n) img{margin-bottom: 0px;margin-top: 9px;}
                .box div:nth-child(3n-1) img{margin-bottom: 0px;margin-top: 9px;}
                .box div:nth-child(3n-2) img{margin-top:0px;}
                .ui-s{text-align: center;width:175px;background-color: #898989;height: 100px;}
                .ui-s a{position: absolute;top:0;left:0;background-color:#898989;padding:5px 10px;}
                .ui-s{position: relative;}
			</style>
		';
       // print_r($mvui);die();
        $html .= '<div class="modules" style="margin-top:20px;width: 100%">';
        //print_r($mvui);
        $html .= '<div>';
        foreach($mvui as $key => $val){

        $html .='<div class="fl model1 mr10">
				<div id="'.$val[0]['position'].'" class="ui-a">';
        $arr = MvUiManager::getKey($val[0]['position'],$mvui);
        $html .='<ul>';
        $html .= empty($arr)?'':'<li><img src="'.$arr[0]['pic'].'" width="175px" height="320px">';
        $html .= '<a href="javascript:void(0)" style="" pos="'.$val[0]['position'].'">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</li></ul>';
		$html .= '</div>
			</div>';
        }

        foreach($mvui as $key=>$val){
            $shuzu=$key;
        }
        if(!empty($shuzu)){
            $barr=explode('-',$shuzu);
            $b=$barr[1]+1;
        }else{
            $b=1;
        }

        $html .='<div class="fl model1 mr10">
				<div id=b-'.$b.' class="ui-a">';
        $arr = MvUiManager::getKey("b-$b",$mvui);
        $html .='<ul>';
        $html .= empty($arr)?'':'<li><img src="'.$arr[0]['pic'].'" width="175px" height="320px">';
        $html .= '<a href="javascript:void(0)" style="" pos=b-'.$b.'>'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</li></ul>';
        $html .= '</div>
			</div>';
        $html .= '</div>';

        //x小图
        $html .='<div  class="box">';
        foreach($xiaotu as $key => $val) {
            $html .= '<div id="'.$val[0]['position'].'" class="ui-s">';
            $arr = MvUiManager::getKey($val[0]['position'],$xiaotu);
            $html .=empty($arr)?'': '<img src="'.$arr[0]['pic'].'"  alt="" width="175px" height="100px">';
            $html .= '<a href="javascript:void(0)" style="" pos="'.$val[0]['position'].'">'.(empty($arr)?'点击上传':'点击修改').'</a>';
            $html .= '</div>';
        }

       // print_r($xiaotu);

        foreach($xiaotu as $k=>$v){
            $shuzus=$k;
        }
     //   print_r($shuzus);
        if(!empty($shuzus)){
            $barrs=explode('-',$shuzus);
            $s=$barrs[1]+1;
        }else{
            $s=1;
        }
        //echo $s;

        $html .= '<div id=s-'.$s.'  class="ui-s" style="margin-top:10px">';
        $arr = MvUiManager::getKey("s-$s",$xiaotu);
        $html .=empty($arr)?'': '<img src="'.$arr[0]['pic'].'"  alt=""  width="175px" height="100px">';
        $html .= '<a href="javascript:void(0)" style="" pos=s-'.$s.'>'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html .= '</div>';


        $html .='</div>';


        return $html;
    }



    public static function moves($mvui){
        $html = '<div class="modules" style="clear: both">';
        // foreach(){
        $html.= ' <div id="b-1" style="width: 175px;height: 325px; border: solid 1px #ff0000; margin-top: 50px;margin-left: 50px;clear: both;overflow: hidden;float: left">';
        $arr = MvUiManager::getKey('b-1',$mvui);
        //print_r($arr);die();
        $html.=empty($arr)?'':'<img src="'.$arr['bigImg'].'" width="100%" height="100%" />';
        $html.= '<a href="javascript:void(0)" style="" pos="b-1">'.(empty($arr)?'点击上传':'点击修改').'</a>';
        $html.='</div>';
        // }
        $html.='<div style="width: 175px;height: 325px; border: solid 1px #ff0000; margin-top: 50px;margin-left: 10px;float: left"">
                    <img src="../../file/fdb5d67b3b94918621da02528a3e223f.png" width="100%" height="100%" />
                </div>
                <div style="width: 175px;height: 325px; border: solid 1px #ff0000; margin-top: 50px;margin-left: 10px;float: left">
                    <div style="width: 175px;height: 100px; border: solid 1px #ff0000;float: left">
                        <img src="../../file/c5ee19707f08853705cf01d35df28cda.png" width="100%" height="100%" />
                    </div>
                    <div style="width: 175px;height: 100px; border: solid 1px #ff0000; margin-top:10px;float: left">
                        <img src="../../file/c5ee19707f08853705cf01d35df28cda.png" width="100%" height="100%" />
                    </div>
                    <div style="width: 175px;height: 100px; border: solid 1px #ff0000; margin-top:10px;float: left">
                        <img src="../../file/c5ee19707f08853705cf01d35df28cda.png" width="100%" height="100%" />
                    </div>
                </div>

            </div>';
        return $html;
    }





}