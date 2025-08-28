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

    /**
     * Public GET page. No CSRF required.
     * Route name: zammadapiticketsubmission.page.index
     * URL: /apps/zammadapiticketsubmission/
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index(): TemplateResponse {
        // Load js/main.js built by Vite (outDir: js, entry: main.js)
        Util::addScript($this->appName, 'main');

        // If you also emit a css bundle (optional), uncomment:
        // Util::addStyle($this->appName, 'style');

        // Render templates/main.php
        return new TemplateResponse($this->appName, 'main');
    }
}
