<?php

namespace AzGasim\FilamentUnsavedChangesModal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModal
 */
class FilamentUnsavedChangesModal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModal::class;
    }
}
