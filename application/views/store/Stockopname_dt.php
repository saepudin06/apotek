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
                    <a href="javascript:;">Gudang</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Stock Opname</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Stock Opname</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
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
                        <h5 class="mb-4">Form Detail</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <!-- <input type="hidden" name="stock_min" id="stock_min" /> -->

                            <input class="form-control" type="hidden" id="stockopname_id" name="stockopname_id" value="<?php echo $this->input->post('stockopname_id'); ?>" placeholder="" autocomplete="off" readonly="" />

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-2">
                                    <input class="form-control" id="stockopname_dt_id" name="stockopname_dt_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="code_stpnm" name="code_stpnm" placeholder="" autocomplete="off" readonly="" value="<?php echo $this->input->post('stopnm_code'); ?>" />
                                    <span>Kode *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="product_name" name="product_name" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Produk *</span>
                                </label>

                            </div>

                            <div class="form-row">
                            
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="status_dt" name="status_dt" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Status *</span>
                                </label>

                                <label class="form-group has-float-label col-md-2">
                                    <input class="form-control" type="number" id="qty_system" name="qty_system" placeholder="" readonly=""  autocomplete="off" autofocus=""  />
                                    <span>Qty System *</span>
                                </label>

                                <label class="form-group has-float-label col-md-2">
                                    <input class="form-control" type="number" id="qty_real" name="qty_real" placeholder="" autocomplete="off" autofocus=""  />
                                    <span>Qty Real *</span>
                                </label>

                                 <label class="form-group has-float-label col-md-4">
                                    <!-- <textarea rows="8" cols="50" name="note_action" form="form_data"> -->
                                    <textarea name="note_action"  autocomplete="off" cols="50" id="note_action"></textarea>
                                    <span>Note *</span>
                                </label>

                               

                                <!-- <label class="form-group has-float-label col-md-3">
                                    <select class="form-control" id="status">
                                        <option value="1">Active</option>
                                        <option value="2">Not Active</option>
                                    </select>
                                    <span>Status *</span>
                                </label> -->
                            </div>

                            <button class="btn btn-success" type="submit" id="btn-submit">OK</button>
                            <button class="btn btn-danger" type="button" id="btn-cancel">Batal</button>

                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_product'); ?>

<script type="text/javascript">
    function search_product(id, code, stock_min){
        modal_lov_product_show(id, code, stock_min);
    }

    function sumamout() {
        
        
        var basic_price = $('#basic_price').val();
        var qty = $('#qty').val();

        if(qty == null || qty == ''){
            qty = 0;
        }

        if(basic_price == null || basic_price == ''){
            basic_price = 0;
        }

        var sumamout = basic_price*qty;
        $('#amount').val(sumamout);
    }
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."store.stockopname_dt_controller/crud"; ?>',
            postData: { stockopname_id : '<?php echo $this->input->post('stockopname_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'stockopname_dt_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'ID STO', name: 'stockopname_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: '<center>Action (Status)</center>',width: 300, align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var status = rowObject['status'];
                        var rowid = options.rowId;

                        var MATCH = "MATCH";
                        var UMATCH = "UN-MATCH";

                        if(status == '-' || status == null || status == 'null'){
                            return '<button class="btn btn-primary btn-xs default" onclick="updateStatus('+rowid+',\''+MATCH+'\')">MATCH</button> <button class="btn btn-warning btn-xs default" onclick="updateStatus('+rowid+',\''+UMATCH+'\')">UN-MATCH</button>';
                        }else{
                            return status;
                        }
                    }
                },
                {label: 'Status', name: 'status', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Product Name', name: 'product_name', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Store Info', name: 'store_info', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Qty System', name: 'qty_system', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Qty Real', name: 'qty_real', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Tanggal di Buat', name: 'created_date', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Pembuat', name: 'created_by', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Tanggal di Ubah', name: 'update_date', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Pengubah', name: 'updated_by', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Catatan', name: 'action_note', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: false}
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
            shrinkToFit: true,
            multiboxonly: true,
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
            editurl: '<?php echo WS_JQGRID."store.stockopname_dt_controller/crud"; ?>',
            caption: "Detail"

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
                    // some code here
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
                    // $('#status').val('1').trigger('change');
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

                    // setData(rowid);

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
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');

        loadContentWithParams("store.stockopname", {});
    });
</script>

<script type="text/javascript">

    function setData(rowid, status){

        // alert(rowid);
        
        var stockopname_id = $('#grid-table').jqGrid('getCell', rowid, 'stockopname_id');
        var stockopname_dt_id = $('#grid-table').jqGrid('getCell', rowid, 'stockopname_dt_id');
        var product_name = $('#grid-table').jqGrid('getCell', rowid, 'product_name');
        // var status  = $('#grid-table').jqGrid('getCell', rowid, 'status');
        var qty_real  = $('#grid-table').jqGrid('getCell', rowid, 'qty_real');
        var qty_system  = $('#grid-table').jqGrid('getCell', rowid, 'qty_system');
        var action_note  = $('#grid-table').jqGrid('getCell', rowid, 'action_note');
     
        if(status== "MATCH"){
            // alert(qty_system);
            $('#qty_real').val(qty_system); 
            $('#qty_real').prop('readonly', true);
        }else{
            $('#qty_real').val(qty_real); 
        }
        
        $('#stockopname_dt_id').val(stockopname_dt_id);
        $('#stockopname_id').val(stockopname_id);
        $('#product_name').val(product_name);
        // $('#qty_real').val(qty_real);        
        $('#qty_system').val(qty_system);        
        $('#note_action').val(action_note);        
        $('#status_dt').val(status);        
        
    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

    /*delete*/
    function delete_data(rowid){
        var purchase_request_id = $('#grid-table').jqGrid('getCell', rowid, 'purchase_request_id');

        swal({
              title: "",
              text: "Apakah anda ingin menghapus data ini?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var del = { id_ : rowid, purchase_request_id : purchase_request_id };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."transaction.purchase_req_det_controller/crud"; ?>" ,
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
        var stockopname_id = $('#stockopname_id').val();
            
        var var_url = '<?php echo WS_JQGRID."store.stockopname_dt_controller/updateSTODT"; ?>';
        // if(purchase_req_det_id) var_url = '<?php 
            // echo WS_JQGRID."transaction.purchase_req_det_controller/update"; 
        // ?>';

        var qty_reals = $("#qty_real").val();
        var note_actions =  $("#note_action").val();

       //alert(note_actions);

        if(qty_reals <= 0 ){
            swal('','Qty real tidak boleh kurang dari sama 0 !');
            return false;
        }else{
            if(note_actions == null || note_actions == ''){
            swal('','Note tidak boleh kosong !');
            return false;
            }
        }

        swal({
          title: "",
          text: "Apakah anda yakin?",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          closeOnConfirm: true
        },
        function(){
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: var_url,
            data: data,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false, 
            success: function(data) {
                console.log(data);
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

         });

    }));

</script>
<script type="text/javascript">

    function updateStatus(rowid, status){
        var grid = $('#grid-table');
        // rowid = grid.jqGrid ('getGridParam', 'selrow');
        if(rowid == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        $('#grid-ui').hide();
        $('#form-ui').slideDown( "slow" );

        setData(rowid, status);
    }

    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/read"; ?>',
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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>