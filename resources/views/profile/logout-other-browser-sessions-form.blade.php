<x-jet-action-section>
    <x-slot name="title">
        {{-- {{ __('Historique d\'utilisation') }} --}}
    </x-slot>

    <x-slot name="description">
        {{-- __('Manage and logout your active sessions on other browsers and devices.') --}}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('List des périphériques sur lequel vous vous êtes déjà connecter. Vous pouvez vous deconnecter sur tous les tous navigateurs si nécéssaire.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                <!-- Other Browser Sessions -->
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <i class="fa fa-desktop fa-2x"></i>
                            @else
                                <i class="fa fa-mobile"></i>
                            @endif
                        </div>

                        <div class="ml-3">
                            <div class="text-sm text-gray-600">
                                {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('Cet périphérique') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-5">
            <x-jet-button wire:click="confirmLogout" wire:loading.attr="disabled">
                {{ __('Se déconnecter des autres périphériques') }}
            </x-jet-button>

            <x-jet-action-message class="ml-3" on="loggedOut">
                {{ __('Effectué avec succès') }}
            </x-jet-action-message>
        </div>

        <!-- Logout Other Devices Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingLogout">
            <x-slot name="title">
                {{ __('Se déconnecter des autres périphériques') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Veuillez saissir votre mot de passe pour confirmer la déconnection des autres périphériques.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                    {{ __('Ne jamais demander') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2"
                            wire:click="logoutOtherBrowserSessions"
                            wire:loading.attr="disabled">
                    {{ __('Se déconnecter') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
