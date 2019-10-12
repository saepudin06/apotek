<style type="text/css">
    .ui-jqgrid .ui-jqgrid-htable .ui-th-div {
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-12 list">
        <div class="float-sm-right text-zero">
            <!-- <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                <input onchange="searchData()" id="search-data" placeholder="Pencarian...">
            </div> -->
        </div>

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Transaksi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Permintaan Pembelian (PR)</li>
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
                        aria-selected="true"><strong>Permintaan Pembelian</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
                </li>
            </ul>
            
            <div class="separator mb-2"></div>
            <div class="card-body">      

                
                <div class="form-row">
                    <input type="hidden" name="icolumn" id="icolumn">
                    <input type="hidden" name="irow" id="irow">

                    <input type="hidden" name="purchase_request_id" id="purchase_request_id" value="<?php echo $this->input->post('purchase_request_id'); ?>">

                    <label class="form-group has-float-label col-md-2">
                        <select class="form-control" id="stock_qty">
                            <option value="all"> Semua Produk </option>
                            <option value="min"> Produk dengan Minimum Stock </option>
                            <option value="max"> Produk dengan Maximum Stock </option>
                        </select>
                        <span>Filter Daftar Produk *</span>
                    </label>
                    <label class="form-group has-float-label col-md-2">
                        <input class="form-control" id="prod_name" name="prod_name" placeholder="" autocomplete="off" autofocus="" />
                        <span>Nama Produk</span>
                    </label>
                    <div class="col-md-1">
                        <button class="btn btn-secondary default" type="button" onclick="searchData()">Filter</button>
                    </div>    

                    <div style="padding-right: 10px;"></div>

                    <label class="form-group has-float-label col-md-3">
                        <input class="form-control" id="prod_name_req" name="prod_name_req" placeholder="" autocomplete="off" autofocus="" />
                        <span>Nama Produk</span>
                    </label>
                    <div class="col-md-3">
                        <button class="btn btn-secondary default" type="button" onclick="searchDataReq()">Filter</button>
                        <button class="btn btn-primary default" type="button" onclick="download_excel()">Excel</button>
                        <button class="btn btn-danger default" type="button">PDF</button>
                    </div>                
                </div>

                
                <div class="row">
                    <div class="col-md-5">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>

                    <div class="col-md-7">         
                        <table id="grid-table-detail"></table>
                        <div id="grid-pager-detail"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."product.products_controller/readListProduct"; ?>',
            postData: { purchase_request_id : '<?php echo $this->input->post('purchase_request_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'Product ID', name: 'product_id', width: 100, align: "left", editable: false, hidden:true, key:true},
                {label: 'Nama Produk',name: 'name',width: 150, align: "left",editable: false },
                {label: 'Jenis Produk', name: 'product_type_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Satuan',name: 'package_type_name',width: 150, align: "left",editable: false, hidden: true},
                {label: 'Ukuran',name: 'measure_type_name',width: 150, align: "left",editable: false, hidden: true},
                {label: 'Jumlah Stok',name: 'stock_store',width: 100, align: "right",editable: false },
                {label: 'Min. Stok',name: 'stock_min',width: 100, align: "right",editable: false },
                
            ],
            height: 200,
            autowidth: true,
            viewrecords: true,
            rowNum: 10000000,
            // rowList: [5,10],
            rownumbers: false, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiselect: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/

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

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."product.products_controller/crud"; ?>',
            caption: "Daftar Produk"

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

                    var grid = $('#grid-table');
                    rowid = grid.jqGrid ('getGridParam', 'selarrrow');
                    if(rowid == null) {
                        swal('','Silakan pilih salah satu baris','info');
                        return false;
                    }
                    add_product(rowid);
                    // console.log(rowid);
                    // $('#status').val('1').trigger('change');
                },
                position: "last",
                title: "Add",
                cursor: "pointer",
                id : "btn-add-product"
        });

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $("#grid-ui").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    $(window).on("resize", function(event) {
       responsive_jqgrid('#grid-table', '#grid-pager');  
       responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');  
    });

</script>


<script type="text/javascript">
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();
        loadContentWithParams("transaction.purchase_request", {});
    });
</script>


<script type="text/javascript">
    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."product.products_controller/readListProduct"; ?>',
            postData: {
                stock_qty : $('#stock_qty').val(),
                purchase_request_id : $('#purchase_request_id').val(),
                product_name : $('#prod_name').val()
            }
        });
        
        $("#grid-table").trigger("reloadGrid");

        responsive_jqgrid('#grid-table', '#grid-pager');
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

