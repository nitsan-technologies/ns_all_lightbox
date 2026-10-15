# AGENTS.md — ns_all_lightbox (All In One Lightbox)

Agent router for the All In One Lightbox free extension. Load only what your task needs.

> **Principles:** `context/principles.md`
> **Session log:** `context/session-state.md`
> **Doc index:** `context/docs-map.md`

---

## Always load

| File | Why |
|---|---|
| `context/principles.md` | Guardrails, "nothing that works may break" rule |
| `context/core.md` | Identity, TYPO3/PHP/ns_license constraints, tooling, known issues |

---

## Task router

| Task | Load |
|---|---|
| Lightbox frontend: library choice, TypoScript / site set, image partials, assets | `context/features/lightbox-frontend.md` |
| Premium strip / free trial / ns_license dependency | `context/features/premium-cta.md` |
| Files, classes, TypoScript structure, JavaScript modules | `context/architecture.md` |
| Lint / validate / manual test | `tasks/run-quality.md` |
| Update agent context after a change | `tasks/context-update.md` |

---

## Feature status

| Feature | Status | Agent entry |
|---|---|---|
| Click-enlarge images of fluid_styled_content open in one of five lightbox libraries | Done (code-read) | `context/features/lightbox-frontend.md` |
| Premium strip in the site settings editor and the Constant Editor + ns_license free-trial deep link | Done (needs ns_license 14.5.4 release) | `context/features/premium-cta.md` |

---

## Quick commands

```bash
cd packages/ns_all_lightbox        # or typo3conf/ext/ns_all_lightbox in Classic mode
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done
composer validate --no-check-publish
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done
cp Resources/Public/JavaScript/backend-premium-strip.js /tmp/check.mjs && node --check /tmp/check.mjs
```
