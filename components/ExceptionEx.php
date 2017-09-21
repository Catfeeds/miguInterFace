<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/4 0004
 * Time: 19:15
 */
class ExceptionEx extends Exception{
	public function __construct($errorMsg){
		parent::__construct($errorMsg);
	}
}