@php
    $modalId = config('unsaved-changes-modal.spa_navigation_modal_id');
@endphp

<x-filament::modal
    :id="$modalId"
    :heading="__('filament-unsaved-changes-modal::unsaved-changes-modal.spa.heading')"
    :description="__('filament-unsaved-changes-modal::unsaved-changes-modal.spa.body')"
    width="md"
    :close-by-clicking-away="false"
>
    <x-slot name="footer">
        <x-filament::button
            color="gray"
            type="button"
            x-on:click="window.filamentUnsavedChangesModal && window.filamentUnsavedChangesModal.stay()"
        >
            {{ __('filament-unsaved-changes-modal::unsaved-changes-modal.spa.stay') }}
        </x-filament::button>

        <x-filament::button
            color="danger"
            type="button"
            x-on:click="window.filamentUnsavedChangesModal && window.filamentUnsavedChangesModal.leave()"
        >
            {{ __('filament-unsaved-changes-modal::unsaved-changes-modal.spa.leave') }}
        </x-filament::button>
    </x-slot>
</x-filament::modal>
