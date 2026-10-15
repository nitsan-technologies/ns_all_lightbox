# Run quality checks

The repo has no PHPUnit, PHPStan or CS config. Available checks:

```bash
# PHP syntax; also run once with PHP 8.1, the lowest version TYPO3 12 supports
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done

# composer.json
composer validate --no-check-publish

# XLF well-formedness
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done

# Backend JS module (ES module syntax)
cp Resources/Public/JavaScript/backend-premium-strip.js /tmp/check.mjs && node --check /tmp/check.mjs
```

## Manual test (per TYPO3 major 12 / 13 / 14)

1. Site set: add `nitsan/ns-all-lightbox` to a site (v13+). Sites → Setup → Settings: strip below the
   "All Lightbox" headline; searching for another setting hides it with the category. A site without the set
   shows no strip.
2. Classic: include the static template on a page. TypoScript → Constant Editor, category
   `plugin.tx_nsalllightbox`: strip above the lightbox constants; other categories show none.
3. "Start Free Trial" (as system maintainer) opens the ns_license module and its trial modal with
   "Lightbox (ns_all_lightbox)" preselected. Cancel; don't start a trial.
4. Open a few other backend modules to make sure the button-bar listener adds nothing elsewhere.
5. Frontend, per library 1–5 (with jQuery available): a Text & Images element with "Enlarge on click" opens
   the image in the chosen lightbox; with lightbox2, Fancybox and Darkbox images in one element form one group.
6. Check light and dark backend themes.

Remove test templates, site set dependencies and content afterwards.
