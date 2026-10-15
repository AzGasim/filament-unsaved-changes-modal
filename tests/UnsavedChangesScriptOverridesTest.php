<?php

it('overrides the unsaved changes setup functions of all supported filament versions', function (): void {
    $path = dirname(__DIR__) . '/resources/views/hooks/unsaved-changes-script-overrides.blade.php';
    $contents = file_get_contents($path);

    expect($contents)->toBeString()
        ->and($contents)->toContain('window.setUpFilamentSpaModeUnsavedDataChangesAlert = setUpSpaModeUnsavedDataChangesAlert')
        ->and($contents)->toContain('window.setUpFilamentUnsavedDataChangesAlert = setUpUnsavedDataChangesAlert')
        ->and($contents)->toContain('window.setUpSpaModeUnsavedDataChangesAlert = setUpSpaModeUnsavedDataChangesAlert')
        ->and($contents)->toContain('window.setUpUnsavedDataChangesAlert = setUpUnsavedDataChangesAlert');
});
