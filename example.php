<?php

 define("__EXT__", 'html');      //路由 后缀名  如 html 或  php



require_once 'URL.class.php';

$url = new URL();
$url->parseUrl();