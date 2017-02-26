<?php namespace IndexIO\Operatur\Router;

class Request
{
	protected $data = null;
	protected $route = null;

	public function __construct(Route $route, $data = null)
	{
		$this->route = $route;
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}
}