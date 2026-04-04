<?php

use AzGasim\FilamentUnsavedChangesModal\Support\HeroiconResolver;
use Filament\Support\Icons\Heroicon;

it('resolves a valid Heroicon case name', function () {
    expect(HeroiconResolver::fromCaseName('OutlinedExclamationTriangle', Heroicon::ArchiveBox))
        ->toBe(Heroicon::OutlinedExclamationTriangle);
});

it('falls back when the name is unknown or empty', function () {
    expect(HeroiconResolver::fromCaseName('NotARealHeroiconCase', Heroicon::ArchiveBox))
        ->toBe(Heroicon::ArchiveBox);

    expect(HeroiconResolver::fromCaseName('', Heroicon::ArchiveBox))
        ->toBe(Heroicon::ArchiveBox);

    expect(HeroiconResolver::fromCaseName(null, Heroicon::ArchiveBox))
        ->toBe(Heroicon::ArchiveBox);
});
