<?php

use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

it('registers spa unsaved changes render hooks on the panel', function () {
    $panel = Panel::make()
        ->id('admin')
        ->path('admin');

    FilamentUnsavedChangesModalPlugin::make()->register($panel);

    $property = (new ReflectionClass($panel))->getProperty('renderHooks');
    $property->setAccessible(true);
    $hooks = $property->getValue($panel);

    expect($hooks[PanelsRenderHook::PAGE_START][''])->toHaveCount(1);
    expect($hooks[PanelsRenderHook::BODY_END][''])->toHaveCount(1);
});
