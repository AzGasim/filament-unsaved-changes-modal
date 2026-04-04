@php
    /** @var \AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin $plugin */
    $modalId = \AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID;
    $modalWidth = $plugin->getModalWidth();
    $modalIcon = $plugin->getModalIcon();
    $modalIconColor = $plugin->getModalIconColor();
    $stayButtonColor = $plugin->getStayButtonColor();
    $leaveButtonColor = $plugin->getLeaveButtonColor();
@endphp

<x-filament::modal
    :id="$modalId"
    :heading="__('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.heading')"
    :description="__('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.body')"
    :width="$modalWidth"
    alignment="center"
    footer-actions-alignment="center"
    :icon="$modalIcon"
    :icon-color="$modalIconColor"
    :close-by-clicking-away="false"
>
    <x-slot name="footer">
        <div class="fi-modal-footer-actions">
            <x-filament::button
                :color="$stayButtonColor"
                type="button"
                x-on:click="window.filamentUnsavedChangesModal?.stay()"
            >
                {{ __('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.stay') }}
            </x-filament::button>

            <x-filament::button
                :color="$leaveButtonColor"
                type="button"
                x-on:click="window.filamentUnsavedChangesModal?.leave()"
            >
                {{ __('filament-unsaved-changes-modal::unsaved-changes-modal.navigation.leave') }}
            </x-filament::button>
        </div>
    </x-slot>
</x-filament::modal>
