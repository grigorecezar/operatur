<?php

return [
	'default-driver' => 'azure-functions', // azure functions and azure queue (from storage)

	'connections' => [
		'azure-functions' => [
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