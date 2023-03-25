<section>
    <div id="qr_box" class="block w-full text-black dark:text-white text-3xl md:text-7xl font-black text-center whitespace mb-10"
    style="word-wrap:break-word; font-size: 10vw;">{!! !empty($latest_transaction)?$latest_transaction:'<i class="text-gray-500">WAITING FOR SCAN..</i>' !!}</div>
    <form id="qr_transaction" method="post" action="{{ route('transact.store') }}" class="mt-6 space-y-6 hidden">
        @csrf
        <x-input-error :messages="$errors->get('qr_details')" class="mt-2" />
        <div>
            <x-text-input id="qr_code" name="qr_code" type="text" value='test qr' class="mt-1 block w-full" required autofocus autocomplete="QR Code" />
            <x-input-error class="mt-2" :messages="$errors->get('qr_code')" />
        </div>
    </form>
</section>
        @vite(['resources/js/jquery.min.js','resources/js/jquery.scannerdetection.js','resources/js/scanner_function.js'])
