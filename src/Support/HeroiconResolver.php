<?php

namespace AzGasim\FilamentUnsavedChangesModal\Support;

use Filament\Support\Icons\Heroicon;

final class HeroiconResolver
{
    /**
     * Resolve a Heroicon from the enum case name (e.g. `OutlinedExclamationTriangle`).
     * Unknown or empty values fall back to the default.
     */
    public static function fromCaseName(?string $name, Heroicon $default): Heroicon
    {
        if ($name === null || $name === '') {
            return $default;
        }

        foreach (Heroicon::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return $default;
    }
}
