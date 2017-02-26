<?php namespace IndexIO\Operatur\Scheduler;

use IndexIO\Operatur\Router\Route;
use IndexIO\Operatur\Router\Request;

class Schedule
{
	protected $route = null;
	protected $request = null;

	public function __construct(Route $route, Request $request)
	{
		$this->route = $route;
		$this->request = $request;
	}

	public function register($command)
	{
		if (!isset($command['process']) || !isset($command['start-time'])
			!isset($command['name']) || !isset($command['run-every'])) {
				throw new BadScheduleRegistered();
		}


	}
}