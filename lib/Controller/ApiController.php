<?php

declare(strict_types=1);

namespace OCA\ZammadAPITicketSubmission\Controller;

use OCP\AppFramework\OCSController;             // ✅ compatible with NC 29–31
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use OCP\ILogger;
use OCA\ZammadAPITicketSubmission\Service\ZammadClient;

class ApiController extends OCSController {
	public function __construct(
		string $appName,
		IRequest $request,
		private ZammadClient $zammad,
		private ILogger $logger
	) {
		parent::__construct($appName, $request);
	}

	/** @NoAdminRequired @NoCSRFRequired @CORS */
	public function tickets(): DataResponse {
		// 1) Ensure OCS header present (prevents CSRF/Forbidden surprises)
		$ocsHeader = (string)($this->request->getHeader('OCS-APIRequest') ?? '');
		if (strtolower($ocsHeader) !== 'true') {
			return new DataResponse(
				['error' => 'Missing required header: OCS-APIRequest: true'],
				403
			);
		}

		// 2) Parse JSON
		$raw = (string)($this->request->getBody() ?? '');
		try {
			$payload = $raw !== '' ? json_decode($raw, true, 512, JSON_THROW_ON_ERROR) : [];
		} catch (\JsonException) {
			return new DataResponse(['error' => 'Invalid JSON body'], 400);
		}
		if (!is_array($payload)) {
			return new DataResponse(['error' => 'Request body must be a JSON object'], 400);
		}

		// 3) Validate required fields
		$missing = [];
		foreach (['subject', 'body', 'customer'] as $key) {
			if (!isset($payload[$key]) || trim((string)$payload[$key]) === '') {
				$missing[] = $key;
			}
		}
		if ($missing) {
			return new DataResponse(
				['error' => 'Missing required fields', 'fields' => $missing],
				422
			);
		}

		// 4) Call Zammad
		try {
			$ticket = $this->zammad->createTicket($payload);
			// Return Zammad’s created ticket payload (id/number…)
			return new DataResponse($ticket, 200);
		} catch (\Throwable $e) {
			// Log full details server-side, surface a safe client message
			$this->logger->error('Zammad ticket creation failed: ' . $e->getMessage(), [
				'app' => $this->appName,
				'exception' => $e,
			]);
			// 5xx because this usually indicates an upstream (Zammad) or config issue
			return new DataResponse(['error' => 'Failed to create ticket'], 502);
		}
	}
}
