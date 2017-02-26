<?php namespace IndexIO\Operatur\Contracts;

use IndexIO\Operatur\Router\Request;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;
use Illuminate\Contracts\Queue\Queue as IlluminateQueue;

interface Queue
{
	public function run(WorkerContract $worker, Request $request, $process);
}