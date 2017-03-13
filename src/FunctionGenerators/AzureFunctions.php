<?php namespace IndexIO\Operatur\FunctionGenerators;

use IndexIO\Operatur\ProcessType\RunOnSchedule;
use IndexIO\Operatur\ProcessType\RunOnTrigger;
use IndexIO\Operatur\Worker\Types as WorkerTypes;

/**
 *
 * For scheduled function check https://docs.microsoft.com/en-us/azure/azure-functions/functions-bindings-timer
 * For more info about function.json bindings https://github.com/Azure/azure-webjobs-sdk-script/wiki/function.json
 */
class AzureFunctions extends AbstractGenerator
{
	public function __construct($connection, $globalPath)
	{
		parent::__construct($globalPath);
		$this->connection = $connection;
	}

	protected function validate($worker)
	{
		if (!defined($worker . '::NAME')) {
			throw new InvalidWorker('The NAME constant must be present on all your defined workers, currently not present on ' . $worker);
		}

		$workerType = null;
		$traits = class_uses($worker);
		foreach ($traits as $trait) {
			switch ($trait) {
				case WorkerTypes::RUN_ON_SCHEDULE:
					if($workerType !== null) {
						throw new InvalidWorker('Please use a single trait between RunOnSchedule and RunOnTrigger.');
					}
					$workerType = $trait;
					break;
				case WorkerTypes::RUN_ON_TRIGGER:
					if($workerType !== null) {
						throw new InvalidWorker('Please use a single trait between RunOnSchedule and RunOnTrigger.');
					}
					$workerType = $trait;
					break;
			}
		}

		if ($workerType === null) {
			throw new InvalidWorker('The worker has no defined trait, it must be either RunOnSchedule or RunOnTrigger');
		}

		if ($workerType === WorkerTypes::RUN_ON_SCHEDULE) {
			if (!defined($worker . '::RUN_EVERY') || !is_array($worker::RUN_EVERY)) {
				throw new InvalidWorker('The RUN_EVERY constant must be present on all your RunOnSchedule workers (and be an array), currently not present on ' . $worker);
			}

			$runEvery = $worker::RUN_EVERY;
			if (!isset($runEvery['second']) || !isset($runEvery['minute']) ||
				!isset($runEvery['hour']) || !isset($runEvery['day']) || 
				!isset($runEvery['month']) || !isset($runEvery['day-of-week']) ) {
				throw new InvalidWorker('The RUN_EVERY constant on your ' . $worker . ' does not have all needed fields: second, minute, hour, day, month, day-of-week.');
			}
		}

		return $workerType;
 	}

	public function create($worker)
	{
		$workerType = $this->validate($worker);

		$functionName = $worker::NAME;
		$functionPath = $this->getGlobalPath() . $functionName;
		
		if (file_exists($functionPath)) {
			// TODO: handle this, maybe just display a message to the user?
		}

		mkdir($functionPath);

		switch ($workerType) {
			case WorkerTypes::RUN_ON_SCHEDULE:
				$this->createFunctionJsonForRunningOnSchedule($worker, $functionName, $functionPath);
				break;
			case WorkerTypes::RUN_ON_TRIGGER:
				$this->createFunctionJsonForRunningOnTrigger($worker, $functionName, $functionPath);
				break;
		}

	}

	public function remove($worker)
	{
		$workerType = $this->validate($worker);

		$functionName = $worker::NAME;
		$functionPath = $this->getGlobalPath() . $functionName;
		
		if (!file_exists($functionPath)) {
			throw new FolderFileDoesNotExist('The route folder you trying to remove ' . $functionPath . ' does not exist. Maybe has been manually removed?');
		}

		$this->deleteDir($functionPath);
	}

	public function createFunctionJsonForRunningOnTrigger($worker, $functionName, $functionPath)
	{
		$function = [
			'bindings' => [
				'name' => $functionName,
				'type' => 'queueTrigger',
				'direction' => 'in',
				'queueName' => $functionName,
				'connection' => 'AzureWebJobsDashboard'
			],
			'disabled' => false
		];

		$dataToWrite = json_encode($function);
		$file = $functionPath . '/function.json';

		try {
			$handle = fopen($file, 'w');
			fwrite($handle, $dataToWrite);
			fclose($handle);
		} catch (Exception $e) {
			throw new InvalidArgumentException('Cannot create function.json file in ' . $file);
		}
	}

	protected function createFunctionJsonForRunningOnSchedule($worker, $functionName, $functionPath)
	{
		$runEvery = $worker::RUN_EVERY;
		$cron = $runEvery['second'] . ' ' . $runEvery['minute'] . ' ' . $runEvery['hour'] . ' ' . $runEvery['day'] . ' ' . $runEvery['month'] . ' ' . $runEvery['day-of-week'];
		$function = [
		    'schedule' =>  $cron, // "<CRON expression - see below>"
		    'name' => $functionName, // "<Name of trigger parameter in function signature>"
		    'type' => 'timerTrigger',
		    'direction' => 'in'
		];

		$dataToWrite = json_encode($function);
		$file = $functionPath . '/function.json';

		try {
			$handle = fopen($file, 'w');
			fwrite($handle, $dataToWrite);
			fclose($handle);
		} catch (Exception $e) {
			throw new InvalidArgumentException('Cannot create function.json file in ' . $file);
		}
	}
}