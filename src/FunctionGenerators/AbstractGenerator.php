<?php namespace IndexIO\Operatur\FunctionGenerators;

use InvalidArgumentException;

abstract class AbstractGenerator
{
	private $globalPath = null;

	public function __construct($globalPath)
	{
		$this->globalPath = $globalPath;
	}

	abstract public function create($worker);
	abstract public function remove($worker);

	public function getGlobalPath()
	{
		return $this->globalPath;
	}

	protected static function deleteDir($dirPath)
	{
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }

	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }

	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }

	    rmdir($dirPath);
	}
}