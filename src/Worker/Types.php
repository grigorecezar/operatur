<?php namespace IndexIO\Operatur\Worker;

use IndexIO\Operatur\ProcessType\RunOnSchedule;
use IndexIO\Operatur\ProcessType\RunOnTrigger;

class Types
{
	const RUN_ON_SCHEDULE = RunOnSchedule::class;
	const RUN_ON_TRIGGER = RunOnTrigger::class;
}