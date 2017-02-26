<?php namespace IndexIO\Operatur;

class Config
{
	protected $config = [];
	protected $driver = '';
	protected $connection = [];

	public function __construct(array $config)
	{
		$this->sanityCheck($config);

		$this->config = $config;
		$this->driver = $config['default-driver'];
		$this->connection = $config['connections'][$this->driver];
	}

	protected function sanityCheck($config)
	{

	}

	public function getDriver()
	{
		return $this->driver;
	}

	public function getConnection()
	{
		return array_merge(
			$this->connection,
			['driver' => $this->driver]
		);
	}

	public function __toArray()
	{
		return $this->config;
	}
}