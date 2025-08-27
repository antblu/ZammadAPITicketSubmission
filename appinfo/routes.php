<?php
declare(strict_types=1);

return [
    'routes' => [
        // This serves the page when you click "Help" in the App Navigation
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
    ],
    'ocs' => [
        // OCS endpoint used by the frontend to create tickets
        ['name' => 'api#tickets', 'url' => '/api/tickets', 'verb' => 'POST'],
    ],
];
