<?php namespace IndexIO\Operatur\ConsoleCommands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use InvalidArgumentException;
use IndexIO\Operatur\FunctionGenerators\Generator;
use IndexIO\Operatur\FunctionGenerators\AbstractGenerator;
use IndexIO\Operatur\FunctionGenerators\FolderFileDoesNotExist;

class GenerateFunctions extends Command
{
	protected function configure()
	{
		$platform = 'azure';
		$removedFlag = false;
		$configFilePath = 'app/Workers/config.php';
		$routesFilePath = 'app/Workers/routes.php';

		$this->setName('operatur:functions')
			->setDescription('Generates the folder and files necessary for deployment to docker / azure functions / iron.io')
			->setDefinition([
				// new InputOption('platform', 'p', InputOption::VALUE_OPTIONAL, 'The platform for which we generate', $platform)
				new InputOption('config-file-path', 'c', InputOption::VALUE_OPTIONAL, 'The path to the config file', $configFilePath),
				new InputOption('routes-file-path', 'r', InputOption::VALUE_OPTIONAL, 'The path to the routes file', $routesFilePath)
			])
			->addArgument('remove', InputArgument::OPTIONAL, 'This arguments gives the ability to remove previously generated folders and files', $removedFlag)
			->setHelp('TODO: Help function');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('');
		// $platform = $input->getOption('platform');
		$removedFlag = $input->getArgument('remove');
		$configFilePath = $input->getOption('config-file-path');
		$routesFilePath = $input->getOption('routes-file-path');

		$globalPath = __DIR__ . '/../../../../../';
		if (!file_exists($globalPath . 'vendor')) {
			$globalPath = __DIR__ . '/../../';
			if (!file_exists($globalPath . 'vendor')) {
				throw new InvalidArgumentException('There is an error in the default path.');
			}
		}

		$configFilePath = $globalPath . $configFilePath;
		$routesFilePath = $globalPath . $routesFilePath;

		if (!file_exists($configFilePath)) {
			throw new InvalidArgumentException('Config file path wrong.');
		}

		if (!file_exists($routesFilePath)) {
			throw new InvalidArgumentException('Routes file path wrong.');
		}

		$config = require_once $configFilePath;
		$routes = require_once $routesFilePath;
		$output->writeln('Config and routes files loaded.');

		$generator = Generator::createFromConfig($config, $globalPath);
		$method = 'create';
		if ($removedFlag) {
			$method = 'remove';
		}

		foreach ($routes as $route) {
			if (!class_exists($route)) {
				throw new InvalidArgumentException('The route provided does not have a class, check your router file for ' . $route);
			}
			try {
				$generator->$method($route);
			} catch (FolderFileDoesNotExist $e) {
				$output->writeln('An exception has occurred, skiping it: ' . $e->getMessage());
			}
		}

		$output->writeln('Completed.');
		$output->writeln('');
	}
}