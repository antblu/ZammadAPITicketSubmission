<?php

declare(strict_types=1);

namespace OCA\ZammadAPITicketSubmission\Service;

use OCP\IConfig;
use OCP\Http\Client\IClientService;
use OCP\Http\Client\IClient;
use OCP\AppFramework\Http;

class ZammadClient {
	private IClient $client;
	public function __construct(
		private IConfig $config,
		IClientService $clientService
	) {
		$this->client = $clientService->newClient();
	}

	private function getBaseUrl(): string {
		$base = (string)$this->config->getAppValue('zammadapiticketsubmission', 'zammadUrl', '');
		if ($base === '') {
			throw new \RuntimeException('Zammad base URL is not configured');
		}
		return rtrim($base, '/');
	}

	private function getToken(): string {
		$token = (string)$this->config->getAppValue('zammadapiticketsubmission', 'apiToken', '');
		if ($token === '') {
			throw new \RuntimeException('Zammad API token is not configured');
		}
		return $token;
	}

	/**
	 * Create a ticket via Zammad REST API
	 * @param array{id?:int,subject:string,body:string,customer:string,priority?:string,tags?:array<int,string>} $payload
	 * @return array{id?:int,number?:int}
	 */
	public function createTicket(array $payload): array {
		$base = $this->getBaseUrl();
		$token = $this->getToken();

		$ticketPayload = [
			"title" => $payload['subject'] ?? '',
			"group_id" => 1,
			"priority_id" => (int)($payload['priority'] ?? '2'),
			"customer" => $payload['customer'] ?? '',
			"article" => [
				"subject" => $payload['subject'] ?? '',
				"body" => $payload['body'] ?? '',
				"content_type" => "text/plain",
			],
		];

		if (!empty($payload['tags']) && is_array($payload['tags'])) {
			$ticketPayload['tags'] = $payload['tags'];
		}

		$response = $this->client->post("{$base}/api/v1/tickets", [
			'headers' => [
				'Authorization' => 'Token token=' . $token,
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
			],
			'body' => json_encode($ticketPayload, JSON_THROW_ON_ERROR),
			'timeout' => 30,
		]);

		$status = $response->getStatusCode();
		if ($status < 200 || $status >= 300) {
			throw new \RuntimeException('Zammad API error: ' . $status . ' ' . $response->getBody());
		}
		/** @var array{id?:int,number?:int} */
		$decoded = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
		return $decoded;
	}
}
