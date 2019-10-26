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
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Pembelian Barang</strong></a>
                </li>
                <!-- <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
                </li> -->
            </ul>
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">
                    <div class="col-md-12" id="grid-ui">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>

                    <div class="col-md-12" id="form-ui" style="display: none;">    
                        <h5 class="mb-4">Form Pembelian Barang</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="icolumn" id="icolumn">
                            <input type="hidden" name="irow" id="irow">
                            <input type="hidden" name="gridtable" id="gridtable">

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="purchase_order_id" name="purchase_order_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>
                                
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="sup_name" name="sup_name" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Supplier *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_supplier('supplier_id', 'sup_name')">Cari <i class="simple-icon-question"></i></button>
                                </div>

                                <input class="form-control" type="hidden" id="supplier_id" name="supplier_id" placeholder="" autocomplete="off" readonly="" />

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="pr_code" name="pr_code" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Rencana Pembelian *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_pr('purchase_request_id', 'pr_code')">Cari <i class="simple-icon-question"></i></button>
                                </div>

                                <input class="form-control" type="hidden" id="purchase_request_id" name="purchase_request_id" placeholder="" autocomplete="off" readonly="" />


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

<?php $this->load->view('lov/lov_supplier'); ?>
<?php $this->load->view('lov/lov_purchase_request'); ?>

<script type="text/javascript">
    function search_supplier(id, code){
        modal_lov_supplier_show(id, code);
    }

    function search_pr(id, code){
       modal_lov_purchase_request_show(id, code);
    }
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."transaction.purchase_order_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'purchase_order_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Supplier Id', name: 'supplier_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Status GRN', name: 'status_grn', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Unit Bisnis', name: 'bu_name', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'PO Date', name: 'po_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Kode Pembelian', name: 'code', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'Supplier', name: 'sup_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Purchase Request ID', name: 'purchase_request_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Rencana Pembelian', name: 'pr_code', width: 200, align: "left", editable: false, search:false, sortable:false},                
                {label: 'Amount', name: 'amount', width: 150, align: "right", editable: false, search:false, sortable:false},
                {label: 'Pembuat', name: 'created_by', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal Dibuat', name: 'created_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Pengubah', name: 'update_by', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal Diubah', name: 'update_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                
            ],
            // height: '100%',
            height: 300,
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
            subGrid: true, // set the subGrid property to true to show expand buttons for each row
            subGridRowExpanded: showChildGrid, // javascript function that will take care of showing the child grid
            subGridOptions : {
                 // load the subgrid data only once
                 // and the just show/hide
                 reloadOnExpand :false,
                 // select the row when the expand column is clicked
                 selectOnExpand : true,
                 plusicon : "ui-icon iconsmind-Maximize",
                 minusicon  : "ui-icon iconsmind-Minimize"
                // openicon : "ace-icon fa fa-chevron-right center orange"
            },  // batas sub group
            subGridBeforeExpand: function(divid, rowid) {
                
                // var grid = $('#grid-table_'+rowid+'_table');
                // // var grid = $('#'+$('#gridtable').val());

                //     grid.jqGrid('setGridParam', {cellEdit: true});
                //     grid.jqGrid('editCell', $('#irow').val(), $('#icolumn').val()-1, true);
                //     grid.jqGrid('setGridParam', {cellEdit: false});

                var expanded = jQuery("td.sgexpanded", "#grid-table")[0];
                  if(expanded) {
                    setTimeout(function(){
                        $(expanded).trigger("click");
                    }, 100);
                  }
            },
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
            editurl: '<?php echo WS_JQGRID."transaction.purchase_order_controller/crud"; ?>',
            caption: "Pembelian Barang"

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

    function showChildGrid(parentRowID, parentRowKey) {
        var childGridID = parentRowID + "_table";
        var childGridPagerID = parentRowID + "_pager";
        

        var purchase_order_id  = $('#grid-table').jqGrid('getCell', parentRowKey, 'purchase_order_id');
        var status_grn  = $('#grid-table').jqGrid('getCell', parentRowKey, 'status_grn');
        var title = '';

        if (status_grn == 'Y') {
            title = '<button type="button" class="btn btn-danger btn-xs default" disabled="">Submit Pembelanjaan</button>';
        }else{
            title = '<button type="button" class="btn btn-primary btn-xs default" onclick="submitPembelanjaan(\''+childGridID+'\')">Submit Pembelanjaan</button>';
        }

        
        var childGridURL = "<?php echo WS_JQGRID."transaction.purchase_order_det_controller/readChild"; ?>";

        
        $('#' + parentRowID).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + ' class=scroll></div>');

        $("#" + childGridID).jqGrid({
            url: childGridURL,
            mtype: "POST",
            datatype: "json",
            page: 1,
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            shrinkToFit: false,
            loadui: "disable",
            multiboxonly: true,            
            // cellEdit : true,
            cellsubmit : 'clientArray',
            postData:{
                        purchase_order_id : encodeURIComponent(purchase_order_id)
                     },
            colModel: [
                {label: 'ID', name: 'purchase_order_det_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'PQR ID', name: 'purchase_req_det_id', width: 100, sorttype: 'number', editable: true, hidden: true},
                {label: 'PO ID', name: 'purchase_order_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: '<center>Status Beli?</center>', name: 'status', align: "center", width: 100, editable: true, edittype: 'select', 
                        editoptions: { value: "Ya:Ya;Tidak:Tidak"}
                 },
                {label: 'Min. Stok', name: 'stock_min', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Purchase Request ID', name: 'purchase_request_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Product ID', name: 'product_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Produk', name: 'product_name', width: 400, align: "left", editable: false, search:false, sortable:false},
                {label: 'Harga Awal', name: 'basic_price', width: 100, align: "right", editable: true, search:false, sortable:false, cellEdit: true, 
                    formatter: 'currency', 
                    formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."},
                    editrules:{number:true}, 
                    edittype:"text", editoptions:
                        {
                            size: 25, maxlengh: 30,
                            dataInit: function(element)
                            {
                                $(element).keypress(function(e)
                                {
                                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                        return false;
                                    }
                                });
                            }
                        }
                },
                {label: 'Jumlah', name: 'qty', width: 100, align: "right", editable: true, search:false, sortable:false, cellEdit: true, edittype:"text", editrules:{number:true}, 
                    formatter: 'currency', 
                    formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."},
                    edittype:"text", editoptions:
                    {
                        size: 25, maxlengh: 30,
                        dataInit: function(element)
                        {
                            $(element).keypress(function(e)
                            {
                                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                    return false;
                                }
                            });
                        }
                    }
                },
                {label: 'Total', name: 'amount', width: 100, align: "right", editable: false, search:false, sortable:false, editrules:{number:true},
                    formatter: 'currency', 
                    formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."},
                },
            ],
            // width: "100%",
            autowidth: true,
            height: '100%',
            ondblClickRow: function (rowid, iRow, iCol) {
                var $this = $(this);
                $this.jqGrid('setGridParam', {cellEdit: true});
                $this.jqGrid('editCell', iRow, iCol, true);
                $this.jqGrid('setGridParam', {cellEdit: false});


                $('#irow').val(iRow);
                $('#icolumn').val(iCol);
            },
            afterEditCell: function (rowid, cellName, cellValue, iRow) {
                var cellDOM = this.rows[iRow], oldKeydown,
                    $cellInput = $('input, select, textarea', cellDOM),
                    events = $cellInput.data('events'),
                    $this = $(this);
                if (events && events.keydown && events.keydown.length) {
                    oldKeydown = events.keydown[0].handler;
                    $cellInput.unbind('keydown', oldKeydown);
                    $cellInput.bind('keydown', function (e) {
                        $this.jqGrid('setGridParam', {cellEdit: true});
                        oldKeydown.call(this, e);
                        $this.jqGrid('setGridParam', {cellEdit: false});
                    });
                }
            },
            caption: title,
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            }
        });

    }

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
        var purchase_order_id = grid.jqGrid('getGridParam', 'selrow');
        var po_code = grid.jqGrid('getCell', purchase_order_id, 'code');
        var purchase_request_id = grid.jqGrid('getCell', purchase_order_id, 'purchase_request_id');

        
        if(purchase_order_id == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        loadContentWithParams("transaction.purchase_order_det", {
            purchase_order_id: purchase_order_id,
            po_code: po_code,
            purchase_request_id: purchase_request_id
        });
    });

