<div id="modal_payment" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Payment </span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="total" />
                    <label class="control-label col-md-3"><h4>Total :</h4></label>
                    <h4><label class="control-label col-md-9" id="total-pay" style="font-weight: bold"></label></h4>    
                </div>
                <div class="row">
                    <label class="control-label col-md-3"><h4>Cash :</h4></label>
                    <input type="text" class="form-control col-md-9" name="cash" id="cash" onkeyup="cekPay()" />          
                </div>
                <div class="row" style="padding-top: 10px;">
                    <label class="control-label col-md-3"><h4>Change :</h4></label>
                    <h4><label class="control-label col-md-9" id="change" style="font-weight: bold"></label></h4>  
                </div>
                <div class="row">
                    <button class="btn btn-danger btn-sm default col-md-12" type="button">OK(Enter)</button>  
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>

    function modal_payment_show(subtot) {
        $("#modal_payment").modal({backdrop: 'static'});
        $('#total-pay').text(subtot);
        $('#total').val(subtot);
        $('#change').text(0);
        $('#cash').val('');
        setTimeout(function() {
            $('#cash').focus();
        }, 1000);

    }

    function cekPay(){
        var tot = $('#total').val();
        var cash = $('#cash').val();

        var change = cash - tot;
        if(change > 0){
            $('#change').text(change);
        }else{
            $('#change').text(0);
        }
    }
  
</script>