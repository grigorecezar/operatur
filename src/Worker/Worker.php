<?php namespace IndexIO\Operatur\Worker;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;
use IndexIO\Operatur\Router\Request;
use IndexIO\Operatur\Router\Route;
use IndexIO\Operatur\Queue\Queue as Operatur;

abstract class Worker implements WorkerContract
{
	protected $request = null;
	protected $queue = null;
	protected $operatur = null;

	public function __construct(array $data, Operatur $operatur = null)
	{
		$this->request = new Request(
			new Route(static::NAME, 'handle'),
			$data
		);

		$this->operatur = $operatur;
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