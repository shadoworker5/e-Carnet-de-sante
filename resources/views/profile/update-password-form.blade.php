<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{-- __('Ensure your account is using a long, random password to stay secure.') --}}
    </x-slot>

    <x-slot name="form">
        <div>
            <x-jet-label for="current_password" value="{{ __('Mot de passe actuel') }}" />
            <x-jet-input id="current_password" type="password" class="form-control" wire:model.defer="state.current_password" autocomplete="current-password" />
            <div class="text-danger">
                <x-jet-input-error for="current_password" class="mt-2" />
            </div>
        </div>

        <div>
            <x-jet-label for="password" value="{{ __('Nouveau mot de passe') }}" />
            <x-jet-input id="password" type="password" class="form-control" wire:model.defer="state.password" autocomplete="new-password" />
            <div class="text-danger">
                <x-jet-input-error for="password" class="mt-2" />
            </div>
        </div>

        <div>
            <x-jet-label for="password_confirmation" value="{{ __('Confirmer mot de passe') }}" />
            <x-jet-input id="password_confirmation" type="password" class="form-control" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <div class="text-danger">
                <x-jet-input-error for="password_confirmation" class="mt-2" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
