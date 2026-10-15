# Feature — Premium strip and ns_license free trial

*Status: Done. Verified live on TYPO3 14.3.7 (2026-10-14): both placements render, trial modal opens with
"Lightbox (ns_all_lightbox)" preselected. Requires ns_license 14.5.4 (deep-link support) to be released.
v12/v13 not tested.*

## Licensing status

Freemium. Premium product (T3Planet catalog): "Lightbox", €99, https://t3planet.de/en/typo3-lightbox-extension
(not linked from the UI; the trial stays inside the TYPO3 backend). Catalog features: five lightbox libraries,
drag-drop image gallery, per-gallery customisation, responsive popups, multiple display effects.

## Dependency

`composer.json` `"nitsan/ns-license": "^14.5.4"`, `ext_emconf.php` `'ns_license' => '14.5.4-14.9.99'`. This
raises the effective minimum to TYPO3 12.4.18 (see `core.md`).

## Placements

The extension has no plugin or module, so the strip sits where the lightbox is configured (user decision,
2026-10-14: both places).

| Place | Condition | Position |
|---|---|---|
| Site settings editor (Sites → Setup → Settings), TYPO3 13+ | Route `site_configuration.editSettings`, site settings contain `ns_all_lightbox.configuration.type` (set included) | Inside `.settings-category[data-key="ns_all_lightbox"]`, below the "All Lightbox" headline, above "Main Configuration" |
| TypoScript → Constant Editor, all majors | Route `web_typoscript_constanteditor`, and the page shows the constant `plugin.tx_nsalllightbox.settings.type` (category `plugin.tx_nsalllightbox` selected) | Below the `<h2>` of that constant group ("Other"), above "Include jQuery Library" |

Coexists with ns_google_sitekit's strip in the same settings editor (verified).

## How it works

- `EventListener\BackendPremiumStrip` listens to `ModifyButtonBarEvent` (registered in `Services.yaml`). The
  request comes from `$event->getRequest()` on v14 and `$GLOBALS['TYPO3_REQUEST']` on v12/v13 (the method does
  not exist there). It adds `PremiumStrip::STYLESHEET` via `PageRenderer::addCssFile()` and
  `JavaScriptModuleInstruction::create('@nitsan/ns-all-lightbox/backend-premium-strip.js', <export>)
  ->invoke(null, $html, $target)`. The export name must be passed to `create()`; otherwise core calls the
  module's `default` export and nothing happens.
- `backend-premium-strip.js`:
  - `insertIntoSettingsCategory(html, categoryKey)` waits for `<typo3-backend-settings-editor>` (Lit, light DOM),
    appends the strip to the category block and re-adds it through a `MutationObserver` when a re-render drops
    it; search hides it together with the category.
  - `insertIntoConstantEditor(html, constantName)` finds the `<code>[constantName]</code>` label in
    `#TypoScriptConstantEditorController` and inserts the strip after the preceding `<h2>`. Other categories get
    no strip.
- Both depend on internal core markup: re-check after TYPO3 updates.
- A `type=user[...]` constant was rejected for the Constant Editor: core hides a constant's input (and the
  strip) until the editor clicks the pencil, and saving would write the dummy constant into the template.

## Strip

- `Backend\PremiumStrip::render()`: `actions-rocket` icon, headline and description on two lines,
  `btn btn-primary` "Start Free Trial →" (the arrow is `aria-hidden` markup). Link = route
  `nitsan_nslicensemodule` + `trial=ns_all_lightbox` + `#free-section`, same frame.
- Labels in `locallang_db.xlf`: `premium.strip.headline` "You're using the free version of NS All Lightbox",
  `premium.strip.description` "Unlock premium features and get more out of NS All Lightbox.",
  `premium.strip.trial` "Start Free Trial".
- `Resources/Public/Css/backend-premium-strip.css`: `.ns-all-lightbox-premium-strip` — team-wide design from
  the 2026-10-14 review (light-blue card `#e7f2fc`, border `#8eb6e8`, 4px `#2b6cb0` left accent, 6px radius,
  padding 14px 18px, `light-dark()` for dark mode, button `#007bff` / hover `#0062cc`); extra top margin inside
  a settings category.
- Measured on v14.3.7: 12px text, 13.2px headline, 12px button. In both narrow columns the button wraps below
  the text (`flex-wrap`).
- ns_license's module requires system maintainer access; other users get access denied after clicking.
