<?php namespace IndexIO\Operatur\Worker;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;

class Worker implements WorkerContract
{
	protected $queue;

	public function __construct(QueueContract $queue)
	{
		$this->queue = $queue;
	}
}