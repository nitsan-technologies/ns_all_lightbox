# ns_all_lightbox — Core facts

## Identity

| Item | Value |
|---|---|
| Extension key | `ns_all_lightbox` |
| Composer name | `nitsan/ns-all-lightbox` |
| Title (ext_emconf) / product name | TYPO3 All-in-One Lightbox & Sliders / Lightbox |
| Namespace | `NITSAN\NsAllLightbox\` → `Classes/` (added 2026-10-14; before that the extension had no PHP classes) |
| Version (ext_emconf) | 14.1.0 (latest tag 14.0.0) |
| Repository | https://github.com/nitsan-technologies/ns_all_lightbox (default branch `master`) |
| Licensing status | **Freemium** — this repo is the free version. The NITSAN Free/Freemium sheet needs a Google login; status taken from the T3Planet catalog (`isFree: false` for the premium product) |
| Premium version (T3Planet catalog) | "Lightbox", €99, https://t3planet.de/en/typo3-lightbox-extension |

## Compatibility

| Source | TYPO3 | PHP |
|---|---|---|
| `ext_emconf.php` | `12.4.0-14.9.99` | not declared |
| `composer.json` | `^12 \|\| ^13 \|\| ^14` | not declared |
| ns_license 14.5.4 (dependency) | `12.4.18-14.9.99` | not declared (TYPO3 12.4 needs 8.1+) |

- Effective minimum is **TYPO3 12.4.18 / PHP 8.1** because of ns_license; the declared `12.4.0` lower bound is
  kept as is.

## Dependencies

| Package | Constraint | Why |
|---|---|---|
| `typo3/cms-core` | see above | core |
| `nitsan/ns-license` / `ns_license` | `^14.5.4` / `14.5.4-14.9.99` | TYPO3 Shop module + free-trial deep link (see `features/premium-cta.md`) |
| fluid_styled_content | not declared | The partials override its `Media/Type/Image.html`; without it nothing renders |

Bundled frontend libraries (no package manager): jQuery, lightbox2, Fancybox 2 (+ helpers), Darkbox, Swipebox,
Featherlight (+ gallery).

## Tooling

- No PHPUnit, PHPStan, CS fixer or package.json in the repo.
- CI: `.github/workflows/ter-release.yml` only (publishes tags to TER with tailor on PHP 7.4).
- No Crowdin config; `Resources/Private/Language/locallang_db.xlf` (English) and `de.locallang_db.xlf`.

## Conventions

- TypoScript and Fluid use tabs (some lightbox files use 4 spaces); new PHP files use 4 spaces and
  `declare(strict_types=1)`.
- Backend CSS and JS live in `Resources/Public/Css/` and `Resources/Public/JavaScript/`; the lightbox libraries
  keep their own folders below `Resources/Public/`.

## Known issues (existing, not fixed)

Behaviour details: `features/lightbox-frontend.md`. All code-read.

- Site set `constants.typoscript` imports `Constants.typoscript` (capital C), but the file is
  `constants.typoscript`; on case-sensitive file systems the classic constants are missing in site-set mode.
  The set setup also imports the classic setup, whose conditions and `lib.contentElement` popup size then use
  unresolved `plugin.tx_nsalllightbox` constants; the set's own blocks that follow override the size. Where
  the import does resolve (case-insensitive file systems), the classic default `type = 1` also loads the
  lightbox2 assets next to the library chosen in the set.
- Every library needs jQuery, but jQuery is off by default (constant `jquery = 0`, setting default `false`).
  Without a jQuery loaded by the site, no lightbox opens.
- Featherlight's gallery is initialised twice: `page.footerData.1000` (inside `$(document).ready`) and
  `page.footerData.5000` (immediately, with gallery options).
- `featherlight.typoscript` names its includes `swipebox` / `swipeboxMin`.
- `Resources/Private/Partials/*/TYPO3-7/MediaGallery.html` (TYPO3 7) are not referenced.
- `ext_emconf.php` `author_company` contains a trailing tab.
- Descriptions are stale: both `composer.json` and `ext_emconf.php` advertise sliders (Nivo, Royal Slider,
  OwlCarousel) that the extension does not contain; README badges show v13.1.0 / TYPO3 13; `composer.json` uses
  the deprecated SPDX id `GPL-2.0+`.