<script>
    jQuery(function($) {

        jQuery("#grid-table-detail").jqGrid({
            url: '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/crud"; ?>',
            postData: { purchase_request_id : '<?php echo $this->input->post('purchase_request_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'purchase_req_det_id', width: 5, sorttype: 'number', editable: true, hidden: true},
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
                {label: 'Total', name: 'amount', width: 100, align: "right", editable: false, search:false, sortable:false},
                
            ],
            // height: '100%',
            height: 200,
            autowidth: true,
            viewrecords: true,
            rowNum: 10000000,
            rowList: [10,20,30],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,            
            // cellEdit : true,
            cellsubmit : 'clientArray',
            onSelectRow: function (rowid) {
                /*do something when selected*/
                // alert('test');
                // setData(rowid);
            },
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
            sortorder:'',
            pager: '#grid-pager-detail',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

                // setTimeout(function(){
                //       $("#grid-table-detail").setSelection($("#grid-table-detail").getDataIDs()[1],true);
                //       // $("#grid-table").focus();
                // },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/crud"; ?>',
            caption: "Detail Permintaan Pembelian"

        });

        jQuery('#grid-table-detail').jqGrid('navGrid', '#grid-pager-detail',
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
        ).navButtonAdd('#grid-pager-detail',{
                caption: "", //Edit
                buttonicon: "simple-icon-note",
                onClickButton: function(){ 
                    var grid = $('#grid-table-detail');

                    // alert($('#irow').val());
                    // alert($('#icolumn').val());

                    // grid.jqGrid('setGridParam', {cellEdit: true});
                    // grid.jqGrid('editCell', $('#irow').val(), $('#icolumn').val(), true);
                    // grid.jqGrid('setGridParam', {cellEdit: false});

                    rowid = grid.jqGrid ('getRowData');
                    if(rowid == null) {
                        swal('','Data tidak ditemukan','info');
                        return false;
                    }
                    edit_product(rowid);
                },
                position: "last",
                title: "Edit",
                cursor: "pointer",
                id : "btn-edit"
        }).navButtonAdd('#grid-pager-detail',{
                caption: "", //Delete
                buttonicon: "simple-icon-minus",
                onClickButton: function(){ 
                    var grid = $('#grid-table-detail');
                    rowid = grid.jqGrid ('getGridParam', 'selrow');
                    if(rowid == null) {
                        swal('','Silakan pilih salah satu baris','info');
                        return false;
                    }
                    delete_product(rowid);
                },
                position: "last",
                title: "Delete",
                cursor: "pointer",
                id : "btn-delete"
        });

    });

</script>
<script type="text/javascript">

    function add_product(rowid){
        var var_url = '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/create"; ?>';

        var dataPost = new Array();
        var grid = $('#grid-table');

        rowid.forEach(function(value){


            dataPost.push({'product_id' : grid.jqGrid('getCell', value, 'product_id'), 
                           'purchase_request_id' : $('#purchase_request_id').val(),
                           'purchase_req_det_id' : null,
                           'amount' : 0,
                           'qty' : 0,
                           'basic_price' : 0,
                       });
        });

        swal({
              title: "Permintaan Pembelian",
              text: "data akan dimasukan kedalam daftar apakah anda yakin?",
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
                    data: { data : dataPost },
                    success: function(data) {
                        //console.log(data);
                        if(data.success) {                    
                            $("#grid-table").trigger("reloadGrid");
                            $("#grid-table-detail").trigger("reloadGrid");
                            swal("", data.message, "success");
                        }else{
                            swal("", data.message, "warning");
                        }
                       
                    }
                });

            return false;
        });
    }

    function edit_product(rowid){    
        // console.log(rowid);
        var var_url = '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/update"; ?>';

        swal({
              title: "Permintaan Pembelian",
              text: "data akan diubah apakah anda yakin?",
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
                            $("#grid-table-detail").trigger("reloadGrid");
                            swal("", data.message, "success");
                        }else{
                            swal("", data.message, "warning");
                        }
                       
                    }
                });

            return false;
        });
    }

    function delete_product(){
        var purchase_req_det_id = $('#grid-table-detail').jqGrid('getCell', rowid, 'purchase_req_det_id');
        var purchase_request_id = $('#grid-table-detail').jqGrid('getCell', rowid, 'purchase_request_id');
        var product_id = $('#grid-table-detail').jqGrid('getCell', rowid, 'product_id');

        swal({
              title: "",
              text: "Apakah anda ingin menghapus data ini?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var del = { id_ : purchase_req_det_id, purchase_request_id : purchase_request_id, product_id : product_id };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."transaction.purchase_req_det_controller/crud"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {items:itemJSON, oper:'del'},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            $("#grid-table").trigger("reloadGrid");
                            $("#grid-table-detail").trigger("reloadGrid");

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

    function searchDataReq(){
        jQuery("#grid-table-detail").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."transaction.purchase_req_det_controller/crud"; ?>',
            postData: { 
                purchase_request_id : '<?php echo $this->input->post('purchase_request_id'); ?>',
                product_name : $('#prod_name_req').val()
            }
        });
        
        $("#grid-table-detail").trigger("reloadGrid");

        responsive_jqgrid('#grid-table-detail', '#grid-pager-detail');
    }

    function download_excel(){

        var purchase_request_id = <?php echo $this->input->post('purchase_request_id'); ?>;
        
        var url = "<?php echo WS_JQGRID . "transaction.purchase_req_det_controller/download_excel/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&purchase_request_id="+purchase_request_id;

        window.location = url;    

    }
</script>