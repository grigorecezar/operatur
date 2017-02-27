<?php namespace IndexIO\Operatur\FunctionGenerators;

class Generator
{
	public static function createFromConfig($config, $globalPath)
	{
		if (!isset($config['default-driver'])) {
			throw new InvalidConfigFile('The default-driver is not present in the config file provided.');
		}

		if (!isset($config['connections']) || !isset($config['connections'][$config['default-driver']])) {
			throw new InvalidConfigFile('Connections not defined in config or ' . $config['default-driver'] . ' not defined inside connections.');
		}

		$driver = $config['default-driver'];
		switch ($driver) {
			case Drivers::DOCKER:
				throw new InvalidConfigFile('Docker driver not yet configured. Please use azure functions for now.');
				break;

			case Drivers::AZURE_FUNCTIONS:
				$generator = new AzureFunctions($config['connections'][Drivers::AZURE_FUNCTIONS], $globalPath);
				break;

			case Drivers::IRON_IO:
				throw new InvalidConfigFile('Iron io driver not yet configured. Please use azure functions for now.');
				break;

			case Drivers::AWS_LAMBDA:
				throw new InvalidConfigFile('AWS Lambda driver not yet configured. Please use azure functions for now.');
				break;

			default:
				throw new InvalidConfigFile('The provided default-driver in config is not recognizable, please use one the following: ' . 
					Drivers::DOCKER . ', ' . Drivers::AZURE_FUNCTIONS . ', ' . Drivers::IRON_IO . ', ' . Drivers::AWS_LAMBDA);
		}

		return $generator;
	}
}