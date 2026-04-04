<?php

namespace AzGasim\FilamentUnsavedChangesModal;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;

class FilamentUnsavedChangesModalPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-unsaved-changes-modal';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->renderHook(
                PanelsRenderHook::PAGE_START,
                fn (): Htmlable => view('filament-unsaved-changes-modal::hooks.spa-unsaved-script'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): Htmlable => view('filament-unsaved-changes-modal::components.unsaved-changes-navigation-modal'),
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
