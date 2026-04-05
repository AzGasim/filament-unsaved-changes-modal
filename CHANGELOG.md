# Changelog

## [Unreleased]

- **Require `filament/filament` ^5.3.5** (patched `filament/tables`; avoids Composer security audit blocks on older 5.x under `prefer-lowest`).
- Filament v5 plugin: modal instead of browser `confirm()` for unsaved navigation (SPA and same-origin panel links).
- `data-skip-unsaved-changes-modal` on `<a>` or ancestor to skip the modal.
- Fluent API: `modalWidth()`, `modalIcon()`, `modalIconColor()`, `stayButtonColor()`, `leaveButtonColor()`; `HeroiconResolver`; `DEFAULT_*` and `MODAL_DOM_ID`.
- English and German translations (`navigation.*` keys).
- `FilamentUnsavedChangesModalPlugin` is `final`; `make()` uses `new self`.
- PHPStan: drop `config/` from scanned paths (package config removed).
- **Breaking:** removed published `config/unsaved-changes-modal.php` — configure via plugin only.
- Safer link handling for non-http(s) hrefs and same-origin checks; defensive error handling in script.
