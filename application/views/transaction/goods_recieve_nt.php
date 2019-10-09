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
                    <a href="javascript:;">Transaction</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pengecekan Barang (GR)</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Pengecekan Barang</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
                </li>
            </ul>
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">
                    <div class="col-md-12" id="grid-ui">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>

                    <div class="col-md-12" id="form-ui" style="display: none;">    
                        <h5 class="mb-4">Form Pengecekan Barang</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="goods_recieve_nt_id" name="goods_recieve_nt_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>
                                
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control datepicker" id="grn_date" name="grn_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Tanggal *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="invoice_num_ref" name="invoice_num_ref" placeholder="" autocomplete="off" autofocus="" />
                                    <span>No. Tagihan *</span>
                                </label>

                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="po_num" name="po_num" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Kode Pembelian *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_po('purchase_order_id', 'po_num')">Search</button>
                                </div>

                                <input class="form-control" type="hidden" id="purchase_order_id" name="purchase_order_id" placeholder="" autocomplete="off" readonly="" />

                                <label class="form-group has-float-label col-md-8">
                                    <input class="form-control" id="notes" name="notes" placeholder="" autocomplete="off" autofocus=""  />
                                    <span>Catatan</span>
                                </label>
                            </div>
                            

                            <button class="btn btn-secondary" type="submit" id="btn-submit">OK</button>
                            <button class="btn btn-danger" type="button" id="btn-cancel">Batal</button>

                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_purchase_order'); ?>

<script type="text/javascript">
    function search_po(id, code){
        modal_lov_purchase_order_show(id, code);
    }

</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'goods_recieve_nt_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Purchase Order ID', name: 'purchase_order_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},                
                {label: 'Kode Pengecekan', name: 'code', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal', name: 'grn_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Kode Pembelian', name: 'po_num', width: 200, align: "left", editable: false, search:false, sortable:false, hidden:false},
                {label: 'No. Tagihan', name: 'invoice_num_ref', width: 150, align: "left", editable: false, search:false, sortable:false},                    
                {label: 'Tempo Pembayaran', name: 'due_date_payment', width: 150, align: "left", editable: false, search:false, sortable:false},                    
                {label: 'Total', name: 'amount', width: 150, align: "right", editable: false, search:false, sortable:false},
                {label: 'Status', name: 'status', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Status Pembayaran', name: 'payment_status', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Catatan', name: 'notes', width: 300, align: "left", editable: false, search:false, sortable:false},
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
                var status = $('#grid-table').jqGrid('getCell', rowid, 'status');
                console.log(status);

                if(status != 'INITAL'){
                    $('#btn-edit').hide();
                    $('#btn-delete').hide();
                }else{
                    $('#btn-edit').show();
                    $('#btn-delete').show();
                }
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
            caption: "Pengecekan Barang &nbsp;&nbsp;&nbsp; <button type='button' class='btn btn-info btn-xs default' onclick='Process()'>Proses</button> <button type='button' class='btn btn-success btn-xs default' onclick='ProcessAll()'>Proses (Semua)</button>"

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
        ).navButtonAdd('#grid-pager',{
                caption: "", //Add
                buttonicon: "simple-icon-plus",
                onClickButton: function(){ 
                    $('#grid-ui').hide();
                    $('#form-ui').slideDown( "slow" );
                    $('#form_data').trigger("reset");                    
                     //alert("Adding Row");
                },
                position: "last",
                title: "Add",
                cursor: "pointer",
                id : "btn-add"
        }).navButtonAdd('#grid-pager',{
                caption: "", //Edit
                buttonicon: "simple-icon-note",
                onClickButton: function(rowid){ 
                    var grid = $('#grid-table');
                    rowid = grid.jqGrid ('getGridParam', 'selrow');
                    if(rowid == null) {
                        swal('','Silakan pilih salah satu baris','info');
                        return false;
                    }

                    $('#grid-ui').hide();
                    $('#form-ui').slideDown( "slow" );

                    setData(rowid);

                    // $('#form-ui').trigger("reset");
                },
                position: "last",
                title: "Edit",
                cursor: "pointer",
                id : "btn-edit"
        }).navButtonAdd('#grid-pager',{
                caption: "", //Delete
                buttonicon: "simple-icon-minus",
                onClickButton: function(){ 
                    var grid = $('#grid-table');
                    rowid = grid.jqGrid ('getGridParam', 'selrow');
                    if(rowid == null) {
                        swal('','Silakan pilih salah satu baris','info');
                        return false;
                    }
                    delete_data(rowid);
                },
                position: "last",
                title: "Delete",
                cursor: "pointer",
                id : "btn-delete"
        });

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $("#grid-ui").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    $(window).on("resize", function(event) {
       responsive_jqgrid('#grid-table', '#grid-pager');  
    });

