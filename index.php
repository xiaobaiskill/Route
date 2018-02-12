<?php

define('__EXT__', 'html');             	//路由 后缀名  如 html 或  php
define('URL_PATHINFO_DEPR', '-');      	//路由 目录符
define('BIND_MODULE', 'index');			//绑定默认 module 路由


require_once 'URL.class.php';
require_once 'Route.class.php';




function dd($arr)
{
	echo '<pre>';
	var_dump($arr);
}




/*$url = new URL();
dd($url->segments);
dd($_GET);*/



$route = new Route();

$path = $route->parseRoute($route->url->path);


$url = URL::getInstance();

$parsed_url = $url->parseRequestUri($path);

// dd($parsed_url);

$real_path = $url->parsePathStr($parsed_url['path']);

// dd($real_path);


$route->setRequest($real_path);



dd($_GET);




