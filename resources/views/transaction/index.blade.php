<x-transaction-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Transaction') }} <span id="clock"></span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-4 space-y-6">
            <div class="p-2 sm:p-4 flex items-center justify-center bg-white dark:bg-gray-800 shadow sm:rounded-lg "
            style="min-height: 200px">
                <div class="max-w-screen overflow-hidden">
                    @include('transaction.partials.scanned_details')
                </div>
            </div>

            <div class="p-4 sm:p-8 flex items-center justify-center bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-3xl">
                    <livewire:transaction-table/>
                </div>
            </div>
        </div>
    </div>
</x-transaction-layout>

<script type="text/javascript">
    function updateTime() {
      let now = new Date();
      let hours = now.getHours();
      let minutes = now.getMinutes();
      let seconds = now.getSeconds();

      hours = hours < 10 ? "0" + hours : hours;
      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      let time = hours + ":" + minutes + ":" + seconds;

      document.getElementById("clock").innerHTML = time;
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
