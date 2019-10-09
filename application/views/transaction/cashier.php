
<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-group has-float-label">
                            <input class="form-control" id="product_label" name="product_label" placeholder="" autocomplete="off" onkeyup="addprod()" onchange="addprod()" />
                            <span>Product Label *</span>
                        </label>
                    </div>   
                    <div class="col-md-1">
                        <label class="form-group has-float-label">
                            <input class="form-control" id="qty" name="qty" value="1" autocomplete="off" placeholder="" readonly="" />
                            <span>Qty *</span>
                        </label>
                    </div> 
                    <div class="col-md-6" style="text-align: right;">
                        <input type="hidden" name="total_qty" id="total_qty" value="0" />
                        <input type="hidden" name="subtotal" id="subtotal" value="0" />
                        <h1><label class="control-label" id="sub-total">Sub Total : 0 </label></h1>
                    </div>
                    <div class="col-md-12" id="grid-ui">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>

                    <div class="col-md-12"><strong>F1 : Help &nbsp; | &nbsp; Esc : Close</strong></div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_help'); ?>
<?php $this->load->view('lov/lov_secret_key'); ?>
<?php $this->load->view('lov/lov_payment'); ?>
<?php $this->load->view('lov/lov_product_search'); ?>

<script type="text/javascript">

    function Product(grid_id, prod_id, product_label, name, qty, price) {
        this.grid_id = grid_id;
        this.product_id = prod_id;
        this.product_label = product_label;
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
        var obj_id = data.rows.length;
        // var id = obj_id + 1;
        var product_label = $('#product_label').val();
        
        var qty = $('#qty').val();

        if(product_label.length > 5){

            $.ajax({
                url: "<?php echo WS_JQGRID."transaction.cashier_controller/getProduct"; ?>" ,
                type: "POST",
                dataType: "json",
                data: {
                        product_label : product_label
                      },
                success: function (res) {
                    // console.log(res.rows.product_id);
                    if (res.total > 1){
                        var grid_id = obj_id+1;
                        // console.log($('#qty').val());
                        // var qty = $('#qty').val();
                         data.rows[obj_id] = new Product(grid_id, res.rows.product_id, product_label, res.rows.product_name, qty, res.rows.sell_price, res.rows.basic_price);
                        
                        jQuery("#grid-table").jqGrid('setGridParam',{
                            datatype: 'jsonstring',
                            datastr :  data
                        });

                        $("#grid-table").trigger("reloadGrid");
                        $('#product_label').val('');
                        $('#qty').val(1);
                        $('#product_label').focus();
                        return false;
                    }

                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
        }
    }
</script>

<script>
    $('#product_label').focus();

    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            datatype: "jsonstring",
            datastr: [],
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'idd', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Product ID', name: 'product_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Barcode', name: 'product_label', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Nama Produk', name: 'product_name', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Qty', name: 'qty', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Harga', name: 'product_price', width: 120, align: "left", editable: false, search:false, sortable:false},
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
                // setData(rowid);
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
                var total_qty = 0;
                
                for (var i = 0; i < rowData.length; i++) {
                    var total = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'total');
                    var qty = jQuery("#grid-table").jqGrid('getCell', rowData[i], 'qty');
                    total_amount = total_amount + parseFloat(total);
                    total_qty = total_qty + parseFloat(qty);
                }

                // $('#total').text(total_amount);
                $('#total_qty').val(total_qty);
                $('#subtotal').val(total_amount);
                $('#sub-total').text('Sub Total : '+total_amount);
                

            },
            //memanggil controller jqgrid yang ada di controller crud
            caption: "Transaksi"

        });

        jQuery('#grid-table').jqGrid('bindKeys', {
             // onLeftKey: function(rowid) {
             //    $('#product_label').focus();
             // },
             // onEnter: null,
             // onSpace: null,
             // onLeftKey: null, 
             // onRightKey: null,
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
        $(grid_selector).jqGrid( 'setGridWidth', $("#grid-ui").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    $(window).on("resize", function(event) {
       responsive_jqgrid('#grid-table', '#grid-pager');  
    });

</script>

<script type="text/javascript">
    function myFunction(event){
        // console.log(event.keyCode);
        /* tombol F1 */
        if(event.keyCode == 112) {
            event.preventDefault();
            // alert('Anda menekan tombol F1');
            modal_lov_help_show();
        }

        /* tombol F4 */
        if(event.keyCode == 115) {
            event.preventDefault();
            $("#grid-table").setSelection($("#grid-table").getDataIDs()[0],true);
            // $("#grid-table").focus();
        }

        /* tombol F9 */
        if(event.keyCode == 120) {
            event.preventDefault();
            modal_lov_product_search_show('product_label');
        }

        /* tombol Esc */
        if(event.keyCode == 27) {
            event.preventDefault();
            $("#product_label").focus();
        }

        /* tombol Delete */
        if(event.keyCode == 46) {
            event.preventDefault();

            modal_secret_key_show();
            
            
        }

        /* tombol F2 */
        if(event.keyCode == 113) {
            event.preventDefault();
            var subtot = $('#subtotal').val();
            if(subtot > 0){
                modal_payment_show(subtot);
            }
            // $("#product_label").focus();
        }

        /* tombol * */
         if(event.keyCode == 56) {
            event.preventDefault();
            
            var product_label = $('#product_label').val();
            if(product_label != 0){
                $('#qty').val(product_label);
                $('#product_label').val('');
                $('#product_label').focus();
            }
            
        }

        /* tombol Enter */
        if(event.keyCode == 13) {
            event.preventDefault();
            var cash = $('#cash').val();
            var subtotal = $('#subtotal').val();
            var total_qty = $('#total_qty').val();

            if(cash > 0){
                // alert(cash);
                // console.log(data.rows);
                var var_url = '<?php echo WS_JQGRID."transaction.cashier_controller/insertTrans"; ?>';

                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: var_url,
                    data: {
                        details : data.rows,
                        cash : cash,
                        subtotal : subtotal,
                        total_qty : total_qty
                    },
                    success: function(data) {
                       if(data.success){
                           $('#modal_payment').modal('toggle');
                           setTimeout(function() {
                                loadContentWithParams("transaction.cashier", {});
                            }, 1000);
                       }
                       
                    }
                });

                
            }
            
            // $("#product_label").focus();
        }


        /* tombol shift */
        if(event.keyCode == 16) {
            event.preventDefault();
            $("#grid-table-lov_product_search").setSelection($("#grid-table-lov_product_search").getDataIDs()[0],true);
            $("#grid-table-lov_product_search").focus();
            
        }

        /* tombol ctrl */
        if(event.keyCode == 17) {
            event.preventDefault();
            $("#i_search_lov_product_search").focus();
            
        }

    }
</script>
