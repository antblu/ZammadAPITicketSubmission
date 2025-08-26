<?php

declare(strict_types=1);

namespace OCA\ZammadAPITicketSubmission\Controller;

use OCP\AppFramework\OCS\OCSController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use OCA\ZammadAPITicketSubmission\Service\ZammadClient;

class ApiController extends OCSController {
	public function __construct(
		string $appName,
		IRequest $request,
		private ZammadClient $zammad
	) {
		parent::__construct($appName, $request);
	}

	/** @NoAdminRequired @NoCSRFRequired @CORS */
	public function tickets(): DataResponse {
		$body = $this->request->getBody();
		$payload = json_decode($body ?: '[]', true) ?? [];
		$ticket = $this->zammad->createTicket($payload);
		return new DataResponse($ticket);
	}
}
