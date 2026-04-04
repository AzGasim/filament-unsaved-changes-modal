# Changelog

All notable changes to `filament-unsaved-changes-modal` will be documented in this file.

## Unreleased

- Modal DOM id is no longer configurable; use `FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID` or publish views to change it.
- Translations: `spa.*` renamed to `navigation.*` (republish or update custom lang files).
- Safer link handling: block `javascript:` / `data:` / `vbscript:` hrefs (case-insensitive trim); only allow `http:` / `https:` resolved URLs; optional chaining on modal actions; try/catch around `resolveLivewireComponentUsing()`.
- Plugin: `make()` returns `new static`; `get()` resolves via `filament()` using `ID` constant.

## 1.0.0 - 202X-XX-XX

- initial release
