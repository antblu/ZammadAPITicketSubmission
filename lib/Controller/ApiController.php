<?php

declare(strict_types=1);

namespace OCA\ZammadAPITicketSubmission\Controller;

use OCP\AppFramework\OCSController; // ✅ works on NC 29–31
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
		$raw = (string)($this->request->getBody() ?? '');
		try {
			$payload = $raw !== '' ? json_decode($raw, true, 512, JSON_THROW_ON_ERROR) : [];
		} catch (\JsonException $e) {
			return new DataResponse(['error' => 'Invalid JSON body'], 400);
		}

		if (!is_array($payload)) {
			return new DataResponse(['error' => 'Request body must be a JSON object'], 400);
		}

		try {
			$ticket = $this->zammad->createTicket($payload);
			return new DataResponse($ticket, 200);
		} catch (\Throwable $e) {
			// Surface a safe error; details will be in nextcloud.log
			return new DataResponse(['error' => 'Failed to create ticket'], 500);
		}
	}
}
