<?php namespace IndexIO\Operatur\Scheduler;

use IndexIO\Operatur\Exceptions\OperaturException;

class BadScheduleRegistered extends OperaturException
{
	protected $message = 'The schedule you are trying to regist has a wrong format.';
	protected $code = 409;
}