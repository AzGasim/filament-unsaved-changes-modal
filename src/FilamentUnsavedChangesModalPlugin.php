<?php

namespace AzGasim\FilamentUnsavedChangesModal;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;

class FilamentUnsavedChangesModalPlugin implements Plugin
{
    public const ID = 'filament-unsaved-changes-modal';

    /**
     * Fixed DOM id for the navigation confirmation modal (open-modal / close-modal).
     * Publish and customize the package views if you need a different id.
     */
    public const MODAL_DOM_ID = 'filament-unsaved-changes-modal-navigation';

    public function getId(): string
    {
        return self::ID;
    }

    public function register(Panel $panel): void
    {
        $panel
            ->renderHook(
                PanelsRenderHook::PAGE_START,
                fn (): Htmlable => view('filament-unsaved-changes-modal::hooks.unsaved-changes-script-overrides'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): Htmlable => view('filament-unsaved-changes-modal::components.unsaved-changes-navigation-modal'),
            );
    }

    public function boot(Panel $panel): void {}

    public static function make(): static
    {
        return new static;
    }

    /**
     * @throws \LogicException When the plugin is not registered on the current panel.
     */
    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(self::ID);

        return $plugin;
    }
}
