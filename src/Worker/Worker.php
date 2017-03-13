<?php namespace IndexIO\Operatur\Worker;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;
use IndexIO\Operatur\Router\Request;
use IndexIO\Operatur\Router\Route;

abstract class Worker implements WorkerContract
{
	protected $request = null;
	protected $queue = null;

	public function __construct(array $data)
	{
		$this->request = new Request(
			new Route(static::NAME, 'handle'),
			$data
		);
	}

	abstract public function handle();

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	public function getRequest() : Request 
	{
		return $this->request;
	}
}