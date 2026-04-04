# Changelog

All notable changes to `filament-unsaved-changes-modal` will be documented in this file.

## Unreleased

- **Breaking:** Removed `config/unsaved-changes-modal.php` and all config keys. Use plugin fluent methods and `DEFAULT_*` constants on `FilamentUnsavedChangesModalPlugin` for defaults.
- Modal DOM id is not configurable except by publishing views; see `MODAL_DOM_ID`.
- Plugin fluent API: `modalWidth()`, `modalIcon()`, `modalIconColor()`, `stayButtonColor()`, `leaveButtonColor()`; `HeroiconResolver` for icon case names.
- Translations: `spa.*` renamed to `navigation.*` (republish or update custom lang files).
- Safer link handling: block `javascript:` / `data:` / `vbscript:` hrefs (case-insensitive trim); only allow `http:` / `https:` resolved URLs; optional chaining on modal actions; try/catch around `resolveLivewireComponentUsing()`.
- Plugin: `make()` returns `new static`; `get()` resolves via `filament()` using `ID` constant.

## 1.0.0 - 202X-XX-XX

- initial release
