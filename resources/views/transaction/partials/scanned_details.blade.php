<section>
    <div id="qr_box" class="mt-1 block w-full text-white text-7xl font-black"></div>
    <form id="qr_transaction" method="post" action="{{ route('transact.store') }}" class="mt-6 space-y-6 hidden">
        @csrf
        <x-input-error :messages="$errors->get('qr_details')" class="mt-2" />
        <div>
            <x-text-input id="qr_code" name="qr_code" type="text" value='test qr' class="mt-1 block w-full" required autofocus autocomplete="QR Code" />
            <x-input-error class="mt-2" :messages="$errors->get('qr_code')" />
        </div>
        

        <div class="flex items-center gap-4">
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script type="text/javascript">

    document.onkeypress = function (e) {
        e = e || window.event;
        // use e.keyCode
        console.log(e.keyCode);
        // if(e.keyCode === 13){
        //     qr_transact(event);
        // }
    };

    document.getElementById("qr_transaction").addEventListener("submit", qr_transact);
    var qr_transaction = document.getElementById('qr_transaction');
    var qr_code = document.getElementById('qr_code');
    var qr_box = document.getElementById("qr_box");

    function qr_transact(event){
        const formData = new FormData(qr_transaction);
        console.log(formData);
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp);
                var data = JSON.parse(xhttp.response);

                if(data.exists == false){
                    qr_box.classList.remove('text-white');
                    qr_box.classList.add('text-red-600');
                    data.qr_code = data.qr_code + '<br/>[NO QR Record Exists!]';
                }else{
                    qr_box.classList.remove('text-red-600');
                    qr_box.classList.add('text-white');
                }
                qr_box.innerHTML = data.qr_code;
            }
        };
        xhttp.open("POST", qr_transaction.action, true);
        // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(formData);

        event.preventDefault();
        return 0;
    }


    var lastKeyPressTime = 0;
    var barcode = '';
    document.addEventListener('keydown', function(event) {
      var currentTime = new Date().getTime();
      var elapsedTime = currentTime - lastKeyPressTime;

      if (elapsedTime > 1000) { // assume it's a new barcode if time elapsed between key presses is greater than 100ms
        barcode = '';
      }

      if (event.keyCode == 13) { // check if key code is Enter
        if (barcode.length > 0) { // check if barcode has been scanned
            qr_code.value = barcode;
            qr_transact(event);
        }
        barcode = '';
      } else {
        var char = String.fromCharCode(event.keyCode);
        barcode += char;
      }

      lastKeyPressTime = currentTime;
    });

</script>