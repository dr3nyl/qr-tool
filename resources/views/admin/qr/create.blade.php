<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Page') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[80%] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <livewire:qr-creation-form>
            </div>
        </div>
    </div>

    <div class="">
        <div class="max-w-[80%] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <livewire:qr-generator-page-table/>
            </div>
        </div>
    </div>
</x-app-layout>