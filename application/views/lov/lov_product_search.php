<div id="modal_lov_product_search" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Product </span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_product_search_id_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div class="row">
                    <label class="control-label col-md-2">Pencarian :</label>
                    <div class="col-md-9">
                        <div class="input-group col-md-9">
                            <!-- <input id="i_search_lov_product_search" type="text" class="form-control"> -->
                            <input type="text" class="form-control" id="i_search_lov_product_search" placeholder="Search" onkeyup="filter_lov_product_search()">
                            <!-- <span class="input-group-btn">
                                <button class="btn  btn-primary default" type="button" onclick="filter_lov_product_search()">Cari</button>
                            </span> -->
                        </div>
                    </div>
                </div>
                <div style="padding-bottom: 10px;"></div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="grid-table-lov_product_search"></table>
                        <div id="grid-pager-lov_product_search"></div>
                    </div>
                </div>
                <div style="padding-bottom: 10px;"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="font-weight: bold;">Shift : Select Grid   |  Enter : Select one row | Ctrl : search</div>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>
    $(function($) {
        $("#modal_lov_product_search_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_product_search_id_val").val()).val("");            
            $("#modal_lov_product_search").modal("toggle");
        });
    });

    function modal_lov_product_search_show(the_id_field) {
        modal_lov_product_search_set_field_value(the_id_field);
        setTimeout(function() {
            $('#i_search_lov_product_search').focus();
        }, 1000);       

        $("#modal_lov_product_search").modal({backdrop: 'static'});
        modal_lov_product_search_prepare_table();
    }


    function modal_lov_product_search_set_field_value(the_id_field) {
         $("#modal_lov_product_search_id_val").val(the_id_field);         
    }

    function modal_lov_product_search_set_value(the_id_val) {
         $("#"+ $("#modal_lov_product_search_id_val").val()).val(the_id_val);
         $("#modal_lov_product_search").modal("toggle");

         $("#"+ $("#modal_lov_product_search_id_val").val()).change();
    }


    function modal_lov_product_search_prepare_table() {
        var grid_selector = "#grid-table-lov_product_search";
        var pager_selector = "#grid-pager-lov_product_search";

        jQuery("#grid-table-lov_product_search").jqGrid({
            url: '<?php echo WS_JQGRID."product.producttariffdetails_controller/readLov"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'Product ID', name: 'product_id', width: 100, align: "left", editable: false, hidden:true},
                {label: 'Product Label',name: 'product_label',width: 150, align: "left",editable: false },
                {label: 'Product Name',name: 'product_name',width: 150, align: "left",editable: false },
                {label: 'Sell Price', name: 'sell_price', width: 150, align: "left", editable: false, search:false, sortable:false},
            ],
            height: '100%',
            width: 750,
            viewrecords: true,
            rowNum: 5,
            // rowList: [5,10],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/

            },
            ondblClickRow: function(rowid) {

                // var grid = $('#grid-table-lov_product_search');
                // var sel_id = grid.jqGrid('getGridParam', 'selrow');
                // var product_id = grid.jqGrid('getCell', sel_id, 'product_id');
                // var product_name = grid.jqGrid('getCell', sel_id, 'name');

                // modal_lov_product_search_set_value(product_id,product_name);

            },
            sortorder:'',
            pager: '#grid-pager-lov_product_search',
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
                //       $("#grid-table-lov_product_search").setSelection($("#grid-table-lov_product_search").getDataIDs()[0],true);
                //       $("#grid-table-lov_product_search").focus();
                // },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."product.producttariffdetails_controller/crud"; ?>',
            caption: ""

        });

        jQuery('#grid-table-lov_product_search').jqGrid('bindKeys', {
             onEnter: function(rowid) {
                var grid = $('#grid-table-lov_product_search');
                var product_label = grid.jqGrid('getCell', rowid, 'product_label');
                modal_lov_product_search_set_value(product_label);
             }
             // onEnter: null,
             // onSpace: null,
             // onLeftKey: null, 
             // onRightKey: null,
        });

        jQuery('#grid-table-lov_product_search').jqGrid('navGrid', '#grid-pager-lov_product_search',
            {   //navbar options
                edit: false,
                editicon: 'fa fa-pencil blue bigger-120',
                add: false,
                addicon: 'fa fa-plus-circle purple bigger-120',
                del: false,
                delicon: 'fa fa-trash-o red bigger-120',
                search: false,
                searchicon: 'fa fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here
                },

                refreshicon: 'fa fa-refresh green bigger-120',
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

                    clearInputStatusList();

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
    }

    function filter_lov_product_search(){
        var i_search_lov_product_search = $('#i_search_lov_product_search').val();
        
        jQuery("#grid-table-lov_product_search").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."product.producttariffdetails_controller/readLov"; ?>',
                postData: {
                    i_search : i_search_lov_product_search
                }
            });
            $("#grid-table-lov_product_search").trigger("reloadGrid");
    }
</script>