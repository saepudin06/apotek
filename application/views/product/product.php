<div class="row">
    <div class="col-12 list">
        <div class="float-sm-right text-zero">
            <!-- <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                <input onchange="searchData()" id="search-data" placeholder="Search...">
            </div> -->
        </div>

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Product</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-6" role="tablist">
                <li class="nav-item w-30 text-center">
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Products</strong></a>
                </li>
                <li class="nav-item w-30 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Product Detail</strong></a>
                </li>
                <li class="nav-item w-30 text-center">
                    <a class="nav-link" id="tab-3" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Tariff Product</strong></a>
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
                        <h5 class="mb-4">Form Products</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="product_id" name="product_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="name" name="name" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Name *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <select class="form-control select2-single" id="product_type_id">
                                        <!-- <option label="&nbsp;">&nbsp;</option> -->
                                        <?php
                                            $ci = & get_instance();
                                            $ci->load->model('product/producttype');
                                            $table = $ci->producttype;

                                            $items = $table->getAll(0,-1,'product_type_id','asc');

                                        ?>
                                        <option value=""> -- Choose Product Type -- </option>
                                        <?php foreach($items as $item):?>
                                            <option value="<?php echo $item['product_type_id'];?>"> <?php echo $item['name'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span>Product Type *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <select class="form-control select2-single" id="bu_id">
                                        <!-- <option label="&nbsp;">&nbsp;</option> -->
                                        <?php
                                            $ci = & get_instance();
                                            $ci->load->model('admin/bunit');
                                            $table = $ci->bunit;

                                            $items = $table->getAll(0,-1,'bu_id','asc');

                                        ?>
                                        <option value=""> -- Choose Bussiness Unit -- </option>
                                        <?php foreach($items as $item):?>
                                            <option value="<?php echo $item['bu_id'];?>"> <?php echo $item['name'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span>Bussiness Unit *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <select class="form-control select2-single" id="measure_type_id">
                                        <!-- <option label="&nbsp;">&nbsp;</option> -->
                                        <?php
                                            $ci = & get_instance();
                                            $ci->load->model('product/productmeasurement');
                                            $table = $ci->productmeasurement;

                                            $items = $table->getAll(0,-1,'measure_type_id','asc');

                                        ?>
                                        <option value=""> -- Choose Measure Type -- </option>
                                        <?php foreach($items as $item):?>
                                            <option value="<?php echo $item['measure_type_id'];?>"> <?php echo $item['name'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span>Measure Type *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <select class="form-control select2-single" id="package_type_id">
                                        <!-- <option label="&nbsp;">&nbsp;</option> -->
                                        <?php
                                            $ci = & get_instance();
                                            $ci->load->model('product/productpackagetype');
                                            $table = $ci->productpackagetype;

                                            $items = $table->getAll(0,-1,'package_type_id','asc');

                                        ?>
                                        <option value=""> -- Choose Package Type -- </option>
                                        <?php foreach($items as $item):?>
                                            <option value="<?php echo $item['package_type_id'];?>"> <?php echo $item['name'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span>Package Type *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control numeric" id="package_val" name="package_val" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Package Value. *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control numeric" id="stock_min" name="stock_min" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Stock Min. *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control numeric" id="initial_stock" name="initial_stock" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Initial Stock *</span>
                                </label>
                            </div>

                            <button class="btn btn-secondary" type="submit" id="btn-submit">Submit</button>
                            <button class="btn btn-danger" type="button" id="btn-cancel">Cancel</button>

                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');
        product_id = grid.jqGrid ('getGridParam', 'selrow');
        name = grid.jqGrid ('getCell', product_id, 'name');

        if(product_id == null || product_id == '') {
            swal('','Please select one row','info');
            return false;
        }

        loadContentWithParams("product.productdetails", {
            product_id: product_id,
            product_name : name
        });
    });
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."product.products_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'product_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Product Type ID', name: 'product_type_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Bussiness Unit ID', name: 'bu_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Measure Type ID', name: 'measure_type_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Package Type ID', name: 'package_type_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Name', name: 'name', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Product Type', name: 'product_type_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Bussiness Unit', name: 'bu_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Measure Type', name: 'measure_type_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Package Type', name: 'package_type_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Package Value', name: 'package_val', width: 150, align: "right", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Stock Min.', name: 'stock_min', width: 100, align: "right", editable: false, search:false, sortable:false, hidden: false},
                {label: 'Initial Stock', name: 'initial_stock', width: 100, align: "right", editable: false, search:false, sortable:false, hidden: false},
                
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
                      $("#grid-table").focus();
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."product.products_controller/crud"; ?>',
            caption: "Products"

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

                    $('#product_type_id').val(null).trigger('change');
                    $('#bu_id').val(null).trigger('change');
                    $('#measure_type_id').val(null).trigger('change');
                    $('#package_type_id').val(null).trigger('change');
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
                        swal('','Please select one row','info');
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
                        swal('','Please select one row','info');
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
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>

<script type="text/javascript">

    function setData(rowid){
        
        var product_type_id = $('#grid-table').jqGrid('getCell', rowid, 'product_type_id');
        var bu_id = $('#grid-table').jqGrid('getCell', rowid, 'bu_id');
        var measure_type_id = $('#grid-table').jqGrid('getCell', rowid, 'measure_type_id');
        var package_type_id = $('#grid-table').jqGrid('getCell', rowid, 'package_type_id');
        var name = $('#grid-table').jqGrid('getCell', rowid, 'name');
        var package_val = $('#grid-table').jqGrid('getCell', rowid, 'package_val');
        var stock_min  = $('#grid-table').jqGrid('getCell', rowid, 'stock_min');
        var initial_stock  = $('#grid-table').jqGrid('getCell', rowid, 'initial_stock');
        
        $('#product_id').val(rowid);
        $('#product_type_id').val(product_type_id);
        $('#bu_id').val(bu_id);
        $('#measure_type_id').val(measure_type_id);
        $('#package_type_id').val(package_type_id);
        $('#product_type_id').trigger('change');
        $('#bu_id').trigger('change');
        $('#measure_type_id').trigger('change');
        $('#package_type_id').trigger('change');

        $('#name').val(name);
        $('#package_val').val(package_val);
        $('#stock_min').val(stock_min);        
        $('#initial_stock').val(initial_stock);        

    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

    /*delete*/
    function delete_data(rowid){
        swal({
              title: "",
              text: "Do you want to delete this Data?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var del = { id_ : rowid };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."product.products_controller/crud"; ?>" ,
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
        data.append("product_type_id", $("#product_type_id").val());
        data.append("bu_id", $("#bu_id").val());
        data.append("measure_type_id", $("#measure_type_id").val());
        data.append("package_type_id", $("#package_type_id").val());
        // console.log(data);
        var product_id = $('#product_id').val();
            
        var var_url = '<?php echo WS_JQGRID."product.products_controller/create"; ?>';
        if(product_id) var_url = '<?php echo WS_JQGRID."product.products_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."product.products_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."product.products_controller/read"; ?>',
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

    $('.select2-single').select2();
</script>