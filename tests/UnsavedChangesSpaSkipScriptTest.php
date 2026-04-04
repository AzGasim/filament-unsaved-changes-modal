<?php

it('coordinates spa navigate skip with data-skip-unsaved-changes-modal', function (): void {
    $path = dirname(__DIR__) . '/resources/views/hooks/unsaved-changes-script-overrides.blade.php';
    $contents = file_get_contents($path);

    expect($contents)->toBeString()
        ->and($contents)->toContain('pendingSkipNavigateHref')
        ->and($contents)->toContain("anchor.closest('[data-skip-unsaved-changes-modal]')")
        ->and($contents)->toContain('skipForHref === href');
});
