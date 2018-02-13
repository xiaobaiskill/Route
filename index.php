<?php

define('__EXT__', 'html');             	//路由 后缀名  如 html 或  php
define('URL_PATHINFO_DEPR', '/');      	//路由 目录符
define('BIND_MODULE', 'Home');			//绑定默认 module 路由
define('BIND_CLASS', 'Index');			//绑定默认 class 路由


require_once 'URL.class.php';
require_once 'Route.class.php';




function dd($arr)
{
	echo '<pre>';
	var_dump($arr);
}


$route = new Route();

$path = $route->parseRoute($route->url->path);

$url = URL::getInstance();

$parsed_url = $url->parseRequestUri($path);

$real_path = $url->parsePathStr($parsed_url['path'],'/');

$route->setRequest($real_path);

dd($route->module);
dd($route->class);
dd($route->method);
dd($route->argvs);
dd($_GET);



echo '------------------我是和平的分割线----------------------'.'<b>';

dd($url->segments);



