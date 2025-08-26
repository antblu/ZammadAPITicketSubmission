<?php
declare(strict_types=1);

return [
	'routes' => [
		// Web route for the app page (existing skeleton likely handles it)
	],
	'ocs' => [
		['name' => 'api#tickets', 'url' => '/api/tickets', 'verb' => 'POST'],
	],
];
