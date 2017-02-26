<?php namespace IndexIO\Operatur\Test;

use PHPUnit_Framework_TestCase;

use IndexIO\Operatur\Router\Loader;

class SendDailyEmailtest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     *
     * @return void
     */
    public function testMaster()
    {
        $routes = require_once __DIR__ . '/App/routes.php';
        $config = require_once __DIR__ . '/App/config.php';

        $input = [
            'worker' => 'daily-activity-emails',
            'process' => 'master'
        ];

        $loader = (new Loader($routes, $config, $input))->load();
    }

   /**
     * 
     *
     * @return void
     */
    public function testSlave()
    {
    	$routes = require_once __DIR__ . '/App/routes.php';
    	$config = require_once __DIR__ . '/App/config.php';

    	$input = [
			'worker' => 'daily-activity-emails',
			'process' => 'slave',
			'data' => [
				'userIds' => [
					1, 2, 3, 4, 5, 6, 7, 8, 9, 10
				]
			]
		];

		$loader = (new Loader($routes, $config, $input))->load();
    }
}
