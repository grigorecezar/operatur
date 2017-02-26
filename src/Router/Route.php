<?php namespace IndexIO\Operatur\Router;

class Route
{
	protected $workerName = '';
	protected $processToRun = '';

	public function __construct($worker, $process)
	{
		$this->sanityCheck($worker, $process);

		$this->workerName = $worker;
		$this->processToRun = $process;
	}

	public function getName()
	{
		return $this->workerName;
	}

	public function getProcess()
	{
		return $this->processToRun;
	}

	protected function sanityCheck($worker, $process)
	{
		// TODO: validate date
	}
}