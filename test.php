<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 https://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com-->
// +----------------------------------------------------------------------
namespace Think;
/**
 * ThinkPHP路由解析类
 * 又是个解析了，哈哈
 */
class Route {
 
    // 路由检测
    // 大哥，不就检测个路由吗，不能简单点吗
    public static function check(){
        $depr   =   C('URL_PATHINFO_DEPR'); //  又是这个分隔符号
        $regx   =   preg_replace('/\.'.__EXT__.'$/i','',trim($_SERVER['PATH_INFO'],$depr));// 踢出出去了
        // 分隔符替换 确保路由定义使用统一的分隔符
        if('/' != $depr){ // 如果分隔符
            $regx = str_replace($depr,'/',$regx); // 这里替换了  变成了 / 里面了
        }
        // URL映射定义（静态路由）
        $maps   =   C('URL_MAP_RULES'); // 这里 应该 没什么呢  'URL_MAP_RULES'         =>  array(), // URL映射定义规则
        if(isset($maps[$regx])) { // 如果设置了，对应的路由规则了  这里是 特殊的路由了
            $var    =   self::parseUrl($maps[$regx]);// 这里的变成变量了
            $_GET   =   array_merge($var, $_GET);// 合并了 的变量了
            return true;                // 这个就返回了啊，
        }        
        // 动态路由处理
        $routes =   C('URL_ROUTE_RULES'); // 'URL_ROUTE_RULES'       =>  array(), // 默认路由规则 针对模块
        if(!empty($routes)) {// 这里 不为空，其实 是空的
            foreach ($routes as $rule=>$route){ // 这里才是 开始了 嘿嘿
                if(is_numeric($rule)){// 如果是 数字
                    // 支持 array('rule','adddress',...) 定义路由
                    $rule   =   array_shift($route); // 这里 踢出出来了， 其实，你对你输入格式 变成了
                }
                if(is_array($route) && isset($route[2])){// 如果 是 数组 并且 规则 不一样呢
                    // 路由参数
                    $options    =   $route[2]; // 进行参数开始
                    if(isset($options['ext']) && __EXT__ != $options['ext']){
                        // URL后缀检测
                        continue;// URL 后缀
                    }
                    if(isset($options['method']) && REQUEST_METHOD != strtoupper($options['method'])){
                        // 请求类型检测
                        continue; // 进行方法 进行 转化
                    }
                    // 自定义检测
                    if(!empty($options['callback']) && is_callable($options['callback'])) {
                        if(false === call_user_func($options['callback'])) {
                            continue;
                        }
                    }                    
                }
                if(0===strpos($rule,'/') && preg_match($rule,$regx,$matches)) { // 正则路由
                    if($route instanceof \Closure) {
                        // 执行闭包  规则的 的一个转换
                        $result = self::invokeRegx($route, $matches);
                        // 如果返回布尔值 则继续执行
                        return is_bool($result) ? $result : exit;
                    }else{
                        return self::parseRegex($matches,$route,$regx);
                    }
                }else{ // 规则路由
                    $len1   =   substr_count($regx,'/');
                    $len2   =   substr_count($rule,'/');
                    if($len1>=$len2 || strpos($rule,'[')) {
                        if('$' == substr($rule,-1,1)) {// 完整匹配
                            if($len1 != $len2) {
                                continue;
                            }else{
                                $rule =  substr($rule,0,-1);
                            }
                        }
                        $match  =  self::checkUrlMatch($regx,$rule);
                        if(false !== $match)  {
                            if($route instanceof \Closure) {
                                // 执行闭包
                                $result = self::invokeRule($route, $match);
                                // 如果返回布尔值 则继续执行
                                return is_bool($result) ? $result : exit;
                            }else{
                                return self::parseRule($rule,$route,$regx);
                            }
                        }
                    }
                }
            }
        }
        return false;// 返回这里 有什么用吗
    }
    // 今天的这个，偷懒了，不好意思哈， 感觉就是，对输入参数的一个解析，然后返回些真真假假的东西了。
 
 
    // 检测URL和规则路由是否匹配
    private static function checkUrlMatch($regx,$rule) {
        $m1 = explode('/',$regx); // 解析 位置
        $m2 = explode('/',$rule); // 规则
        $var = array();         
        foreach ($m2 as $key=>$val){ // 解析 规则
            if(0 === strpos($val,'[:')){ // 如果
                $val    =   substr($val,1,-1);// 截取位置
            }
 
            if(':' == substr($val,0,1)) {// 动态变量
                if($pos = strpos($val,'|')){ // 如果 就是那个
                    // 使用函数过滤
                    $val   =   substr($val,1,$pos-1); // 如果 这里 也是一个解析了呢
                }
                if(strpos($val,'\\')) { // 查找位置
                    $type = substr($val,-1);
                    if('d'==$type) {
                        if(isset($m1[$key]) && !is_numeric($m1[$key]))
                            return false; // 返回位置
                    }
                    $name = substr($val, 1, -2); // 返回 截取位置
                }elseif($pos = strpos($val,'^')){// 各种 位置
                    $array   =  explode('-',substr(strstr($val,'^'),1)); // 这里的东西
                    if(in_array($m1[$key],$array)) { //如果是数组了
                        return false;
                    }
                    $name = substr($val, 1, $pos - 1);// 各种截取了
                }else{
                    $name = substr($val, 1);
                }
                $var[$name] = isset($m1[$key])?$m1[$key]:'';
            }elseif(0 !== strcasecmp($val,$m1[$key])){
                return false;
            }
        }
        // 成功匹配后返回URL中的动态变量数组
        return $var;
    }// 返回 这里的 数据了
    // 一顿神匹配，然后转换成为 url 位置
 
