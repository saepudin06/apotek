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
                    <a href="javascript:;">Payment</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Adjustment</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-30 text-center">
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Adjustment</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Dokumen Pendukung</strong></a>
                </li>
                <li class="nav-item w-20 text-center">
                    <a class="nav-link active" id="tab-3" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
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

                            <input class="form-control" type="hidden" id="adj_store_stock_id" name="adj_store_stock_id" value="<?php echo $this->input->post('adj_store_stock_id');?>" placeholder="" autocomplete="off" readonly="" />

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="adj_store_stock_dt_id" name="adj_store_stock_dt_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="product_name" name="product_name" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Produk *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_product('product_id', 'product_name','stock_min')">Cari <i class="simple-icon-question"></i></button>
                                </div>

                                <input type="hidden" name="stock_min" id="stock_min" />


                                <input class="form-control" type="hidden" id="product_id" name="product_id" placeholder="" autocomplete="off" readonly="" />


                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="store" name="store" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Info Penyimpanan *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_store('store_id', 'store')">Cari <i class="simple-icon-question"></i></button>
                                </div>

                                <input class="form-control" type="hidden" id="store_id" name="store_id" placeholder="" autocomplete="off" readonly="" />

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
                                     <select class="form-control" id="dc" name="dc">
                                        <option value=""> -- Pilih Debit/Kredit -- </option>
                                            <option value="1"> Debit </option>
                                            <option value="-1"> Kredit </option>
                                    </select>
                                    <span>Debit/Kredit</span>
                                </label>

                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-12">
                                    <input class="form-control" id="description" name="description" placeholder="" autocomplete="off" autofocus=""  />
                                    <span>Keterangan</span>
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

<?php $this->load->view('lov/lov_product'); ?>
<?php $this->load->view('lov/lov_store_info'); ?>

<script type="text/javascript">
    function search_product(id, code, stock_min){
        modal_lov_product_show(id, code, stock_min);
    }

    function search_store(id, code){
        modal_lov_store_info_show(id, code);
    }
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/crud"; ?>',
            postData: { adj_store_stock_id : '<?php echo $this->input->post('adj_store_stock_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'Adjustment Detail ID', name: 'adj_store_stock_dt_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Adjustment ID', name: 'adj_store_stock_id', width: 240, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Product ID', name: 'product_id', width: 240, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Store ID', name: 'store_id', width: 240, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Product', name: 'product_name', width: 240, align: "left", editable: false, search:false, sortable:false},
                {label: 'Info Penyimpanan', name: 'store', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Harga Awal', name: 'basic_price', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Jumlah', name: 'qty', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Debit/Kredit', name: 'dc_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Debit/Kredit', name: 'dc', width: 150, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Keterangan', name: 'description', width: 250, align: "left", editable: false, search:false, sortable:false},
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
            editurl: '<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/crud"; ?>',
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
                     // alert("Adding Row");
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

    $(window).bind('resize', function() {
        responsive_jqgrid('#grid-table', '#grid-pager');    
    }).trigger('resize');

</script>


<script type="text/javascript">
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();
        
        loadContentWithParams("payment.adj_store_stock", {});
    });

    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        var idd = '<?php echo $this->input->post('adj_store_stock_id');?>';
        if(idd == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        loadContentWithParams("payment.adj_store_evd", {
            adj_store_stock_id: idd
        });
        
    });
</script>

<script type="text/javascript">

    function setData(rowid){
        
        var adj_store_stock_id = $('#grid-table').jqGrid('getCell', rowid, 'adj_store_stock_id');
        var store_id  = $('#grid-table').jqGrid('getCell', rowid, 'store_id');
        var store  = $('#grid-table').jqGrid('getCell', rowid, 'store');
        var product_id  = $('#grid-table').jqGrid('getCell', rowid, 'product_id');
        var product_name  = $('#grid-table').jqGrid('getCell', rowid, 'product_name');
        var basic_price  = $('#grid-table').jqGrid('getCell', rowid, 'basic_price');
        var qty  = $('#grid-table').jqGrid('getCell', rowid, 'qty');
        var dc  = $('#grid-table').jqGrid('getCell', rowid, 'dc');
        var description  = $('#grid-table').jqGrid('getCell', rowid, 'description');
        
        $('#adj_store_stock_dt_id').val(rowid);
        $('#adj_store_stock_id').val(adj_store_stock_id);
        $('#store_id').val(store_id);        
        $('#store').val(store);        
        $('#product_id').val(product_id);        
        $('#product_name').val(product_name);        
        $('#basic_price').val(basic_price);        
        $('#qty').val(qty);        
        $('#dc').val(dc);        
        $('#description').val(description);        

    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

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
                    url: "<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/crud"; ?>" ,
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
        data.append("bu_id_dest", $("#bu_id_dest").val());
        var adj_store_stock_dt_id = $('#adj_store_stock_dt_id').val();
            
        var var_url = '<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/create"; ?>';
        if(adj_store_stock_dt_id) var_url = '<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."payment.adj_store_stock_dt_controller/read"; ?>',
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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>