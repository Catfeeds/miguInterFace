<?php
/**
 * Created by PhpStorm.
 * User: nackman
 * Date: 14-5-27
 * Time: 下午2:39
 */
$_user              = DB_NAME;
$_password          = DB_PASS;
$_connectionString  = DB_STR;
return array(
	'class'=>'application.extensions.CDbConnectionExt',//扩展路径
	'connectionString' =>$_connectionString,//主数据库 写
	'enableProfiling' =>false, //这个是用来记录日志的，会记录每一条语句执行的时间
	'enableParamLogging' => false,//true表示包括sql语句的参数在内的信息都会记录到日志里，非常详细
	'schemaCachingDuration'=>3600*24*30, // time in seconds
	'schemaCacheID' => 'cache', //使用的缓存组件/

	////不需要缓存的表名数组
	'schemaCachingExclude' => array(),

	//查询缓存配置
	'queryCachingDuration' => 30,//缓存时间
	'queryCachingDependency' => null, //缓存依赖
	'queryCachingCount' => 0, //第一次使用这条sql语句后同样的多少条sql语句需要缓存
	'queryCacheID' => 'cache', //使用的缓存组件

	'emulatePrepare' => true,
	'username' => $_user,
	'password' => $_password,
	'charset' => 'utf8',
	'tablePrefix' => 'yd_', //表前缀
	'enableSlave'=>false,//从数据库启用

	'slavesWrite'=>true,//紧急情况 主数据库无法连接 启用从数据库 写功能
	'masterRead'=>true,//紧急情况 从数据库无法连接 启用主数据库 读功能
	/*'slaves'=>array(//从数据库
		array(   //slave1
			'connectionString'=>'mysql:host=172.17.92.184;port=3306;dbname=gsmobile',
			'emulatePrepare' => true,
			'username'=>$_user,
			'password'=>$_password,
			'charset' => 'utf8',
			'tablePrefix' => 'yd_', //表前缀
		),
		array(   //slave1
                        'connectionString'=>'mysql:host=172.17.92.184;port=3306;dbname=gsmobile',
                        'emulatePrepare' => true,
                        'username'=>$_user,
                        'password'=>$_password,
                        'charset' => 'utf8',
                        'tablePrefix' => 'yd_', //表前缀
                ),
	),*/
);

