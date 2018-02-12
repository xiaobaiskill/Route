<?php
class URL
{
	public static $_instance;
	public $path;
	public $query;
	public $segments             = [];
	public $_permitted_uri_chars = '^a-z0-9A-Z\/-'; //正则过滤非法字符  ^a-z0-9A-Z 表示 过滤非字母和数字的

	protected function __construct()
	{
		$this->uri   = $this->getUri();
		$parsed_url  = $this->parseRequestUri($this->uri);
		$this->path  = $parsed_url['path'];
		$this->query = isset($parsed_url['query']) ? $parsed_url['query'] : '';
	}

	public static function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * 根据 不同 服务器 或 cli 获取完整的uri
	 * @return [type] [description]
	 */
	private function getUri()
	{
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * 解析 完整路由并将参数部分放入$_GET中   /path/path?segment1=1&segment2=2
	 * @param  [type] $url [完整路由]
	 * @return [type]      [description]
	 */
	public function parseRequestUri($uri)
	{
		$parsed_url = parse_url($uri);
		$parsed_url['path'] = isset($parsed_url['path']) ? rtrim(trim($parsed_url['path'], '/'), '\.' . __EXT__) : '';
		if (isset($parsed_url['query'])) {
			$_GET = array_merge($_GET, $this->parseQueryStr($parsed_url['query']));
		}
		return $parsed_url;
	}

	/**
	 * 解析路由?前的路由   以分割符成数组
	 * @param  [type] $path [路由路径]
	 * @return [type]       [description]
	 */
	public function parsePathStr($path)
	{
		$segments = [];
		if (!empty($path)) {
			$segments[0] = null;
			$segment_arr = explode(URL_PATHINFO_DEPR, $path);
			foreach ($segment_arr as $v) {
				$v = trim($v);
				$this->filterUri($v);
				if ('' != $v) {
					$segments[] = $v;
				}
			}
			unset($segments[0]);
		}
		return $segments;
	}

	/**
	 * 解析 路由? 后面的get参数
	 * @param  [type] $argvs [路由GET参数]
	 * @return [type]        [description]
	 */
	public function parseQueryStr($argvs)
	{
		$argv_arr = [];
		if (!empty($argvs)) {
			parse_str($argvs, $argv_arr);
		}
		return $argv_arr;
	}

	/**
	 * 过滤功能，过滤URL
	 * @param  [type] &$str [description]
	 * @return [type]       [description]
	 */
	public function filterUri(&$str)
	{
		if (!empty($str) && !empty($this->_permitted_uri_chars) && preg_match('/[' . $this->_permitted_uri_chars . ']+/i', $str)) {
			echo '非法字符：' . $str;exit; //此处 可替换
		}
	}
}
