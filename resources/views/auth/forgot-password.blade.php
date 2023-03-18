<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your secret code and we will redirect you to password reset page that will allow you to change your password.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Secret code -->
        <div>
            <x-input-label for="secret_code" :value="__('Secret Code')" />
            <x-text-input id="secret_code" class="block mt-1 w-full" type="secret_code" name="secret_code" :value="old('secret_code')" required autofocus />
            <x-input-error :messages="$errors->get('secret_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
