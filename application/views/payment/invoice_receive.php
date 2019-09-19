<div class="row">
    <div class="col-12 list">
        <div class="float-sm-right text-zero">
            <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                <input onchange="searchData()" id="search-data" placeholder="Pencarian...">
            </div>
        </div>

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Pembayaran</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tagihan Supplier</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <!-- <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Pengecekan Barang</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
                </li>
            </ul> -->
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">

                    <div class="col-md-3">
                        <label class="form-group has-float-label">
                            <input class="form-control" id="invoice_ref" name="invoice_ref" onchange="filterSup()" placeholder="" autocomplete="off" autofocus="" />
                            <span>No. Referensi *</span>
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label class="form-group has-float-label">
                            <input class="form-control" id="sup_name" name="sup_name" onchange="filterSup()" placeholder="" autocomplete="off" autofocus="" readonly="" />
                            <span>Supplier *</span>
                        </label>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary default" type="button" onclick="search_supplier('supplier_id', 'sup_name')">Cari <i class="simple-icon-question"></i></button>
                    </div>

                    <input class="form-control" type="hidden" id="supplier_id" name="supplier_id" placeholder="" autocomplete="off" readonly="" />

                    <div class="col-md-2">
                        <button type='button' class='btn btn-info default' onclick='Generate()'>Generate Pembayaran</button>
                    </div>

                    <div class="col-md-2">
                        <button type='button' class='btn btn-success default' onclick='UpdatePayRef()'>Update Pembayaran (by Referensi)</button>
                    </div>


                    

                    <div class="col-md-12" id="grid-ui">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_supplier'); ?>

<script type="text/javascript">
    function search_supplier(id, code){
        modal_lov_supplier_show(id, code);
    }
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."payment.invoice_receive_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'invoice_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Supplier ID', name: 'supplier_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},  
                {label: '<center>Update Pembayaran</center>',width: 150, align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var invoice_id = rowObject['invoice_id'];

                        return '<button class="btn btn-primary btn-xs default" onclick="UpdatePay('+invoice_id+')">Update</button>';
                    }
                },
                {label: 'Supplier', name: 'supplier_name', width: 100, align: "left", editable: false, search:false, sortable:false}, 
                {label: 'Tanggal', name: 'invoice_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'No. Tagihan', name: 'invoice_num', width: 150, align: "left", editable: false, search:false, sortable:false},                    
                {label: 'No. Tagihan (Referensi)', name: 'invoice_ref', width: 150, align: "left", editable: false, search:false, sortable:false},                    
                {label: 'Tempo Pembayaran', name: 'due_date_payment', width: 150, align: "left", editable: false, search:false, sortable:false},                    
                {label: 'Total', name: 'amount', width: 150, align: "right", editable: false, search:false, sortable:false},
                {label: 'Pembuat', name: 'created_by', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal Dibuat', name: 'created_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Pengubah', name: 'update_by', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal Diubah', name: 'update_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                
            ],
            // height: '100%',
            height: 200,
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10,20,30],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            // multiselect: true,
            // multiPageSelection: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/
                // setData(rowid);
           
            },
            sortorder:'',
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

                setTimeout(function(){
                      $("#grid-table").setSelection($("#grid-table").getDataIDs()[0],true);
                      // $("#grid-table").focus();
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/crud"; ?>',
            caption: "Tagihan Supplier"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: false,
                editicon: 'simple-icon-note',
                add: false,
                addicon: 'simple-icon-plus',
                del: false,
                delicon: 'simple-icon-minus',
                search: false,
                searchicon: 'simple-icon-magnifier',
                refresh: true,
                afterRefresh: function () {
                    // some invoice_num_ref here
                    // jQuery("#detailsPlaceholder").hide();
                },

                refreshicon: 'iconsmind-Refresh',
                view: false,
                viewicon: 'fa fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                // serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                // serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();


                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                // serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    style_search_form(form);
                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                }
            }
        );

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $("#grid-ui").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    $(window).bind('resize', function() {
        responsive_jqgrid('#grid-table', '#grid-pager');    
    }).trigger('resize');

</script>



<script type="text/javascript">


    /*process*/
    function Generate(){
        var supplier_id = $('#supplier_id').val();
        var supplier = $('#sup_name').val();

        if(supplier_id == null || supplier_id == '') {
            swal('','Supplier belum dipilih','info');
            return false;
        }

        swal({
              title: "",
              text: "Pembayaran supplier "+supplier+" akan digenerate\nApakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                $.ajax({
                    url: "<?php echo WS_JQGRID."payment.invoice_receive_controller/generate"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {supplier_id:supplier_id},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            filterSup();

                        }else{
                            swal("", data.message, "warning");
                        }
                    },
                    error: function (xhr, status, error) {
                        swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                    }
                });
                                
                return false;
        });
    }

    /*process*/
    function UpdatePayRef(){
        var invoice_ref = $('#invoice_ref').val();

        if(invoice_ref == null || invoice_ref == '') {
            swal('','No. Referensi belum diisi','info');
            return false;
        }

        swal({
              title: "",
              text: "Update Payment by Referensi\nApakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                $.ajax({
                    url: "<?php echo WS_JQGRID."payment.invoice_receive_controller/updatepaymentref"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {invoice_ref : invoice_ref},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            filterSup();

                        }else{
                            swal("", data.message, "warning");
                        }
                    },
                    error: function (xhr, status, error) {
                        swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                    }
                });
                                
                return false;
        });
    }

    /*process*/
    function UpdatePay(invoice_id){

        if(invoice_id == null || invoice_id == '') {
            swal('','No. Tagihan belum dipilih','info');
            return false;
        }

        swal({
              title: "",
              text: "Update Payment by Referensi\nApakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                $.ajax({
                    url: "<?php echo WS_JQGRID."payment.invoice_receive_controller/updatepayment"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {invoice_id : invoice_id},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            filterSup();

                        }else{
                            swal("", data.message, "warning");
                        }
                    },
                    error: function (xhr, status, error) {
                        swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                    }
                });
                                
                return false;
        });
    }


</script>
<script type="text/javascript">
    function filterSup(){
        var supplier = $('#sup_name').val();
        var supplier_id = $('#supplier_id').val();
        var invoice_ref = $('#invoice_ref').val();

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."payment.invoice_receive_controller/read"; ?>',
            postData: {
                i_search : '',
                supplier_id : supplier_id,
                invoice_ref : invoice_ref
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
    }

    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."payment.invoice_receive_controller/read"; ?>',
            postData: {
                i_search : $('#search-data').val()
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
        responsive_jqgrid('#grid-table', '#grid-pager');
    }

    function resetSearch(){
        $('#form_data').trigger("reset");
        
        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."payment.invoice_receive_controller/read"; ?>',
            postData: {
                i_search : ''
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
    }


     $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight:'TRUE',
        autoclose: true,
        orientation: 'bottom'
    });

    $(".numeric").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
</script>