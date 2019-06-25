<div class="row">
    <div class="col-12 list">

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Administration</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Testing</li>
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
                        aria-selected="true"><strong>Testing</strong></a>
                </li>
            </ul>
            <div class="separator mb-2"></div>
            <div class="card-body">            

                <div class="row">
                <div class="col-md-8">

                        <!-- <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"> -->
                    <div class="col-md-12">
                        <div class="row">
                            
                            <input type="hidden" class="form-control" id="product_id" name="product_id" placeholder="" autocomplete="off" />

                            <div class="col-md-5">
                                <label class="form-group has-float-label">
                                    <input class="form-control" id="product_code" name="product_code" placeholder="" autocomplete="off" onkeyup="searchByCode(event)" />
                                    <span>Code *</span>
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label class="form-group has-float-label">
                                    <input class="form-control" type="number" id="qty" name="qty" min="1" value="1" autocomplete="off" placeholder="" onkeyup="searchByCode(event)" />
                                    <span>Qty *</span>
                                </label>
                            </div>

                            <div  class="col-md-2">
                                <button class="btn btn-secondary default mb-1" type="button" onclick="addprod()" id="btn-submit">Submit</button>
                            </div>
                        </div>
                    </div>                        

                    <div class="col-md-12">
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="col-md-12" style="padding-top: 55px;">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-group">Total :</label>
                            </div>
                            <div class="col-md-7">
                                <div style="text-align: right; margin-right: 5px;"><label class="form-group" id="total"></label></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-group">Potongan :</label>
                            </div>
                            <div class="col-md-7">
                                <div style="text-align: right; margin-right: 5px;"><label class="form-group" id="potongan"></label></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-group">Bayar :</label>
                            </div>
                            <div class="col-md-7">
                                <input style="text-align: right;" autocomplete="off" id="bayar" >
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="col-md-5">
                                <label class="form-group"><h3>Sub-Total :</h3></label>
                            </div>
                            <div class="col-md-7">
                                <h3><div style="text-align: right; margin-right: 5px;"><label class="form-group" id="sub-total"></label></div></h3>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-block default mb-1" type="button">Bayar</button>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>    
    $('#product_code').focus();
    //Creating Product
    function Product(prod_id, code, name, qty, price) {
        this.product_id = prod_id;
        this.product_code = code;
        this.product_name = name;        
        this.qty = qty;
        this.product_price = price;
        this.total = qty*price;
    }

    function GetAllProduct() {
        var listOfProd = [];

        this.rows = listOfProd;
        this.page = 1;
        this.total = listOfProd.length;
    }

    var data = new GetAllProduct();

    function addprod(){
        var product_id = $('#product_id').val();
        var product_code = $('#product_code').val();
        var qty = $('#qty').val();
        var obj_id = data.rows.length;
        var id = obj_id + 1;
        console.log(product_code.length);
        if(product_code.length != 13){
            return false;
        }

        if(product_id){
            
            $.ajax({
                url: "<?php echo WS_JQGRID."test.product_controller/read"; ?>" ,
                type: "POST",
                dataType: "json",
                data: {
                        product_code : product_code,
                        _search : ''
                      },
                success: function (res) {
                    
                    if (res.records == 1){
                        var obj_id = product_id-1;
                        data.rows[obj_id] = new Product(product_id, product_code, res.rows[0].product_name, qty, res.rows[0].product_price);
                         jQuery("#grid-table").jqGrid('setGridParam',{
                            datatype: 'jsonstring',
                            datastr :  data
                        });

                        $("#grid-table").trigger("reloadGrid");
                        $("#product_code").removeAttr('readonly');
                        $('#product_code').val('');
                        $('#product_id').val('');
                        $('#qty').val(1);

                    }

                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });

        }else{

            $.ajax({
                url: "<?php echo WS_JQGRID."test.product_controller/read"; ?>" ,
                type: "POST",
                dataType: "json",
                data: {
                        product_code : product_code,
                        _search : ''
                      },
                success: function (res) {
                    
                    if (res.records == 1){
                        data.rows[obj_id] = new Product(id, product_code, res.rows[0].product_name, qty, res.rows[0].product_price);
                         jQuery("#grid-table").jqGrid('setGridParam',{
                            datatype: 'jsonstring',
                            datastr :  data
                        });

                        $("#grid-table").trigger("reloadGrid");
                        $('#product_code').val('');
                        $('#qty').val(1);
                    }

                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });

        }
        
    }

    function searchByCode(event){

        if (event.keyCode === 13) {
            event.preventDefault();
            addprod();
            $('#product_code').focus();
        }
        
    }

    function setData(rowid){
        
        var product_code = $('#grid-table').jqGrid('getCell', rowid, 'product_code');
        var qty = $('#grid-table').jqGrid('getCell', rowid, 'qty');
        
        $('#product_id').val(rowid);
        $('#product_code').val(product_code);
        $('#qty').val(qty);
        $('#product_code').attr("readonly", "readonly");
        $('#qty').focus();

    }

    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            datatype: "jsonstring",
            datastr: [],
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'product_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Code', name: 'product_code', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Product', name: 'product_name', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Quantity', name: 'qty', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Price', name: 'product_price', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Total', name: 'total', width: 120, align: "left", editable: false, search:false, sortable:false},
                
            ],
            height: 210,
            autowidth: true,
            viewrecords: true,
            rowNum: 100000000000,
            rowList: [],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/
                setData(rowid);
            },
            sortname: 'product_id',
            sortorder:'asc',
            pager: '#grid-pager',
            jsonReader: {
                root: "rows",
                page: "page",
                total: "total"
            },
            localReader: {repeatitems: true},
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

                var rowData = jQuery("#grid-table").getDataIDs();
                var total_amount = 0;
                
                for (var i = 0; i < rowData.length; i++) {
                    var total = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'total');
                    total_amount = total_amount + parseFloat(total);
                }

                $('#total').text(total_amount);
                $('#potongan').text(0);
                $('#sub-total').text(total_amount);
                

            },
            //memanggil controller jqgrid yang ada di controller crud
            caption: "Transaksi"

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
        );

    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>

