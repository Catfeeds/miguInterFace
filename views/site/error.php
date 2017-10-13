<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);?>
<style type="text/css">
	#h1{
		width:100%;margin:0 auto;text-align:center;vertical-align: middle;background-color: #c0e7ee;
		/*background-image: -webkit-radial-gradient(200px 200px at 200px 150px,hsla(120,50%,50%,.9),hsla(360,60%,60%,.9));*/
		/*background-image: radial-gradient(100% 100% at 50%  50%,hsla(1,1%,1%,.1),hsla(360,50%,50%,.1));*/
		/*background-image: -webkit-radial-gradient(circle at center,rgb(255, 255, 255),rgb(192, 231, 238));*/
		/*background-image: radial-gradient(circle at center, rgb(255, 255, 255),rgb(192, 231, 238));*/
	}
</style>
<?php
if($code == 404){?>
	<div id="h1">
		<img src="/images/404.png" style="vertical-align: middle;">
	</div>
<?php
}
?>
<!--<h2>Error --><?php //echo $code; ?><!--</h2>-->
<!---->
<!--<div class="error">-->
<?php //echo CHtml::encode($message); ?>
<!--</div>-->
<script type="text/javascript">
	$(function(){
		var height = $("body").height();
		$('#h1').css('height',height+'px');
		$('#h1').css('line-height',height+'px');
	});
</script>