<div id="modal_payment" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog m-100 w-30">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Payment </span>
                </div>
                <div class="float-sm-right text-zero">
                    <div class="d-inline-block float-md-left mr-1 mb-1 align-top">
                        <button class="btn btn-danger btn-xs default" data-dismiss="modal">
                           Tutup (Esc)
                        </button>
                    </div>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="total" />
                    <label class="control-label col-md-5"><h4>Total :</h4></label>
                    <label class="control-label col-md-7" id="total-pay" style="font-weight: bold;text-align: right;font-size: 17px;"></label>   
                </div>
                <div class="row">
                    <label class="control-label col-md-5"><h4>Cash :</h4></label>
                    <input type="text" class="form-control col-md-7" style="font-size: 17px !important; font-weight: bold; text-align: right;" name="cash" id="cash" onkeyup="cekPay(this)" />          
                </div>
                <div class="row" style="padding-top: 10px;">
                    <label class="control-label col-md-5"><h4>Change :</h4></label>
                    <label class="control-label col-md-7" id="change" style="font-weight: bold;text-align: right;font-size: 17px;"></label>
                </div>
                <div class="row">
                    <button class="btn btn-danger btn-sm default col-md-12" type="button" onclick="submitPay()">OK (Enter)</button>  
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>

    function modal_payment_show(subtot) {
        $("#modal_payment").modal({backdrop: 'static'});
        $('#total-pay').text(formatRupiahTxt(subtot.toString(),''));
        $('#total').val(subtot);
        $('#change').text(0);
        $('#cash').val('');
        setTimeout(function() {
            $('#cash').focus();
        }, 1000);

    }

    function cekPay(input){
        var tot = $('#total').val();
        var cash = $('#cash').val().split(".").join(""); //$('#cash').val();

        var change = cash - tot;
        if(change > 0){
            $('#change').text(formatRupiahTxt(change.toString(), ''));
        }else{
            $('#change').text(0);
        }

        var angka = input.value;

        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split           = number_string.split(','),
            sisa            = split[0].length % 3,
            rupiah          = split[0].substr(0, sisa),
            ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
         
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            input.value = rupiah;
    }
  
</script>