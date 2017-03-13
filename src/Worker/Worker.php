<?php namespace IndexIO\Operatur\Worker;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;
use IndexIO\Operatur\Router\Request;

class Worker implements WorkerContract
{
	protected $request = null;
	protected $queue = null;

	public function __construct(Request $request, QueueContract $queue)
	{
		$this->request = $request;
		$this->queue = $queue;
	}

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	public function getRequest() : Request 
	{
		return $this->request;
	}
}