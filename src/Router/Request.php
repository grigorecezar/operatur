<?php namespace IndexIO\Operatur\Router;

class Request
{
	protected $data = null;

	public function __construct($data = null)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}
}