    // 解析规范的路由地址
    // 地址格式 [控制器/操作?]参数1=值1&参数2=值2...
    private static function parseUrl($url) {
        // 仓库 开始
        $var  =  array();
        // 处理 开始
        if(false !== strpos($url,'?')) { // [控制器/操作?]参数1=值1&参数2=值2...
            $info   =  parse_url($url);
            $path   = explode('/',$info['path']);
            parse_str($info['query'],$var); // parse_str(string,array) 第一个是 string array
        }elseif(strpos($url,'/')){ // [控制器/操作]
            $path = explode('/',$url);
        }else{ // 参数1=值1&参数2=值2...
            parse_str($url,$var);
        }
        // 解析 url ---> path 跟 var  两个里面开始。
        if(isset($path)) { // 如果有的话
            $var[C('VAR_ACTION')] = array_pop($path); // var_action
            if(!empty($path)) {
                $var[C('VAR_CONTROLLER')] = array_pop($path); // var_controller
            }
            if(!empty($path)) {
                $var[C('VAR_MODULE')]  = array_pop($path);// var_module
            }
        } // 转换  path 到 var  此处就已经合二唯一。
        // 处理 结束
        // 仓库 结束
        return $var;
    }// 总结： 就是 里面的 url 到 var
 
    // 解析规则路由
    // '路由规则'=>'[控制器/操作]?额外参数1=值1&额外参数2=值2...'
    // '路由规则'=>array('[控制器/操作]','额外参数1=值1&额外参数2=值2...')
    // '路由规则'=>'外部地址'
    // '路由规则'=>array('外部地址','重定向代码')
    // 路由规则中 :开头 表示动态变量
    // 外部地址中可以用动态变量 采用 :1 :2 的方式
    // 'news/:month/:day/:id'=>array('News/read?cate=1','status=1'),
    // 'new/:id'=>array('/new.php?id=:1',301), 重定向
    // 这里 看起来  比较恼火 里面的东西
    private static function parseRule($rule,$route,$regx) { // 规则rule route  regx 里面的
        // 规则 解析
        // 获取路由地址规则
        $url   =  is_array($route)?$route[0]:$route; // 这个是奇怪的规则 了
        // 获取URL地址中的参数
        $paths = explode('/',$regx);// 规则了
        // 解析路由规则
        $matches  =  array(); // 路由规则
        $rule =  explode('/',$rule); // 感觉了 里面的 那个 进行了 切换
        foreach ($rule as $item){
            $fun    =   '';// 如果 了 fun
            if(0 === strpos($item,'[:')){ // 分支 1
                $item   =   substr($item,1,-1); // 前后 去掉 一个部分
            }
            // 处理的结果 就是 $item 了。
            if(0===strpos($item,':')) { // 动态变量获取 分支2
                if($pos = strpos($item,'|')){  // 亚分支1
                    // 支持函数过滤
                    $fun  =  substr($item,$pos+1);
                    $item =  substr($item,0,$pos);                    
                }
                if($pos = strpos($item,'^') ) { // 亚分支2
                    $var  =  substr($item,1,$pos-1);
                }elseif(strpos($item,'\\')){// 亚分支3
                    $var  =  substr($item,1,-2);
                }else{
                    $var  =  substr($item,1); // substr(string,start,length)
                }
                $matches[$var] = !empty($fun)? $fun(array_shift($paths)) : array_shift($paths);// 去掉了 里面了
            }else{ // 过滤URL中的静态变量
                array_shift($paths); // 出来 里面的 那个了
            }
        }
        // foreach 里面的 结束
 
        // 分叉处理 1
        if(0=== strpos($url,'/') || 0===strpos($url,'http')) { // 路由重定向跳转  特殊的 处理
            if(strpos($url,':')) { // 传递动态参数
                $values = array_values($matches);
                $url = preg_replace_callback('/:(\d+)/', function($match) use($values){ return $values[$match[1] - 1]; }, $url);
            }
            header("Location: $url", true,(is_array($route) && isset($route[1]))?$route[1]:301);// 重定义了 里面的那个。是这样处理了
            exit;
        }else{ // 分叉处理 2
            // 解析路由地址
            $var  =  self::parseUrl($url);// 这里 反馈回去了，
            // 解析路由地址里面的动态参数
            $values  =  array_values($matches); // array_values() 函数返回一个包含给定数组中所有键值的数组，但不保留键名。
            foreach ($var as $key=>$val){ // 过滤处理一下，其实 也没什么特殊的了， 我发现了
                if(0===strpos($val,':')) {
                    $var[$key] =  $values[substr($val,1)-1];
                }
            }
            $var   =   array_merge($matches,$var); // 合并的
            // 解析剩余的URL参数
            if(!empty($paths)) {
                // 闭包函数（匿名函数）可以从父作用域中继承变量   任何此类变量都应该用 use 语言结构传递进去
                preg_replace_callback('/(\w+)\/([^\/]+)/', function($match) use(&$var){ $var[strtolower($match[1])]=strip_tags($match[2]);}, implode('/',$paths));
            }
            // 解析路由自动传入参数
            if(is_array($route) && isset($route[1])) {// 获取了 参数的 解析了
                if(is_array($route[1])){
                    $params     =   $route[1]; // 参数解析
                }else{
                    parse_str($route[1],$params);
                }                
                $var   =   array_merge($var,$params);
            }
            $_GET   =  array_merge($var,$_GET); // 最后，高 了半天是 转换到 GET 里面了。
        }
        return true;
    }
 
