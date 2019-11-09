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
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-6" role="tablist">
                <li class="nav-item w-40 text-center">
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Pengecekan Barang</strong></a>
                </li>
                <li class="nav-item w-20 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
                </li>
                <li class="nav-item w-40 text-center">
                    <a class="nav-link" id="tab-3" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Dokumen Pendukung</strong></a>
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
                            <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="<?php echo $this->input->post('purchase_order_id'); ?>">
                            <input type="hidden" name="goods_recieve_nt_id" id="goods_recieve_nt_id" value="<?php echo $this->input->post('goods_recieve_nt_id'); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="good_rcv_nt_dt_id" name="good_rcv_nt_dt_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="product_name" name="product_name" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Produk *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control datepicker" id="exp_date" name="exp_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Tgl. Kedaluwarsa *</span>
                                </label>

                                <!-- <label class="form-group has-float-label col-md-4">
                                    <select class="form-control" name="status" id="status">
                                        <option value="PASSED">PASSED</option>
                                        <option value="CANCELED">CANCELED</option>
                                        <option value="RETURN">RETURN</option>
                                    </select>
                                    <span>Status *</span>
                                </label> -->
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="status" name="status" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Status *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="store_info" name="store_info" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>Info Penyimpanan *</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_store('store_info_id', 'store_info')">Search</button>
                                </div>

                                <input class="form-control" type="hidden" id="store_info_id" name="store_info_id" placeholder="" autocomplete="off" readonly="" />
                            </div>

                            <div class="form-row">
                                 <label class="form-group has-float-label col-md-12">
                                    <input class="form-control" id="note" name="note" placeholder="" autocomplete="off" autofocus="" />
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

<?php $this->load->view('lov/lov_store_info'); ?>

<script type="text/javascript">
    function search_store(id, code){
        modal_lov_store_info_show(id, code);
    }
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_dt_controller/crud"; ?>',
            postData: { goods_recieve_nt_id : '<?php echo $this->input->post('goods_recieve_nt_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'good_rcv_nt_dt_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: '<center>Action (Status)</center>',width: 300, align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var status = rowObject['status'];
                        var rowid = options.rowId;

                        var PASSED = "PASSED";
                        var CANCELED = "CANCELED";
                        var RETURN = "RETURN";

                        if(status == '' || status == null || status == 'null' || status == 'INITIAL'){
                            return '<button class="btn btn-primary btn-xs default" onclick="updateStatus('+rowid+',\''+PASSED+'\')">PASSED</button> <button class="btn btn-warning btn-xs default" onclick="updateStatus('+rowid+',\''+CANCELED+'\')">CANCELED</button> <button class="btn btn-danger btn-xs default" onclick="updateStatus('+rowid+',\''+RETURN+'\')">RETURN</button>';
                        }else{
                            return status;
                        }
                    }
                },
                {label: 'Goods Recieve Note ID', name: 'goods_recieve_nt_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Purchase Order Det ID', name: 'store_info_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Invoice Num', name: 'invoice_num_ref', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Produk', name: 'product_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Info Penyimpanan', name: 'store_info', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tgl. Kedaluwarsa', name: 'exp_date', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Harga Awal', name: 'basic_price', width: 120, align: "right", editable: false, search:false, sortable:false},
                {label: 'Jumlah', name: 'qty', width: 100, align: "right", editable: false, search:false, sortable:false},
                {label: 'Total', name: 'amount', width: 120, align: "right", editable: false, search:false, sortable:false},
                {label: 'Status', name: 'status', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Catatan', name: 'note', width: 300, align: "left", editable: false, search:false, sortable:false},
                
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
            editurl: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_dt_controller/crud"; ?>',
            caption: "Detail"

        });

        // jQuery("#grid-table").jqGrid('setFrozenColumns');

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
        );
        // .navButtonAdd('#grid-pager',{
        //         caption: "", //Edit
        //         buttonicon: "simple-icon-note",
        //         onClickButton: function(rowid){ 
        //             var grid = $('#grid-table');
        //             rowid = grid.jqGrid ('getGridParam', 'selrow');
        //             if(rowid == null) {
        //                 swal('','Silakan pilih salah satu baris','info');
        //                 return false;
        //             }

        //             $('#grid-ui').hide();
        //             $('#form-ui').slideDown( "slow" );

        //             setData(rowid);

        //             // $('#form-ui').trigger("reset");
        //         },
        //         position: "last",
        //         title: "Edit",
        //         cursor: "pointer",
        //         id : "btn-edit"
        // });



    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $("#grid-ui").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    $("#grid-table").jqGrid("destroyFrozenColumns")
            .jqGrid("setColProp", "product_name", { frozen: true })
            .jqGrid("setFrozenColumns")
            .trigger("reloadGrid", [{ current: true}]);

    $(window).on("resize", function(event) {
       responsive_jqgrid('#grid-table', '#grid-pager');  
    });

</script>


<script type="text/javascript">
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');

        loadContentWithParams("transaction.goods_recieve_nt", {});
    });

    $("#tab-3").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');
        var goods_recieve_nt_id = '<?php echo $this->input->post('goods_recieve_nt_id');?>';
        var invoice_num_ref = '<?php echo $this->input->post('invoice_num_ref');?>';
        var purchase_order_id = '<?php echo $this->input->post('purchase_order_id');?>';


        if(goods_recieve_nt_id == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        
        loadContentWithParams("transaction.goods_rcv_nt_evd", {
            goods_recieve_nt_id: goods_recieve_nt_id,
            invoice_num_ref : invoice_num_ref,
            purchase_order_id : purchase_order_id
        });
    });
</script>

<script type="text/javascript">

    function setData(rowid, status){
        
        var goods_recieve_nt_id = $('#grid-table').jqGrid('getCell', rowid, 'goods_recieve_nt_id');
        var store_info_id = $('#grid-table').jqGrid('getCell', rowid, 'store_info_id');
        // var status = $('#grid-table').jqGrid('getCell', rowid, 'status');
        var exp_date  = $('#grid-table').jqGrid('getCell', rowid, 'exp_date');
        var note  = $('#grid-table').jqGrid('getCell', rowid, 'note');
        var product_name  = $('#grid-table').jqGrid('getCell', rowid, 'product_name');
        var store_info  = $('#grid-table').jqGrid('getCell', rowid, 'store_info');
        
        
        $('#good_rcv_nt_dt_id').val(rowid);
        $('#goods_recieve_nt_id').val(goods_recieve_nt_id);
        $('#store_info_id').val(store_info_id);
        $('#status').val(status);
        $('#exp_date').val(exp_date);        
        $('#note').val(note);        
        $('#product_name').val(product_name);        
        $('#store_info').val(store_info);        
    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });



    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault(); 
        var data = new FormData(this);
        var good_rcv_nt_dt_id = $('#good_rcv_nt_dt_id').val();

        swal({
              title: "",
              text: "Apakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var_url = '<?php echo WS_JQGRID."transaction.goods_recieve_nt_dt_controller/update"; ?>';
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
            url: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_dt_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."transaction.goods_recieve_nt_dt_controller/read"; ?>',
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