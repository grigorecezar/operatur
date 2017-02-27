<?php

return [
	'default-driver' => 'azure', // azure functions and azure queue (from storage)

	'connections' => [
		'azure' => [
			'driver' => 'azure',
            'queue' => '/app',
            'protocol' => 'https', // http or https
            'account' => '', // queue account (storage account)
            'key' => '' // queue key (storage account)
		],

		'iron' => [
		],

		'aws-lambda' => [
		]
	]
];