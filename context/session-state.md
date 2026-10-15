# ns_all_lightbox — Session state

## 2026-10-14 — ns_license integration + premium strip + agent context

- Working copy on `master` (9a01eec), uncommitted; no feature branch created.
- Added `nitsan/ns-license ^14.5.4` / `ns_license 14.5.4-14.9.99` (effective minimum now TYPO3 12.4.18).
  Version 14.0.0 → 14.1.0. First PHP classes: PSR-4 `NITSAN\NsAllLightbox\` added to `composer.json`.
- Premium strip with "Start Free Trial" → ns_license module `?trial=ns_all_lightbox#free-section` in the site
  settings editor and the Constant Editor (user chose both), team-wide wording and design
  (see `features/premium-cta.md`).
- Verified live on TYPO3 14.3.7 classic (temporary activation via `PackageStates.php`, set added to the camino
  site, temporary extension template on page 7, temporary system-maintainer admin; all removed, config files
  restored byte-identical). PHP 8.4 and 8.1 lint clean.
- Created agent context (`AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/`); no previous context existed.
- Open: ns_license 14.5.4 not yet published; v12/v13 not tested; frontend only code-read.

## 2026-10-15 — Context audit

- 2026-10-15: corrected "Fancybox/Swipebox have no init call" (all three jQuery libraries get `footerData`
  init scripts), per-library grouping and title markup; added double Featherlight init, set without
  dependencies, lightbox2 assets also loading on case-insensitive file systems (code-read).