    // 解析正则路由
    // '路由正则'=>'[控制器/操作]?参数1=值1&参数2=值2...'
    // '路由正则'=>array('[控制器/操作]?参数1=值1&参数2=值2...','额外参数1=值1&额外参数2=值2...')
    // '路由正则'=>'外部地址'
    // '路由正则'=>array('外部地址','重定向代码')
    // 参数值和外部地址中可以用动态变量 采用 :1 :2 的方式
    // '/new\/(\d+)\/(\d+)/'=>array('News/read?id=:1&page=:2&cate=1','status=1'),
    // '/new\/(\d+)/'=>array('/new.php?id=:1&page=:2&status=1','301'), 重定向
    private static function parseRegex($matches,$route,$regx) {
        // 获取路由地址规则
        $url   =  is_array($route)?$route[0]:$route; // 获取 url 里面的东西
        $url   =  preg_replace_callback('/:(\d+)/', function($match) use($matches){return $matches[$match[1]];}, $url); 
        if(0=== strpos($url,'/') || 0===strpos($url,'http')) { // 路由重定向跳转
            header("Location: $url", true,(is_array($route) && isset($route[1]))?$route[1]:301);
            exit;
        }else{
            // 解析路由地址
            $var  =  self::parseUrl($url);
            // 处理函数
            foreach($var as $key=>$val){
                if(strpos($val,'|')){
                    list($val,$fun) = explode('|',$val);
                    $var[$key]    =   $fun($val);
                }
            }
            // 解析剩余的URL参数
            $regx =  substr_replace($regx,'',0,strlen($matches[0]));
            if($regx) {
                preg_replace_callback('/(\w+)\/([^\/]+)/', function($match) use(&$var){
                    $var[strtolower($match[1])] = strip_tags($match[2]);
                }, $regx);
            }
            // 解析路由自动传入参数
            if(is_array($route) && isset($route[1])) {
                if(is_array($route[1])){
                    $params     =   $route[1];
                }else{
                    parse_str($route[1],$params);
                }
                $var   =   array_merge($var,$params);
            }
            $_GET   =  array_merge($var,$_GET);
        }
        return true; // 没有返回值 里面的话，就只有一个东西了，
    }// 就是换成正则解析了呗
 
    // 执行正则匹配下的闭包方法 支持参数调用
    static private function invokeRegx($closure, $var = array()) {
        $reflect = new \ReflectionFunction($closure); // 这个貌似是个高大尚的函数内
        $params  = $reflect->getParameters();
        $args    = array();
        array_shift($var);
        foreach ($params as $param){
            if(!empty($var)) {
                $args[] = array_shift($var);
            }elseif($param->isDefaultValueAvailable()){
                $args[] = $param->getDefaultValue();
            }
        }
        return $reflect->invokeArgs($args);
    }// 以后有机会重点研究一下，哈哈
 
    // 执行规则匹配下的闭包方法 支持参数调用
    static private function invokeRule($closure, $var = array()) {
        $reflect = new \ReflectionFunction($closure);
        $params  = $reflect->getParameters();
        $args    = array();
        foreach ($params as $param){
            $name = $param->getName();
            if(isset($var[$name])) {
                $args[] = $var[$name];
            }elseif($param->isDefaultValueAvailable()){
                $args[] = $param->getDefaultValue();
            }
        }
        return $reflect->invokeArgs($args);
    } // 同上
 
}
// 总结: 今天突然很有感悟，就是 以前看的云里雾里的函数，突然反向，可以 就是 几个逻辑关系而已，很清楚。哈
// 不愧 规则大转换啊，哈哈