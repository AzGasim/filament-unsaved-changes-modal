# Changelog

## [1.0.3] - 2026-10-15

- Fixed the modal not showing on Filament 5.10 and newer, which renamed its unsaved changes setup functions to `setUpFilamentUnsavedDataChangesAlert` and `setUpFilamentSpaModeUnsavedDataChangesAlert`. The plugin now overrides both the new and the old names (#8).
- Thanks to @BenjaminRayner for the detailed report.

## [1.0.1] - 2026-04-15

- Added Kurdish Sorani (`ckb`) translation support for the unsaved changes modal.
- Thanks to @Hamoi1 for the pull request.

## [1.0.0] - 2026-04-05

- Filament v5 plugin: modal instead of browser `confirm()` for unsaved navigation (SPA and same-origin panel links).
- `data-skip-unsaved-changes-modal` on `<a>` or ancestor to skip the modal.
- Fluent API: `modalWidth()`, `modalIcon()`, `modalIconColor()`, `stayButtonColor()`, `leaveButtonColor()`; `HeroiconResolver`; `DEFAULT_*` and `MODAL_DOM_ID`.
- English and German translations (`navigation.*` keys).

[1.0.3]: https://github.com/AzGasim/filament-unsaved-changes-modal/releases/tag/1.0.3
[1.0.1]: https://github.com/AzGasim/filament-unsaved-changes-modal/releases/tag/1.0.1
[1.0.0]: https://github.com/AzGasim/filament-unsaved-changes-modal/releases/tag/1.0.0
