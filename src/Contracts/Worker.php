<?php namespace IndexIO\Operatur\Contracts;

use IndexIO\Operatur\Router\Request;

interface Worker
{
	public function handle();
}