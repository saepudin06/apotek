<div id="modal_lov_help" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Help </span>
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
                    <label class="control-label col-md-8">*  : Multiplication</label>
                    <label class="control-label col-md-8">F2  : Payment</label>
                    <label class="control-label col-md-8">F4     : Select Grid</label>
                    <label class="control-label col-md-8">F9     : Search Product</label>
                    <label class="control-label col-md-8">F11    : Full Screen</label>
                    <label class="control-label col-md-8">Delete : Remove </label>               
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>

    function modal_lov_help_show() {
        $("#modal_lov_help").modal({backdrop: 'static'});
    }
  
</script>