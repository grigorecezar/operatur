<?php namespace IndexIO\Operatur\ConsoleCommands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class GenerateFunctions extends Command
{
	protected function configure()
	{
		$platform = 'azure';

		$this->setName('operatur:generate-functions')
			->setDescription('Generates the folder and files necessary for deployment to docker / azure functions / iron.io')
			->setDefinition([
				new InputOption('platform', 'p', InputOption::VALUE_OPTIONAL, 'The platform for which we generate', $platform)
			])
			->setHelp('TODO: Help function');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$platform = $input->getOption('platform');
		$output->writeln('Working on:' . $platform);
	}
}