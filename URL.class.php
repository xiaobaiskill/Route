<?php
class URL {
	protected $path;
	protected $query;
	/**
	 * 解析 $_SERVER['require_uri']
	 * @return [type] [description]
	 */
	public function _parseRequestUri()
	{
		$parse_url = parse_url($_SERVER['REQUEST_URI']);
		$this->path = rtrim(trim($parse_url['path'], '\/'), '\.'.__EXT__);
		$this->query = $parse_url['query'];


		echo $this->path;
	}
}