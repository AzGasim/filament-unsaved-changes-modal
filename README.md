# Filament Unsaved Changes Modal

[![Latest Version on Packagist](https://img.shields.io/packagist/v/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)
[![Total Downloads](https://img.shields.io/packagist/dt/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)
[![GitHub Tests](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/run-tests.yml?branch=5.x&label=tests&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions?query=workflow%3Arun-tests+branch%3A5.x)
[![Code style](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/fix-php-code-style-issues.yml?branch=5.x&label=code%20style&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions)

In the **Filament panel**, leaving a dirty form shows a **Filament modal** instead of the browser’s blocking dialog. **Reload** and **closing the tab** still use the **browser’s normal native prompt** (that cannot be a custom modal).

Uses the same behaviour as Filament’s [`unsavedChangesAlerts()`](https://filamentphp.com/docs/5.x/panel-configuration#unsaved-changes-alerts); this package only swaps the confirmation UI in the panel.

<p align="center">
  <img src="https://raw.githubusercontent.com/azgasim/filament-unsaved-changes-modal/5.x/art/readme-preview.png" alt="Unsaved changes: Filament modal instead of the browser dialog" width="720">
</p>

_Screenshot file in the repo: [`art/readme-preview.png`](art/readme-preview.png). The URL above loads on Packagist and in IDE previews; GitHub renders the same image from the repo._

| PHP      | ^8.2   |
| -------- | ------ |
| Filament | ^5.0   |

## Installation

```bash
composer require azgasim/filament-unsaved-changes-modal
```

Laravel auto-discovers the package service provider.

## Usage

You need **both** `unsavedChangesAlerts()` and this plugin on the same panel.

**In your `PanelProvider::panel()` method** (keep your existing `->path()`, `->login()`, middleware, etc.):

```php
use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;

return $panel
    // … your existing panel configuration …
    ->unsavedChangesAlerts()
    ->plugins([
        FilamentUnsavedChangesModalPlugin::make(),
    ]);
```

## Customization

### Modal appearance

Unconfigured values fall back to [`DEFAULT_*` constants](src/FilamentUnsavedChangesModalPlugin.php).

```php
FilamentUnsavedChangesModalPlugin::make()
    ->modalWidth('xl')
    ->modalIcon('OutlinedExclamationTriangle')
    ->modalIconColor('danger')
    ->stayButtonColor('gray')
    ->leaveButtonColor('warning')
```

| Method | Values |
| ------ | ------ |
| `modalWidth()` | `xs`, `sm`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl`, `full`, `min`, `max`, `fit`, `prose`, `screen-sm`, `screen-md`, `screen-lg`, `screen-xl`, `screen-2xl`, `screen` — same string values as Filament’s `Width` enum (`Filament\Support\Enums\Width`). |
| `modalIcon()` | `Heroicon::OutlinedExclamationTriangle` or `'OutlinedExclamationTriangle'` (not `o-exclamation-triangle`) |
| `modalIconColor()`, `stayButtonColor()`, `leaveButtonColor()` | `primary`, `success`, `danger`, `warning`, `info`, `gray`, … (`$panel->colors()` keys) |

### Translations

Keys: `filament-unsaved-changes-modal::unsaved-changes-modal.navigation.*` ([English file](resources/lang/en/unsaved-changes-modal.php)).

```bash
php artisan vendor:publish --tag="filament-unsaved-changes-modal-translations"
```

### Views

Only if you want to change the Blade markup, copy the package views into your app:

```bash
php artisan vendor:publish --tag="filament-unsaved-changes-modal-views"
```

If you change the modal’s DOM `id` in a published view, keep it in sync with [`MODAL_DOM_ID`](src/FilamentUnsavedChangesModalPlugin.php) and the [script hook view](resources/views/hooks/unsaved-changes-script-overrides.blade.php) (the JS opens/closes the modal by that `id`).

### Skipping the prompt for a link

Add `data-skip-unsaved-changes-modal` on the `<a>` **or on any ancestor element** (the listener uses `closest(...)`).

Works for **normal full-page navigation** and for **Filament SPA / Livewire `navigate`**, as long as the navigation is triggered from a **left-click** on that link (same rules as above: in `.fi-body`, same origin, `http`/`https`, no modified keys / `_blank` / `download`). Programmatic `Alpine.navigate(url)` without a preceding qualifying click is not skipped.

## Testing

```bash
composer test
```

Coverage (requires PCOV or Xdebug): `composer test:coverage`

## Changelog

[CHANGELOG.md](CHANGELOG.md)

## Contributing

[CONTRIBUTING.md](.github/CONTRIBUTING.md)

## Security

[SECURITY.md](.github/SECURITY.md)

## Credits

- [Aziz Gasim](https://github.com/AzGasim)
- [Contributors](https://github.com/azgasim/filament-unsaved-changes-modal/graphs/contributors)

## License

[MIT](LICENSE.md)
