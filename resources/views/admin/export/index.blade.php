<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Export Page') }}
        </h2>
    </x-slot>
    
    <div class="max-w-[70%] mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- start tab section -->
        <div class="mb-4 border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-md font-medium text-center font-extrabold" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">QR Table</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="sizing-tab" data-tabs-target="#sizing" type="button" role="tab" aria-controls="sizing" aria-selected="false">Transaction Table</button>
                </li>
            </ul>
        </div>
        <div id="myTabContent">
            <div class="" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <livewire:export-qr-details-table/>
            </div>

            <div class="" id="sizing" role="tabpanel" aria-labelledby="dashboard-tab">
                <livewire:export-transaction-table/>
            </div>
        </div>

    </div>
    
</x-app-layout>