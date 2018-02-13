<?php
class Route
{
	public $Modifier = 'i'; //路由规则匹配时 的 正则修饰符  i 不区分大小写  u 贪婪模式关闭
	public $url;            // URL类
	public $path;           // 实际路由
	public $segments;       // 实际路由 拆解 成数组
	public $module = BIND_MODULE;
	public $class  = BIND_CLASS;
	public $method = 'index';
	public function __construct()
	{
		$this->routes = include_once 'Route.config.php';
		$this->url    = URL::getInstance();
	}

	/**
	 * 解析路由 将域名路由 映射成 真路由
	 * @param  [type] $path [域名路由]
	 * @return [type]       [返回真正路由]
	 */
	public function parseRoute($path)
	{
		if (!empty($this->routes)) {
			foreach ($this->routes as $k => $v) {
				$key = str_replace([':any', ':num'], ['.*', '[0-9]+'], $k);
				if (preg_match('#^' . $key . '$#' . $this->Modifier, $path, $matches)) {
					if (strpos($v, '$') !== false && strpos($key, '(') !== false) {
						$v = preg_replace('#^' . $key . '$#i', $v, $path);
					}
					$path = $v;
					break;
				}
			}
		}
		return $path;
	}

	/**
	 * 设置 请求的 module class method 以及 参数
	 * @param array $segments [description]
	 */
	public function setRequest($segments = [])
	{
		isset($segments[1]) && $this->setModule($segments[1]);
		isset($segments[2]) && $this->setClass($segments[2]);
		isset($segments[3]) && $this->setMethod($segments[3]);
		$this->setArgv(array_slice($segments,3));
		return ;
	}

	public function setModule($module)
	{
		$this->module = $module;
	}

	public function setClass($class)
	{
		$this->class = str_replace(['/', '.'], '', $class);
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function setArgv($argvs)
	{
		$data = [];
		if(is_array($argvs) && !empty($argvs)){
			$argvs_num = count($argvs);
			for ($i = 0; $i < $argvs_num ;$i = $i + 2) {
				isset($argvs[$i+1]) ? $data[$argvs[$i]] = $argvs[$i+1] : '';
			}
		}
		$this->argvs = $data;
	}
}
