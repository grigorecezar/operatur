<?php namespace IndexIO\Operatur\Queue;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;
use IndexIO\Operatur\Router\Request;
use Illuminate\Queue\Queue as IlluminateQueue;

class Queue implements QueueContract 
{
	public function run(WorkerContract $worker, Request $request, $process)
	{
		// TODO: this should push to queue
		// when 'sync' driver enabled, runs continously
		$worker->$process($request);
	}
}