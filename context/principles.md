# ns_all_lightbox — Operating Principles

*Every change to code, context or docs must serve the goals below.*

---

## Goal 1 — Nothing that works may break

The extension declares TYPO3 v12.4–v14 (Composer and Classic mode), see `core.md`.

- Keep every declared major working. Follow the existing version switches (`method_exists($event, 'getRequest')`
  in `BackendPremiumStrip`, `enum_exists(IconSize::class)` in `PremiumStrip`) instead of inventing new ones.
- Lowest PHP is 8.1 (TYPO3 12): no PHP 8.2+ syntax such as `readonly` classes or DNF types.
- Both configuration paths must keep working: the classic static template (`plugin.tx_nsalllightbox.settings.*`
  constants) and the site set (`ns_all_lightbox.configuration.*` settings). A change to one usually needs the
  same change in the other.
- The partials override core fluid_styled_content `Media/Type/Image.html`; keep them in step with the core
  partial when it changes.
- Prefer the smallest change that fixes the root cause. No drive-by refactors.
- Run `tasks/run-quality.md` and re-test the affected flow before claiming done.

## Goal 2 — Token-cost efficiency (agent context)

- **DRY context:** each fact lives in exactly ONE file. Reference, don't copy.
- **Load on demand:** read `context/features/<area>.md` for the task, not everything.
- **Prune as you go:** keep `context/session-state.md` short.

## Goal 3 — Accuracy and trust

- Answer from context + code, never from invented API, table or field names.
- Mark statements as verified live or code-read; conflicting facts across files = fix the source file.

---

## Guardrails (non-negotiable)

- The premium strip is placed by JavaScript into core markup that has no public hook (settings editor categories,
  Constant Editor form). Re-check both placements after TYPO3 updates (see `features/premium-cta.md`).
- Installing the premium version through ns_license replaces this extension's folder: never keep user data in
  files below the extension.
- Do not change ns_license from an ns_all_lightbox task; reuse its module and trial modal.
- All UI text goes into `Resources/Private/Language/locallang_db.xlf`, no hard-coded labels. Only the English
  source file is edited; `de.locallang_db.xlf` is not touched.

---

## Apply this whenever you

- Edit `context/` or `AGENTS.md`
- Land a feature or bugfix (update the matching `context/features/*.md` + `session-state.md`)
