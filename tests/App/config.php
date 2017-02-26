<?php namespace IndexIO\Operatur\Test\App;

return [
	'default-driver' => 'azure-functions',

	'connections' => [
		'azure' => [
			'driver' => 'azure',
            'queue' => 'app',
            'protocol' => 'https', // http or https
            'queue_account' => '',
            'queue_key' => ''
		]
	]
];