# Filament Unsaved Changes Modal

[![Latest Version on Packagist](https://img.shields.io/packagist/v/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/azgasim/filament-unsaved-changes-modal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/azgasim/filament-unsaved-changes-modal/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/azgasim/filament-unsaved-changes-modal.svg?style=flat-square)](https://packagist.org/packages/azgasim/filament-unsaved-changes-modal)

Filament v5 plugin that replaces the browser `confirm()` used when a form has unsaved changes (same dirty hash logic as core) with a **Filament modal**.

- **SPA (`->spa()`):** intercepts `livewire:navigate`; after **Leave**, uses `Alpine.navigate()` when available, otherwise `location.assign()`.
- **Non-SPA:** there is no `livewire:navigate`; the browser cannot show a custom UI on `beforeunload`. This package intercepts **left-clicks** on same-origin links inside the panel (`.fi-body`) while the form is dirty, opens the same modal, then navigates with `location.assign()` if the user confirms. **Tab close, refresh, typing a new URL,** and similar still use the native `beforeunload` prompt only.

Requires `->unsavedChangesAlerts()`. SPA mode is optional. See [Filament unsaved changes alerts](https://filamentphp.com/docs/5.x/panel-configuration#unsaved-changes-alerts).

Add `data-skip-unsaved-changes-modal` on a link to bypass the prompt for that anchor.

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

Publish the config (optional) to change the modal width (`modal_width`, Filament width values such as `md`, `lg`, `2xl`). The modal’s HTML id is fixed in code (`FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID`); publish the [views](resources/views) if you must change it.

```bash
php artisan vendor:publish --tag="filament-unsaved-changes-modal-config"
```

Publish [translations](resources/lang/en/unsaved-changes-modal.php) with `filament-unsaved-changes-modal-translations`. Enable unsaved alerts (`->unsavedChangesAlerts()`) on your panel. Add `->spa()` if you use Filament SPA navigation.

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
