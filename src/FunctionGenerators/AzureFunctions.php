<?php namespace IndexIO\Operatur\FunctionGenerators;

class AzureFunctions extends AbstractGenerator
{
	public function __construct($connection, $globalPath)
	{
		parent::__construct($globalPath);
		$this->connection = $connection;
	}

	public function create($worker)
	{
		$functionName = $worker::NAME;
		$functionPath = $this->getGlobalPath() . $functionName;
		
		if (file_exists($functionPath)) {
			// TODO: handle this, maybe just display a message to the user?
		}

		mkdir($functionPath);
		$this->createFunctionJson($functionName, $functionPath);
	}

	public function remove($worker)
	{
		$functionName = $worker::NAME;
		$functionPath = $this->getGlobalPath() . $functionName;
		
		if (!file_exists($functionPath)) {
			throw new FolderFileDoesNotExist('The route folder you trying to remove ' . $functionPath . ' does not exist. Maybe has been manually removed?');
		}

		$this->deleteDir($functionPath);
	}

	public function createFunctionJson($functionName, $functionPath)
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
}