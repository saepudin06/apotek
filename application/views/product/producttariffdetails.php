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
                    <a href="javascript:;">Produk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-6" role="tablist">
                <li class="nav-item w-30 text-center">
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Produk</strong></a>
                </li>
                <li class="nav-item w-30 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail Produk</strong></a>
                </li>
                <li class="nav-item w-30 text-center">
                    <a class="nav-link active" id="tab-3" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Tarif</strong></a>
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
                        <h5 class="mb-4">Form Tarif</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $this->input->post('product_id'); ?>">

                            <input type="hidden" id="prd_details_id" name="prd_details_id" value="<?php echo $this->input->post('prd_details_id','');?>" placeholder="" autocomplete="off" readonly="" />

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="prod_tariff_id" name="prod_tariff_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input id="product_name" class="form-control" name="product_name" value="<?php echo $this->input->post('product_name'); ?>" readonly="" />
                                    <span>Nama Produk *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="product_label" name="product_label" value="<?php echo $this->input->post('product_label'); ?>" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Label *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" onkeypress="return isNumberKey(event)" id="basic_price" name="basic_price" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Harga Awal *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" onkeypress="return isNumberKey(event)" id="sell_price" name="sell_price" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Harga Jual *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" onkeypress="return isNumberKey(event)" id="tax" name="tax" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Pajak *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control datepicker" id="start_date" name="start_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Berlaku Dari *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control datepicker" id="end_date" name="end_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Berlaku Sampai</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="price_note" name="price_note" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Catatan *</span>
                                </label>
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


<script type="text/javascript">
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();

        loadContentWithParams("product.product", {});
    });

    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        product_id = $('#product_id').val();
        product_name = $('#product_name').val();

        if(product_id == null || product_id == '') {
            swal('','Product tidak ditemukan','info');
            return false;
        }

        loadContentWithParams("product.productdetails", {
            product_id: product_id,
            product_name : product_name
        });
    });
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."product.producttariffdetails_controller/crud"; ?>',
            postData: { prd_details_id : '<?php echo $this->input->post('prd_details_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'prod_tariff_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Product Detail ID', name: 'prd_details_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Label', name: 'product_label', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Harga Awal', name: 'basic_price', width: 150, align: "right", editable: false, search:false, sortable:false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},
                {label: 'Harga Jual', name: 'sell_price', width: 150, align: "right", editable: false, search:false, sortable:false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},
                {label: 'Pajak', name: 'tax', width: 150, align: "right", editable: false, search:false, sortable:false},
                {label: 'Berlaku Dari', name: 'start_date', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Berlaku Sampai', name: 'end_date', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Catatan', name: 'price_note', width: 150, align: "left", editable: false, search:false, sortable:false},
                
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
            editurl: '<?php echo WS_JQGRID."product.producttariffdetails_controller/crud"; ?>',
            caption: "Tarif (<?php echo $this->input->post('product_name','');?>)"

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

    function setData(rowid){
        
        var prd_details_id = $('#grid-table').jqGrid('getCell', rowid, 'prd_details_id');
        var product_label = $('#grid-table').jqGrid('getCell', rowid, 'product_label');
        var sell_price = $('#grid-table').jqGrid('getCell', rowid, 'sell_price');
        var basic_price = $('#grid-table').jqGrid('getCell', rowid, 'basic_price');
        var tax = $('#grid-table').jqGrid('getCell', rowid, 'tax');
        var price_note = $('#grid-table').jqGrid('getCell', rowid, 'price_note');
        var start_date = $('#grid-table').jqGrid('getCell', rowid, 'start_date');
        var end_date = $('#grid-table').jqGrid('getCell', rowid, 'end_date');
        
        $('#prod_tariff_id').val(rowid);
        $('#prd_details_id').val(prd_details_id);
        $('#product_label').val(product_label);
        $('#sell_price').val(sell_price);
        $('#basic_price').val(basic_price);
        $('#tax').val(tax);
        $('#price_note').val(price_note);
        $('#start_date').val(start_date);
        $('#end_date').val(end_date);   

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
                    url: "<?php echo WS_JQGRID."product.producttariffdetails_controller/crud"; ?>" ,
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
        // console.log(data);
        var prod_tariff_id = $('#prod_tariff_id').val();
            
        var var_url = '<?php echo WS_JQGRID."product.producttariffdetails_controller/create"; ?>';
        if(prod_tariff_id) var_url = '<?php echo WS_JQGRID."product.producttariffdetails_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."product.producttariffdetails_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."product.producttariffdetails_controller/read"; ?>',
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

    $('.select2-single').select2();
</script>