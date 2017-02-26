<?php namespace IndexIO\Operatur\Router;

use IndexIO\Operatur\Queue\Queue;
use Exception;

class Loader
{
	protected $routes = [];
	protected $config = [];
	protected $input = [];

	public function __construct(array $routes, array $config, array $input)
	{
		$this->routes = $routes;
		$this->config = $config;
		$this->input = $input;
	}

	public function load()
	{
		$routes = $this->routes;
		$config = $this->config;
		$input = $this->input;

		$this->sanityCheckRoutes($routes);
		$this->sanityCheckConfig($config);
		$this->sanityCheckInput($input);

		$route = new Route($input['worker'], $input['process']);
		if(isset($input['data'])) {
			$request = new Request($input['data']);
		} else {
			$request = new Request();
		}
		

		$instance = $this->routeInstance($routes, $route);
		if (!isset($instance)) {
			throw new WrongRoute();
		}

		try {
			$process = $route->getProcess();
			$instance->$process($request);
		} catch (Exception $e) {
			// TODO: handle this better - log it into a monitoring system
			throw $e;
		}
	}

	public function routeInstance($routes, Route $route)
	{
		foreach ($routes as $namespace) {
			if (class_exists($namespace)) {
				if ($namespace::NAME === $route->getName()) {
					$queue = new Queue();
					return new $namespace($queue);
				}
			}
		}

		return null;
	}

	/**
	 * TODO: check if the routes defined have classes that contain all
	 * the necessary information about the worker defined
	 */
	public function sanityCheckRoutes($routes)
	{

	}

	/**
	 * TODO
	 */
	public function sanityCheckConfig($config)
	{

	}

	/**
	 * TODO: validates data input, eg. 'process' needs to exist
	 */
	public function sanityCheckInput($routes)
	{

	}

}