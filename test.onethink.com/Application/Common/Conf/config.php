<?php
return array(
	
	'URL_ROUTER_ON'   => true, 
	'URL_ROUTE_RULES'=>array(

    'news/:id'               => 'New/read/:1',

    'videoInfo'                         =>  'Video/index',
    'videoList/:id\d/:p'                =>  'Video/videoList',
),
);