</script>

<script type="text/javascript">
    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');
        goods_recieve_nt_id = grid.jqGrid('getGridParam', 'selrow');
        invoice_num_ref = grid.jqGrid('getCell', goods_recieve_nt_id, 'invoice_num_ref');
        purchase_order_id = grid.jqGrid('getCell', goods_recieve_nt_id, 'purchase_order_id');

        if(goods_recieve_nt_id == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        
        loadContentWithParams("transaction.goods_recieve_nt_dt", {
            goods_recieve_nt_id: goods_recieve_nt_id,
            invoice_num_ref : invoice_num_ref,
            purchase_order_id : purchase_order_id
        });
    });
</script>


<script type="text/javascript">

    function setData(rowid){
        
        var grn_date = $('#grid-table').jqGrid('getCell', rowid, 'grn_date');
        var invoice_num_ref  = $('#grid-table').jqGrid('getCell', rowid, 'invoice_num_ref');
        var purchase_order_id  = $('#grid-table').jqGrid('getCell', rowid, 'purchase_order_id');
        var notes  = $('#grid-table').jqGrid('getCell', rowid, 'notes');
        var po_num  = $('#grid-table').jqGrid('getCell', rowid, 'po_num');
        
        $('#goods_recieve_nt_id').val(rowid);
        $('#purchase_order_id').val(purchase_order_id);
        $('#grn_date').val(grn_date);
        $('#notes').val(notes);         
        $('#invoice_num_ref').val(invoice_num_ref);         
        $('#po_num').val(po_num);         

    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

    /*process*/
    function Process(){
        var grid = $('#grid-table');
        var goods_recieve_nt_id = grid.jqGrid('getGridParam', 'selrow');
        var po_num = grid.jqGrid('getCell', goods_recieve_nt_id, 'po_num');

        if(goods_recieve_nt_id == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        swal({
              title: "",
              text: "Semua Product dengan kode pembelian "+po_num+" akan ditambahkan ke stock\nApakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var data = { goods_recieve_nt_id : goods_recieve_nt_id };
                itemJSON = JSON.stringify(data);

                $.ajax({
                    url: "<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/process"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {items:itemJSON},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            resetSearch();

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
    function ProcessAll(){
        swal({
              title: "",
              text: "Semua Product akan ditambahkan ke stock\nApakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                $.ajax({
                    url: "<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/processall"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            resetSearch();

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

    /*delete*/
    function delete_data(rowid){
        swal({
              title: "",
              text: "Apakah anda ingin menghapus data ini?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var del = { id_ : rowid };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/crud"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {items:itemJSON, oper:'del'},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            resetSearch();

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

    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault(); 
        var data = new FormData(this);
        var goods_recieve_nt_id = $('#goods_recieve_nt_id').val();
            
        var var_url = '<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/create"; ?>';
        if(goods_recieve_nt_id) var_url = '<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/update"; ?>';
        
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: var_url,
            data: data,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false, 
            success: function(data) {
                //console.log(data);
                if(data.success) {                    
                    $("#grid-table").trigger("reloadGrid");
                    swal("", data.message, "success");
                    $('#form-ui').hide();
                    $('#grid-ui').slideDown( "slow" );
                }else{
                    swal("", data.message, "warning");
                }
               
            }
        });
        
        
        return false;
    }));

</script>
<script type="text/javascript">
    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_controller/read"; ?>',
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