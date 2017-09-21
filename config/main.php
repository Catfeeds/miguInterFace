<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once dirname(__FILE__).'/config.php';
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.manager.*',
		'application.components.*',
		'application.components.log.*',
		'application.components.other.*',
		'application.components.other.ttf.*',
        'application.extensions.PHPExcel.PHPExcel',
    ),

	'modules'=>array(
		'admin'=>array(),
		'mobile'=>array(),
		'api'=>array(),
        'weixin'=>array(),
        'wechat'=>array(),
		'wx'=>array(),
        'move'=>array(),
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'yidong',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
//        'session'=>array(
//            'autoStart'=>true,
//            'sessionName'=>'Site Access',
//            'cookieMode'=>'only',
//          //  'savePath'=>'/path/to/new/directory',
//        ),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'returnUrl' =>'/admin/default/index'
//            'returnUrl' =>'/wechat/test/index'
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'urlSuffix' => '.html',
			'caseSensitive' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<id:\d+>'=>'<modules>/<controller>/<id>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<modules>/<controller>/<action>/view',
			),
		),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		'db'=> include dirname(__FILE__).'/db.php',
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'cache'=>array(
			'class'=>'CMemCache',
			'servers'=>array(
				array(
					'host'=>'172.17.91.192',
					'port'=>11211,
					'weight'=>60,
				),
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
