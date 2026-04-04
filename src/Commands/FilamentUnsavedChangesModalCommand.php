<?php

namespace AzGasim\FilamentUnsavedChangesModal\Commands;

use Illuminate\Console\Command;

class FilamentUnsavedChangesModalCommand extends Command
{
    public $signature = 'filament-unsaved-changes-modal';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
