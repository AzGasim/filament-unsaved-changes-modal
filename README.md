# Filament Unsaved Changes Modal

[![Latest Version on Packagist](https://img.shields.io/packagist/v/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)

Filament v5 plugin that replaces the browser `confirm()` used for **SPA in-panel navigation** when a form has unsaved changes, with a **Filament modal** (same dirty-detection logic as core). Closing the browser tab still uses the native `beforeunload` prompt (browser limitation). See [Filament unsaved changes alerts](https://filamentphp.com/docs/5.x/panel-configuration#unsaved-changes-alerts).

## Installation

```bash
composer require azgasim/filament-unsaved-changes-modal
```

Laravel auto-discovers [`FilamentUnsavedChangesModalServiceProvider`](src/FilamentUnsavedChangesModalServiceProvider.php). Register the plugin on your panel (e.g. in `App\Providers\Filament\AdminPanelProvider`):

```php
use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(FilamentUnsavedChangesModalPlugin::make());
}
```

Publish the config (optional) to change the modal DOM id (`spa_navigation_modal_id`):

```bash
php artisan vendor:publish --tag="filament-unsaved-changes-modal-config"
```

Publish [translations](resources/lang/en/unsaved-changes-modal.php) with `filament-unsaved-changes-modal-translations`. Enable SPA (`->spa()`) and unsaved alerts (`->unsavedChangesAlerts()`) on your panel so the modal is used.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Aziz Gasim](https://github.com/AzGasim)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
