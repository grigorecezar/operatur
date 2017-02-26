<?php namespace IndexIO\Operatur\Router;

use IndexIO\Operatur\Exceptions\OperaturException;

class WrongRoute extends OperaturException
{
	protected $message = 'Worker provided is not registered in routes.';
	protected $code = 400;
}