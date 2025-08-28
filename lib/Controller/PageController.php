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
public function index(): \OCP\AppFramework\Http\TemplateResponse {
  \OCP\Util::addScript($this->appName, 'main'); // loads js/main.js
  return new \OCP\AppFramework\Http\TemplateResponse($this->appName, 'main');
}
