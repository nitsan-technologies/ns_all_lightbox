# ns_all_lightbox — Architecture

No plugin, content element, table, module or FlexForm. The extension changes how fluid_styled_content renders
images with "Enlarge on click" (`image_zoom`) and adds one backend event listener for the premium strip.

## Configuration

| File | What |
|---|---|
| `Configuration/TCA/Overrides/sys_template.php` | Static template "All In One Lightbox/Modalbox" (`Configuration/TypoScript`) |
| `Configuration/TypoScript/constants.typoscript` | `plugin.tx_nsalllightbox.settings.{jquery,width,height,type}` (Constant Editor category `plugin.tx_nsalllightbox`) |
| `Configuration/TypoScript/setup.typoscript` | Imports `TYPO3/<library>.typoscript` by `type`, popup size into `lib.contentElement.settings.media.popup`, optional jQuery in `page.includeJSLibs.nsfjquery` |
| `Configuration/TypoScript/TYPO3/*.typoscript` | Per library: `lib.contentElement.partialRootPaths.100`, `page.includeCSS`, `page.includeJSFooter`; Fancybox, Swipebox and Featherlight also add an inline jQuery init script in `page.footerData.1000` (Featherlight also `5000`) |
| `Configuration/Sets/NsAllLightBox/` | Site set `nitsan/ns-all-lightbox` ("All Lightbox Sets", no `dependencies`); settings `ns_all_lightbox.configuration.{jquery,width,height,type}` in category `ns_all_lightbox` → `ns_all_lightbox.configuration`; setup mirrors the classic setup with the set settings |
| `Configuration/Services.yaml` | Autowires `Classes/*`; tags `EventListener\BackendPremiumStrip` for `ModifyButtonBarEvent` (tag, not attribute, so it also registers on TYPO3 12) |
| `Configuration/JavaScriptModules.php` | Import map `@nitsan/ns-all-lightbox/` → `Resources/Public/JavaScript/` (backend) |

## Classes

| Class | Role |
|---|---|
| `Backend\PremiumStrip` | Builds the strip HTML + trial URL; `''` when the ns_license route is missing |
| `EventListener\BackendPremiumStrip` | On the site settings editor and the Constant Editor: adds the stylesheet and a JS module instruction that places the strip |

## Views

- `Resources/Private/Partials/<Library>/TYPO3/Media/Type/Image.html` (Lightbox, Fancybox, Darkbox, Swipebox,
  Featherlight): copy of the core partial with a library-specific `<a>` around zoomable images.
- `Resources/Private/Partials/<Library>/TYPO3-7/MediaGallery.html`: unused (see `core.md`).

## Assets

- Frontend: library folders below `Resources/Public/` (`lightbox2`, `fancybox2`, `darkbox`, `swipebox`,
  `featherlight`, `jQuery/jQuery.js`).
- Backend: `Css/backend-premium-strip.css`, `JavaScript/backend-premium-strip.js`.
