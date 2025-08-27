<?php
declare(strict_types=1);

namespace OCA\ZammadAPITicketSubmission\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;

class PageController extends Controller {
	public function __construct(string $appName, IRequest $request) {
		parent::__construct($appName, $request);
	}

	/** @NoAdminRequired */
	public function index(): TemplateResponse {
		// Load the Vite-built JS entry "main" (from vite.config -> key "main")
		Util::addScript($this->appName, 'main');
		// Optionally: Util::addStyle($this->appName, 'style'); // if you ship CSS

		// Render templates/main.php which includes the mount node
		return new TemplateResponse($this->appName, 'main'); // templates/main.php
	}
}
