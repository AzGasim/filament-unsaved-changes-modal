@php
    $modalId = \AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID;
    $modalWidth = config('unsaved-changes-modal.modal_width', 'lg');
@endphp

<x-filament::modal
    :id="$modalId"
    :heading="__('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.heading')"
    :description="__('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.body')"
    :width="$modalWidth"
    alignment="center"
    footer-actions-alignment="center"
    :icon="\Filament\Support\Icons\Heroicon::OutlinedExclamationTriangle"
    icon-color="warning"
    :close-by-clicking-away="false"
>
    <x-slot name="footer">
        <div class="fi-modal-footer-actions">
            <x-filament::button
                color="gray"
                type="button"
                x-on:click="window.filamentUnsavedChangesModal?.stay()"
            >
                {{ __('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.stay') }}
            </x-filament::button>

            <x-filament::button
                color="danger"
                type="button"
                x-on:click="window.filamentUnsavedChangesModal?.leave()"
            >
                {{ __('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.leave') }}
            </x-filament::button>
        </div>
    </x-slot>
</x-filament::modal>
