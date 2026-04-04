# Filament Unsaved Changes Modal

[![Latest Version on Packagist](https://img.shields.io/packagist/v/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)
[![Total Downloads](https://img.shields.io/packagist/dt/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)
[![GitHub Tests](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code style](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions)

In the **Filament panel**, leaving a dirty form shows a **Filament modal** instead of the browser’s blocking dialog. **Reload** and **closing the tab** still use the **browser’s normal native prompt** (that cannot be a custom modal).

Uses the same behaviour as Filament’s [`unsavedChangesAlerts()`](https://filamentphp.com/docs/5.x/panel-configuration#unsaved-changes-alerts); this package only swaps the confirmation UI in the panel.

| PHP      | ^8.2   |
| -------- | ------ |
| Filament | ^5.0   |

## Installation

```bash
composer require azgasim/filament-unsaved-changes-modal
```

Laravel auto-discovers the package service provider.

## Usage

1. Enable unsaved-change alerts on your panel:

    ```php
    $panel->unsavedChangesAlerts();
    ```

2. Register the plugin:

    ```php
    use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;

    $panel->plugins([
        FilamentUnsavedChangesModalPlugin::make(),
    ]);
    ```

## Customization

### Modal appearance

Unconfigured values fall back to [`DEFAULT_*`](src/FilamentUnsavedChangesModalPlugin.php).

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
| `modalWidth()` | `xs`, `sm`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl`, `full`, `min`, `max`, `fit`, `prose`, `screen-sm`, `screen-md`, `screen-lg`, `screen-xl`, `screen-2xl`, `screen` |
| `modalIcon()` | `Heroicon::OutlinedExclamationTriangle` or `'OutlinedExclamationTriangle'` (not `o-exclamation-triangle`) |
| `modalIconColor()`, `stayButtonColor()`, `leaveButtonColor()` | `primary`, `success`, `danger`, `warning`, `info`, `gray`, … (`$panel->colors()` keys) |

### Translations

Keys: `filament-unsaved-changes-modal::unsaved-changes-modal.navigation.*` ([English file](resources/lang/en/unsaved-changes-modal.php)).

```bash
php artisan vendor:publish --tag="filament-unsaved-changes-modal-translations"
```

### Views

```bash
php artisan vendor:publish --tag="filament-unsaved-changes-modal-views"
```

If you change the modal’s DOM id in a published view, keep it in sync with [`FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID`](src/FilamentUnsavedChangesModalPlugin.php) and the script hook view.

### Skipping the prompt for a link

Add `data-skip-unsaved-changes-modal` on the `<a>`.

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
