<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code Page') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-[70%] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <livewire:qr-creation-form>
            </div>
        </div>
    </div>

    <div class="">
        <div class="max-w-[70%] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <livewire:qr-generator-page-table/>
            </div>
        </div>
    </div>


    <script>
    window.addEventListener('confirm-delete', event => {
        console.log(event);
        var qr_details = event.detail;
        console.log(qr_details);
        var qr_name = '';
        if(qr_details.length > 0){
            for (var i = qr_details.length - 1; i >= 0; i--) {
                qr_name += i==0?qr_details[i].qr_name:qr_details[i].qr_name+', ';
            }
            if(confirm('Confirm delete: ' + qr_name)){
                Livewire.emit('deleteQR', qr_details);
            }
        }
    })
    </script>
</x-app-layout>