</script>

<script type="text/javascript">

    function setData(rowid){
        
        var po_date = $('#grid-table').jqGrid('getCell', rowid, 'po_date');
        var pr_code  = $('#grid-table').jqGrid('getCell', rowid, 'pr_code');        
        var supplier_id  = $('#grid-table').jqGrid('getCell', rowid, 'supplier_id');
        var sup_name  = $('#grid-table').jqGrid('getCell', rowid, 'sup_name');
        var purchase_request  = $('#grid-table').jqGrid('getCell', rowid, 'purchase_request');
        var purchase_request_id  = $('#grid-table').jqGrid('getCell', rowid, 'purchase_request_id');
        
        
        $('#purchase_order_id').val(rowid);
        $('#po_date').val(po_date);
        $('#pr_code').val(pr_code);                      
        $('#supplier_id').val(supplier_id);        
        $('#sup_name').val(sup_name);        
        $('#purchase_request').val(purchase_request);        
        $('#purchase_request_id').val(purchase_request_id);        
        

    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

    function submitPembelanjaan(param){
        var grid = $('#'+param);
        // console.log($('#icolumn').val()-1);
        if($('#irow').val() != ''){
            grid.jqGrid('setGridParam', {cellEdit: true});
            grid.jqGrid('editCell', $('#irow').val(), 8, true);
            grid.jqGrid('setGridParam', {cellEdit: false});
        }
        
        rowid = grid.jqGrid ('getRowData');
        if(rowid == null) {
            swal('','Data tidak ditemukan','info');
            return false;
        }
        
        var var_url = '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/crudAll"; ?>';

        swal({
              title: "",
              text: "apakah anda yakin?",
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
                    data: { data : rowid },
                    success: function(data) {
                        //console.log(data);
                        if(data.success) {                    
                            $("#grid-table").trigger("reloadGrid");
                            grid.trigger("reloadGrid");
                            swal("", data.message, "success");
                        }else{
                            swal("", data.message, "warning");
                        }
                       
                    }
                });

            return false;
        });
        // console.log(rowid);          
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
                    url: "<?php echo WS_JQGRID."transaction.purchase_order_controller/crud"; ?>" ,
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
        var purchase_order_id = $('#purchase_order_id').val();
            
        var var_url = '<?php echo WS_JQGRID."transaction.purchase_order_controller/create"; ?>';
        if(purchase_order_id) var_url = '<?php echo WS_JQGRID."transaction.purchase_order_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."transaction.purchase_order_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."transaction.purchase_order_controller/read"; ?>',
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