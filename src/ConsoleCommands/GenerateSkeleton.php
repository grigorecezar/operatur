<?php namespace IndexIO\Operatur\ConsoleCommands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Exception;
use InvalidArgumentException;

class GenerateSkeleton extends Command
{
	protected function configure()
	{
		$appFolderName = 'app';

		$this->setName('operatur:skeleton')
			->setDescription('Generates the skeleton (folders and files) for working with operatur library.')
			->setDefinition([
				new InputOption('app-folder-name', 'p', InputOption::VALUE_OPTIONAL, 'Where the Workers should sit, main app folder', $appFolderName)
			])
			->setHelp('TODO: Help function');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$path = $input->getOption('app-folder-name');
		
		$globablPath = __DIR__ . '/../../' . $path;
		if (!file_exists($globablPath)) {
			$globablPath = __DIR__ . '/../../../../../' . $path;
			if (!file_exists($globablPath)) {
				throw new InvalidArgumentException('The folder provided does not exist.');
			}
		}

		$output->writeln('exists');
		$this->createWorkersFolder($globablPath);
		$this->createConfigFile($globablPath);
	}

	public function createWorkersFolder($path)
	{
		mkdir($path . '/Workers');
	}

	public function createConfigFile($path)
	{
		$configFile = $path . '/Workers/config.php';
		try {
			$handle = fopen($configFile, 'w');
			fwrite($handle, $this->getConfigFileSample());
			fclose($handle);
		} catch (Exception $e) {
			throw new InvalidArgumentException('Cannot create config file on path ' . $configFile);
		}
	}

	public function getConfigFileSample()
	{
		$configSamplePath = __DIR__ . '/../../' . 'sample/config.php';
		try {
			$handle = fopen($configSamplePath, 'r');
			$data = fread($handle, filesize($configSamplePath));
			fclose($handle);
		} catch (Exception $e) {
			throw new InvalidArgumentException('Cannot open sample config file at ' . $configSamplePath);
		}

		return $data;
	}
}