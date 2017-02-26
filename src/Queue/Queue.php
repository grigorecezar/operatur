<?php namespace IndexIO\Operatur\Queue;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;
use IndexIO\Operatur\Config;
use IndexIO\Operatur\Router\Request;
use Illuminate\Queue\Capsule\Manager as IlluminateQueueManager;
use Illuminate\Container\Container;

class Queue extends IlluminateQueueManager implements QueueContract 
{
	protected $config = null;

	/**
     * Create a new queue capsule manager.
     *
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(Config $config, Container $container = null)
    {
        parent::__construct($container);
        $this->config = $config;
    }

	public function run(WorkerContract $worker, Request $request, $process)
	{
		// TODO: this should push to queue
		// when 'sync' driver enabled, runs continously
		switch($this->config->getDriver()) {
			case 'sync':
				$worker->$process($request);
				break;

			default:
				$data = json_encode($request->getData());
				$this->pushRaw($data, '/' . $worker::QUEUE_NAME);
		}
		
	}
}