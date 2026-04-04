<?php

use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;
use Filament\Support\Icons\Heroicon;

it('uses package defaults when nothing is chained', function () {
    $plugin = FilamentUnsavedChangesModalPlugin::make();

    expect($plugin->getModalWidth())->toBe(FilamentUnsavedChangesModalPlugin::DEFAULT_MODAL_WIDTH)
        ->and($plugin->getModalIcon())->toBe(Heroicon::OutlinedExclamationTriangle)
        ->and($plugin->getModalIconColor())->toBe(FilamentUnsavedChangesModalPlugin::DEFAULT_MODAL_ICON_COLOR)
        ->and($plugin->getStayButtonColor())->toBe(FilamentUnsavedChangesModalPlugin::DEFAULT_STAY_BUTTON_COLOR)
        ->and($plugin->getLeaveButtonColor())->toBe(FilamentUnsavedChangesModalPlugin::DEFAULT_LEAVE_BUTTON_COLOR);
});

it('uses fluent values when chained', function () {
    $plugin = FilamentUnsavedChangesModalPlugin::make()
        ->modalWidth('2xl')
        ->modalIcon('ArchiveBox')
        ->modalIconColor('info')
        ->stayButtonColor('primary')
        ->leaveButtonColor('warning');

    expect($plugin->getModalWidth())->toBe('2xl')
        ->and($plugin->getModalIcon())->toBe(Heroicon::ArchiveBox)
        ->and($plugin->getModalIconColor())->toBe('info')
        ->and($plugin->getStayButtonColor())->toBe('primary')
        ->and($plugin->getLeaveButtonColor())->toBe('warning');
});
