<?php
class URL
{
	public $path;
	public $query;
	public $segments             = [];
	public $_permitted_uri_chars = '^a-z0-9A-Z'; //正则过滤非法字符  ^a-z0-9A-Z 表示 过滤非字母和数字的

	public function __construct()
	{
		$this->uri      = $this->getUri();
		$parse_url      = parse_url($this->uri);
		$this->path     = rtrim(trim($parse_url['path'], '/'), '\.' . __EXT__);
		$this->query    = isset($parse_url['query']) ? $parse_url['query'] : '';
		$this->segments = $this->parsePathStr($this->path);
		$_GET           = array_merge($_GET, $this->parseQueryStr($this->query));
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
	 * 解析路由?前的路由   以/分割成数组
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
