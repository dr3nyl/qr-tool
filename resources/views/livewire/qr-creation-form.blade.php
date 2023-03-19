<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('QR Creation Form') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Create your QR code.") }}
        </p>
    </header>

    <div class="flex flex-row items-center mt-8">
        <form class="flex flex-row space-x-4" wire:submit.prevent="submitForm">

            @csrf

            <x-input-error :messages="$errors->get('qr_code')" class="mt-2" />
            <div>
                <x-input-label for="part_number" :value="__('Part Number')" />
                <x-text-input id="part_number" wire:model="part_number" type="text" class="mt-1 block w-full" required autofocus autocomplete="part number" />
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-input-label for="date_code" :value="__('Date Code')" />
                <x-text-input id="date_code" wire:model="date_code" type="text" class="mt-1 block w-full" required autocomplete="date code" />
                <x-input-error class="mt-2" :messages="$errors->get('date_code')" />
            </div>
            <div>
                <x-input-label for="vendor_code" :value="__('Vendor Code')" />
                <x-text-input id="vendor_code" wire:model="vendor_code" type="text" class="mt-1 block w-full" required autocomplete="vendor code" />
                <x-input-error class="mt-2" :messages="$errors->get('vendor_code')" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>
</section>
