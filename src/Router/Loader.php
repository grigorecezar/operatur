<?php namespace IndexIO\Operatur\Router;

use IndexIO\Operatur\Queue\Queue;
use IndexIO\Operatur\Config;
use IndexIO\IlluminateQueueAzure\Connectors\AzureConnector;
use Illuminate\Queue\Capsule\Manager as IlluminateQueueManager;
use Exception;

class Loader
{
	protected $routes = [];
	protected $config = null;
	protected $routeToAccess = null;
	protected $request = null;

	protected $queue = null;

	public function __construct(array $routes, array $config, array $input)
	{
		$this->sanityCheckRoutes($routes);
		$this->sanityCheckConfig($config);
		$this->sanityCheckInput($input);

		$route = new Route($input['worker'], $input['process']);
		$config = new Config($config);
		if(isset($input['data'])) {
			$request = new Request($route, $input['data']);
		} else {
			$request = new Request($route);
		}

		$this->routes = $routes;
		$this->config = $config;
		$this->request = $request;
		$this->routeToAccess = $route;

		// $this->configureQueue();
	}

	public function load()
	{
		$instance = $this->routeInstance($this->routes, $this->routeToAccess, $this->request);
		if (!isset($instance)) {
			throw new WrongRoute();
		}

		try {
			$process = $this->routeToAccess->getProcess();
			$instance->$process($this->request);
		} catch (Exception $e) {
			// TODO: handle this better - log it into a monitoring system
			throw $e;
		}
	}

	protected function routeInstance($routes, Route $route, Request $request)
	{
		foreach ($routes as $namespace) {
			if (class_exists($namespace)) {
				if ($namespace::NAME === $route->getName()) {
					return new $namespace((array) $request->getData());
				}
			}
		}

		return null;
	}

	/**
	 * TODO: check if the routes defined have classes that contain all
	 * the necessary information about the worker defined
	 */
	protected function sanityCheckRoutes($routes)
	{

	}

	/**
	 * TODO
	 */
	protected function sanityCheckConfig($config)
	{

	}

	/**
	 * TODO: validates data input, eg. 'process' needs to exist
	 */
	protected function sanityCheckInput($routes)
	{

	}

	/* protected function configureQueue()
	{
		$config = $this->config;

		$queue = new Queue($config);
		$queue->addConnector('azure', function() use($config) {
			return new AzureConnector($config->toArray());
		});

		$queue->addConnection($config->getConnection());

		$this->queue = $queue;
	}*/
}