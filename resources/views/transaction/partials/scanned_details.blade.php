<section>
    <div id="qr_box" class="block w-full text-black dark:text-white text-3xl md:text-7xl font-black text-center whitespace"
    style="word-wrap:break-word"><i class="text-gray-500">WAITING FOR SCAN..</i></div>
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
<script type="text/javascript" charset="UTF-8">

    // $(document).scannerDetection({
           
    //   //https://github.com/kabachello/jQuery-Scanner-Detection

    //     timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    //     avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
    //     preventDefault: true,

    //     endChar: [13],
    //         onComplete: function(barcode, qty){
    //    validScan = true;
       
       
    //         $('#scannerInput').val (barcode);
        
    //     } // main callback function ,
    //     ,
    //     onError: function(string, qty) {

    //     $('#qr_box').val ($('#qr_box').val()  + string);

        
    //     }
        
        
    // });

    // document.getElementById("qr_transaction").addEventListener("submit", qr_transact);
    // var qr_transaction = document.getElementById('qr_transaction');
    // var qr_code = document.getElementById('qr_code');
    // var qr_box = document.getElementById("qr_box");

    // function qr_transact(event){
    //     const formData = new FormData(qr_transaction);
    //     console.log(formData);
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onload = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             console.log(xhttp);
    //             var data = JSON.parse(xhttp.response);

    //             if(data.exists == false){
    //                 qr_box.classList.remove('dark:text-white');
    //                 qr_box.classList.remove('text-black');
    //                 qr_box.classList.add('text-red-600');
    //                 data.qr_code = data.qr_code + '<br/><span class="text-xl">[No QR Record Exists!]</span>';
    //             }else{
    //                 qr_box.classList.remove('text-red-600');
    //                 qr_box.classList.add('dark:text-white');
    //                 qr_box.classList.add('text-black');
    //             }
    //             qr_box.innerHTML = data.qr_code;

    //             // var powergrid = Livewire.find('transaction-table');
    //             // powergrid.refresh();
    //             // console.log(powergrid);
                
    //             Livewire.emit('refreshTransactions');
    //         }
    //     };
    //     xhttp.open("POST", qr_transaction.action, true);
    //     // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //     xhttp.send(formData);

    //     event.preventDefault();
    //     return 0;
    // }


    // var lastKeyPressTime = 0;
    // var barcode = '';
    // document.addEventListener('keydown', function(event) {
    //   var currentTime = new Date().getTime();
    //   var elapsedTime = currentTime - lastKeyPressTime;

    //   if (elapsedTime > 1000) { // assume it's a new barcode if time elapsed between key presses is greater than 100ms
    //     barcode = '';
    //   }

    //   if (event.keyCode == 13) { // check if key code is Enter
    //     if (barcode.length > 0) { // check if barcode has been scanned
    //         console.log(utf16ToUtf8(barcode));
    //         qr_box.innerHTML = barcode;
    //         qr_box.innerHTML += '<br>'+utf16ToUtf8(barcode);
    //         qr_box.innerHTML += '<br>'+decode_utf8(utf16ToUtf8(barcode));
    //         qr_box.innerHTML += '<br>'+Utf8ArrayToStr(toUTF8Array(barcode));
    //         return false;
    //         qr_code.value = barcode;
    //         qr_transact(event);
    //     }
    //     barcode = '';
    //   } else {
    //     var char = String.fromCharCode(event.which);
    //         console.log(utf16ToUtf8(char));
    //     barcode += char;
    //   }

    //   lastKeyPressTime = currentTime;
    // });
</script>
