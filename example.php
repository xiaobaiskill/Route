<?php

 define('__EXT__', 'html');             //路由 后缀名  如 html 或  php
 define('URL_PATHINFO_DEPR', '/');      //路由 目录符
 define('BIND_MODULE', 'index');		//默认 module 路由



function dd($arr)
{
	echo '<pre>';
	var_dump($arr);
}


require_once 'URL.class.php';
require_once 'Route.class.php';

$url = new URL();
dd($url->segments);
dd($_GET);



$route = new Route();
dd($route->routes);
