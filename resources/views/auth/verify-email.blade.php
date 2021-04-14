<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <img src="{{ asset('images/icon-96x96.png') }}" alt="logo">
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Vous devez cliquer sur le lien que nous vous avons envoyé par mail pour vérifier vos e-mail avant de pouvoir vous connecter.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Un nouveau mail vous a été envoyé. Veuillez consulter vos mails et utiliser le lien pour vous connecter.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Réenvoyer l\'e-mail de vérification') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Déconnexion') }}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
