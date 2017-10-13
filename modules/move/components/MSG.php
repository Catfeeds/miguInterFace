<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/12 0012
 * Time: 13:22
 */
class MSG
{
	const ADMIN_STATUS_SUCCESS = 1; // 正常使用
	const ADMIN_STATUS_OFF     = 2; // 账号被封禁
	const ADMIN_STATUS_DEL     = 3; // 账号被删除
	const ADMIN_STATUS_AUDITING= 4; // 账号审核中

	public static $_status = array(
		self::ADMIN_STATUS_AUDITING => '审核中',
		self::ADMIN_STATUS_SUCCESS  => '正常',
		self::ADMIN_STATUS_OFF      => '已禁用',
		self::ADMIN_STATUS_DEL      => '已删除'
	);

	const OP_LOG_ADD = '用户{username}于{datetime}添加了{type}[{title}]';
	const OP_LOG_EDIT= '用户{username}于{datetime}修改了{type}[{title}]';
	const OP_LOG_DEL = '用户{username}于{datetime}删除了{type}[{title}]';
	const OP_LOG_UN  = '用户{username}于{datetime}执行了未知操作';
	const OP_LOG_LOGIN = '用户{username}于{datetime}登陆了后台';
	const OP_LOG_LOGOUT = '用户{username}于{datetime}退出了后台';


	const MYSQL_EDIT_ADD = '添加';
	const MYSQL_EDIT_EDIT= '编辑';
	const MYSQL_EDIT_DEL = '删除';
	const MYSQL_EDIT_LOGIN = '登陆';
	const MYSQL_EDIT_LOGOUT = '退出';
}