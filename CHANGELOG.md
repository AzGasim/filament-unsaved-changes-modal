# Changelog

Notable changes to `filament-unsaved-changes-modal`.  
There is **no tagged release yet** — when you publish **v1.0.0** (or another version), add a dated section and keep new work here under **[Unreleased]**.

## [Unreleased]

- Respect `data-skip-unsaved-changes-modal` when the panel uses SPA / `livewire:navigate` (capture-phase click stores the target URL; the navigate handler skips the modal when it matches).
- Include `art/` in the Composer dist (removed `export-ignore` for `/art`); README screenshot uses a stable `raw.githubusercontent.com` URL.
- **Breaking:** removed `config/unsaved-changes-modal.php` and all package config keys — use the plugin’s fluent methods and `DEFAULT_*` constants on `FilamentUnsavedChangesModalPlugin` instead.
- Modal DOM `id` is fixed unless you publish views; see `FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID`.
- Plugin fluent API: `modalWidth()`, `modalIcon()`, `modalIconColor()`, `stayButtonColor()`, `leaveButtonColor()`; `HeroiconResolver` for icon case names.
- Translation keys: `spa.*` renamed to `navigation.*` (republish or update custom language files).
- `FilamentUnsavedChangesModalPlugin::make()` returns `new static`; `get()` resolves via `filament()` using the `ID` constant.
- Safer link handling: ignore `javascript:` / `data:` / `vbscript:` hrefs; only same-origin `http:` / `https:` navigation is intercepted; optional chaining on modal actions; `try` / `catch` around `resolveLivewireComponentUsing()`.
