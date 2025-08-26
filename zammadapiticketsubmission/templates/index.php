<?php

declare(strict_types=1);

use OCP\Util;

Util::addScript(OCA\ZammadAPITicketSubmission\AppInfo\Application::APP_ID, OCA\ZammadAPITicketSubmission\AppInfo\Application::APP_ID . '-main');
Util::addStyle(OCA\ZammadAPITicketSubmission\AppInfo\Application::APP_ID, OCA\ZammadAPITicketSubmission\AppInfo\Application::APP_ID . '-main');

?>

<div id="zammadapiticketsubmission"></div>
