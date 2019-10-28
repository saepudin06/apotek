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
                <li class="breadcrumb-item active" aria-current="page">Stock Produk</li>
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
                        aria-selected="true"><strong>Stock Produk</strong></a>
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
            url: '<?php echo WS_JQGRID."product.stockproduct_controller/read"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'stock_product_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Product Id', name: 'product_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Store Info Id', name: 'store_info_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Product', name: 'product_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Lokasi', name: 'store_info', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Barang Masuk', name: 's_in', width: 150, align: "right", editable: false, search:false, sortable:false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},
                {label: 'Barang Keluar', name: 's_out', width: 150, align: "right", editable: false, search:false, sortable:false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},             
                {label: 'Total', name: 'totalqty', width: 150, align: "right", editable: false, search:false, sortable:false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},
                {label: 'Keterangan', name: 'description', width: 200, align: "left", editable: false, search:false, sortable:false},
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
            editurl: '<?php echo WS_JQGRID."product.stockproduct_controller/read"; ?>',
            caption: "Stock Produk"

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

    $(window).on("resize", function(event) {
       responsive_jqgrid('#grid-table', '#grid-pager');  
    });

</script>


<script type="text/javascript">

    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');
        var stock_product_id = grid.jqGrid('getGridParam', 'selrow');
        var product_name = grid.jqGrid('getCell', stock_product_id, 'product_name');
        
        if(stock_product_id == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        loadContentWithParams("product.stockproductdetails", {
            stock_product_id: stock_product_id,
            product_name: product_name
        });
    });

</script>

<script type="text/javascript">
    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."product.stockproduct_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."product.stockproduct_controller/read"; ?>',
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