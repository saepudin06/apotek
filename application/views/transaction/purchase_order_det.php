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
                    <a href="javascript:;">Transaksi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pembelian Barang (PO)</li>
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
                        aria-selected="true"><strong>Pembelian Barang</strong></a>
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

                            <input class="form-control" type="hidden" id="purchase_order_id" name="purchase_order_id" value="<?php echo $this->input->post('purchase_order_id'); ?>" placeholder="" autocomplete="off" readonly="" />

                            <input class="form-control" type="hidden" id="purchase_request_id" name="purchase_request_id" value="<?php echo $this->input->post('purchase_request_id'); ?>" placeholder="" autocomplete="off" readonly="" />

                            <input type="hidden" id="stock_min" name="stock_min" />
                            <input type="hidden" id="purchase_req_det_id" name="purchase_req_det_id" />

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="purchase_order_det_id" name="purchase_order_det_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="po_code" name="po_code" placeholder="" autocomplete="off" readonly="" value="<?php echo $this->input->post('po_code'); ?>" />
                                    <span>Kode *</span>
                                </label>

                                <label class="form-group has-float-label col-md-5">
                                    <input class="form-control" id="product_name" name="product_name" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Produk Request *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_product('product_id', 'product_name','basic_price','qty','amount','stock_min','purchase_req_det_id')">Cari <i class="simple-icon-question"></i></button>
                                </div>

                                <input class="form-control" type="hidden" id="product_id" name="product_id" placeholder="" autocomplete="off" readonly="" />

                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" onkeypress="return isNumberKey(event)" onkeyup="sumamout()" id="basic_price" name="basic_price" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Harga Awal *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" onkeypress="return isNumberKey(event)" onkeyup="sumamout()" id="qty" name="qty" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Jumlah *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control numeric" id="amount" name="amount" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Total *</span>
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

<?php $this->load->view('lov/lov_purchase_request_det'); ?>

<script type="text/javascript">
    function search_product(id, code, basic_price, qty, amount, min_stock, purchase_req_det_id){
        var purchase_request_id = "<?php echo $this->input->post('purchase_request_id'); ?>";
        var purchase_order_id = "<?php echo $this->input->post('purchase_order_id'); ?>";
        modal_lov_pr_det_show(id, code, basic_price, qty, amount, min_stock, purchase_req_det_id, purchase_request_id, purchase_order_id)
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
            url: '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/crud"; ?>',
            postData: { purchase_order_id : '<?php echo $this->input->post('purchase_order_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'purchase_order_det_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Purchase Request ID', name: 'purchase_order_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Product ID', name: 'product_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Kode PO', name: 'po_code_det', width: 400, align: "left", editable: false, search:false, sortable:false},
                {label: 'Kode PR', name: 'pr_code_det', width: 400, align: "left", editable: false, search:false, sortable:false},
                {label: 'Produk', name: 'product_name', width: 400, align: "left", editable: false, search:false, sortable:false},
                {label: 'Harga Awal', name: 'basic_price', width: 120, align: "right", editable: false, search:false, sortable:false},
                {label: 'Jumlah', name: 'qty', width: 100, align: "right", editable: false, search:false, sortable:false},
                {label: 'Total', name: 'amount', width: 120, align: "right", editable: false, search:false, sortable:false},
                
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
            editurl: '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/crud"; ?>',
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
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');

        loadContentWithParams("transaction.purchase_order", {});
    });
</script>

<script type="text/javascript">

    function setData(rowid){
        
        var purchase_order_id = $('#grid-table').jqGrid('getCell', rowid, 'purchase_order_id');
        var product_id = $('#grid-table').jqGrid('getCell', rowid, 'product_id');
        var product_name  = $('#grid-table').jqGrid('getCell', rowid, 'product_name');
        var basic_price  = $('#grid-table').jqGrid('getCell', rowid, 'basic_price');
        var qty  = $('#grid-table').jqGrid('getCell', rowid, 'qty');
        var amount  = $('#grid-table').jqGrid('getCell', rowid, 'amount');
        
        $('#purchase_order_det_id').val(rowid);
        $('#purchase_order_id').val(purchase_order_id);
        $('#product_id').val(product_id);
        $('#product_name').val(product_name);
        $('#basic_price').val(basic_price);        
        $('#qty').val(qty);        
        $('#amount').val(amount);        
        // $('#stock_min').val(stock_min); 
        // $('#status').trigger('change');        

    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

    /*delete*/
    function delete_data(rowid){
        var purchase_order_det_id = $('#grid-table').jqGrid('getCell', rowid, 'purchase_order_det_id');

        swal({
              title: "",
              text: "Apakah anda ingin menghapus data ini?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var del = { id_ : rowid, purchase_order_det_id : purchase_order_det_id };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."transaction.purchase_order_det_controller/crud"; ?>" ,
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
        var stock_min = $('#stock_min').val();
        var qty = $('#qty').val();

        // if(qty > stock_min){
        //     swal('','Jumlah Stok melebihi Min. stok['+stock_min+'] yang ditentukan','info');
        //     $('#qty').val(0);
        //     $('#amount').val(0);
        //     return false;

        // }

        var data = new FormData(this);
        var purchase_order_det_id = $('#purchase_order_det_id').val();
            
        var var_url = '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/create"; ?>';
        if(purchase_order_det_id) var_url = '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/read"; ?>',
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