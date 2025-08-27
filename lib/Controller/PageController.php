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

  /** @NoAdminRequired @NoCSRFRequired */
  public function index(): TemplateResponse {
    // Load the built JS entry ("main" from vite.config.js)
    Util::addScript($this->appName, 'main');
    return new TemplateResponse($this->appName, 'main'); // templates/main.php
  }
}
