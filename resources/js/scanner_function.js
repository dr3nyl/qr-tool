$(document).scannerDetection({
           
      //https://github.com/kabachello/jQuery-Scanner-Detection

        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
        preventDefault: true,

        endChar: [13],
            onComplete: function(barcode, qty){
            var validScan = true;
       
            // $('#qr_box').html (barcode);
            qr_code.value = barcode;
            qr_transact(event);
        
        } // main callback function ,
        ,
        onError: function(string, qty) {

            // $('#qr_box').html (string);
        // $('#qr_box').val ($('#qr_box').val()  + string);

        
        }
        
        
    });

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
                qr_box.classList.remove('dark:text-white');
                qr_box.classList.remove('text-black');
                qr_box.classList.add('text-red-600');
                data.qr_code = data.qr_code + '<br/><span class="text-xl">[No QR Record Exists!]</span>';
            }else{
                qr_box.classList.remove('text-red-600');
                qr_box.classList.add('dark:text-white');
                qr_box.classList.add('text-black');
            }
            qr_box.innerHTML = data.qr_code;

            // var powergrid = Livewire.find('transaction-table');
            // powergrid.refresh();
            // console.log(powergrid);
            
            Livewire.emit('refreshTransactions');
        }
    };
    xhttp.open("POST", qr_transaction.action, true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formData);

    event.preventDefault();
    return 0;
}
