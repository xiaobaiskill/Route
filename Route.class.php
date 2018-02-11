<?php
class Route
{
	public $segments;
	public $module = BIND_MODULE;
	public $class  = 'index';
	public $fun    = 'index';
	public function __construct()
	{
		$this->routes = include_once 'Route.config.php';
	}

	//解析路由
	public function parseRoute($path)
	{
	}

	//设置模块
	public function setModule()
	{
	}

	//设置class
	public function setClass()
	{
	}

	//设置调用方法
	public function setFun()
	{
	}

	//设置 转递参数
	public function setArgv()
	{
	}
}
