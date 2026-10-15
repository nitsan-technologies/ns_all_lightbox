<?php

declare(strict_types=1);

namespace NITSAN\NsAllLightbox\EventListener;

use NITSAN\NsAllLightbox\Backend\PremiumStrip;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\Route;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Shows the premium strip where the lightbox is configured: below the "All Lightbox" category headline in the
 * site settings editor and above the lightbox constants in the TypoScript Constant Editor.
 *
 * Neither view has a content hook; their doc header (ModifyButtonBarEvent) is built before the page is
 * rendered, so the stylesheet and the module that places the strip are added from here.
 */
final class BackendPremiumStrip
{
    private const SITE_SETTINGS_ROUTE = 'site_configuration.editSettings';
    private const CONSTANT_EDITOR_ROUTE = 'web_typoscript_constanteditor';
    private const SET_SETTING_KEY = 'ns_all_lightbox.configuration.type';
    private const SETTINGS_CATEGORY = 'ns_all_lightbox';
    private const CONSTANT_NAME = 'plugin.tx_nsalllightbox.settings.type';
    private const JAVASCRIPT_MODULE = '@nitsan/ns-all-lightbox/backend-premium-strip.js';

    private bool $added = false;

    public function __construct(
        private readonly PageRenderer $pageRenderer,
        private readonly SiteFinder $siteFinder,
        private readonly PremiumStrip $premiumStrip,
    ) {}

    public function __invoke(ModifyButtonBarEvent $event): void
    {
        if ($this->added) {
            return;
        }
        // ModifyButtonBarEvent::getRequest() exists since TYPO3 v14.
        $request = method_exists($event, 'getRequest') ? $event->getRequest() : ($GLOBALS['TYPO3_REQUEST'] ?? null);
        if (!$request instanceof ServerRequestInterface) {
            return;
        }
        $route = $request->getAttribute('route');
        $routeIdentifier = $route instanceof Route ? $route->getOption('_identifier') : null;

        if ($routeIdentifier === self::SITE_SETTINGS_ROUTE && $this->siteUsesSet($request)) {
            $this->addStrip('insertIntoSettingsCategory', self::SETTINGS_CATEGORY);
        } elseif ($routeIdentifier === self::CONSTANT_EDITOR_ROUTE) {
            $this->addStrip('insertIntoConstantEditor', self::CONSTANT_NAME);
        }
    }

    private function siteUsesSet(ServerRequestInterface $request): bool
    {
        try {
            $site = $this->siteFinder->getSiteByIdentifier((string)($request->getQueryParams()['site'] ?? ''));
        } catch (SiteNotFoundException) {
            return false;
        }

        return $site->getSettings()->has(self::SET_SETTING_KEY);
    }

    private function addStrip(string $exportName, string $target): void
    {
        $html = $this->premiumStrip->render();
        if ($html === '') {
            return;
        }

        $this->pageRenderer->addCssFile(PremiumStrip::STYLESHEET);
        $this->pageRenderer->getJavaScriptRenderer()->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create(self::JAVASCRIPT_MODULE, $exportName)->invoke(null, $html, $target)
        );
        $this->added = true;
    }
}
