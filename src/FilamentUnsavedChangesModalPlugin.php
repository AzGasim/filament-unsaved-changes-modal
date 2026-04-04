<?php

namespace AzGasim\FilamentUnsavedChangesModal;

use AzGasim\FilamentUnsavedChangesModal\Support\HeroiconResolver;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;
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

    public const DEFAULT_MODAL_WIDTH = 'lg';

    public const DEFAULT_MODAL_ICON_COLOR = 'warning';

    public const DEFAULT_STAY_BUTTON_COLOR = 'gray';

    public const DEFAULT_LEAVE_BUTTON_COLOR = 'danger';

    protected ?string $modalWidth = null;

    /**
     * Heroicon enum case name (e.g. `OutlinedExclamationTriangle`).
     */
    protected ?string $modalIcon = null;

    protected ?string $modalIconColor = null;

    protected ?string $stayButtonColor = null;

    protected ?string $leaveButtonColor = null;

    public function getId(): string
    {
        return self::ID;
    }

    /**
     * Filament modal width: `xs`, `sm`, `md`, `lg`, `xl`, `2xl`, …
     */
    public function modalWidth(string $width): static
    {
        $this->modalWidth = $width;

        return $this;
    }

    /**
     * @param  string  $heroiconCaseName  PHP case name from {@see Heroicon} (e.g. `OutlinedExclamationTriangle`).
     */
    public function modalIcon(string $heroiconCaseName): static
    {
        $this->modalIcon = $heroiconCaseName;

        return $this;
    }

    /**
     * Semantic color for the modal icon: `primary`, `warning`, `danger`, …
     */
    public function modalIconColor(string $color): static
    {
        $this->modalIconColor = $color;

        return $this;
    }

    public function stayButtonColor(string $color): static
    {
        $this->stayButtonColor = $color;

        return $this;
    }

    public function leaveButtonColor(string $color): static
    {
        $this->leaveButtonColor = $color;

        return $this;
    }

    public function getModalWidth(): string
    {
        return $this->modalWidth ?? self::DEFAULT_MODAL_WIDTH;
    }

    public function getModalIcon(): Heroicon
    {
        return HeroiconResolver::fromCaseName($this->modalIcon, Heroicon::OutlinedExclamationTriangle);
    }

    public function getModalIconColor(): string
    {
        return $this->modalIconColor ?? self::DEFAULT_MODAL_ICON_COLOR;
    }

    public function getStayButtonColor(): string
    {
        return $this->stayButtonColor ?? self::DEFAULT_STAY_BUTTON_COLOR;
    }

    public function getLeaveButtonColor(): string
    {
        return $this->leaveButtonColor ?? self::DEFAULT_LEAVE_BUTTON_COLOR;
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
                fn (): Htmlable => view(
                    'filament-unsaved-changes-modal::components.unsaved-changes-navigation-modal',
                    ['plugin' => $this],
                ),
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
