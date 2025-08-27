<?php
declare(strict_types=1);

return [
  'routes' => [
    // Route that renders your page when clicking "Help"
    ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
  ],
  'ocs' => [
    // OCS endpoint your Vue app calls to create tickets
    ['name' => 'api#tickets', 'url' => '/api/tickets', 'verb' => 'POST'],
  ],
];
