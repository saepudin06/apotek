<div id="modal_secret_key" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Please enter 6 digit key </span>
                </div>
            </div>

            <!-- modal body -->
            <div class="modal-body">
                <div class="row">
                    <?php
                        $items = getSecretKey();
                        if(isset($items['value'])){
                            $key = $items['value'];
                        }else{
                            $key = 'xxx';
                        }
                    ?>
                    <input type="hidden" name="kode" id="kode" value="<?php echo $key;?>" />
                    <input type="text" class="form-control col-md-12" name="key" id="key" maxlength="6" onkeyup="checkKey()" />          
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>

    function modal_secret_key_show() {
        $("#modal_secret_key").modal({backdrop: 'static'});
        $('#key').val('');
        setTimeout(function() {
            $('#key').focus();
        }, 1000);

    }

    function checkKey(){
        var key = $('#key').val();
        var kode = $('#kode').val();
        
        if(key.length == 6){
            if(key == kode){
                var grid = $('#grid-table');
                idd = grid.jqGrid('getGridParam', 'selrow');
                product_id = grid.jqGrid('getCell', idd, 'product_id');
                product_label = grid.jqGrid('getCell', idd, 'product_label');
                product_name = grid.jqGrid('getCell', idd, 'product_name');
                qty = grid.jqGrid('getCell', idd, 'qty');
                product_price = grid.jqGrid('getCell', idd, 'product_price');

                if(idd == null) {
                    // swal('','Please select one row','info');
                    alert('Please select one row');
                    return false;
                }

                if(product_price < 0){
                    alert("This row can't be delete");
                    $('#modal_secret_key').modal('toggle');
                    $("#grid-table").setSelection($("#grid-table").getDataIDs()[0],true);
                    $("#grid-table").focus();
                    return false;
                }

                var obj_id = data.rows.length;            
                var grid_id = obj_id+1;

                data.rows[obj_id] = new Product(grid_id, product_id, product_label, product_name, qty, product_price*-1);
                // $("#product_label").focus();
                jQuery("#grid-table").jqGrid('setGridParam',{
                    datatype: 'jsonstring',
                    datastr :  data
                });

                $("#grid-table").trigger("reloadGrid");
                $('#product_label').focus();
                $('#qty').val(1);
                $('#modal_secret_key').modal('toggle');
                $("#grid-table").setSelection($("#grid-table").getDataIDs()[0],true);
                $("#grid-table").focus();
            }else{
                alert('Sorry password not match');
            }
        }
        
    }
  
</script>