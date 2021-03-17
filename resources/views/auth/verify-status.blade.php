<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Merci de votre visite mais votre compte n\'est pas encore activé pour le moment. Veuillez réessayer ultérieurement.') }}
        </div>

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Déconnexion') }}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
