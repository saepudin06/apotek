<div id="modal_lov_store_info" class="modal fade" tabindex="-1" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- modal title -->
            <div class="modal-header no-padding">
                <div class="table-header">
                    <span class="form-add-edit-title"> Data Supplier </span>
                </div>
            </div>
            <input type="hidden" id="modal_lov_store_info_id_val" value="" />
            <input type="hidden" id="modal_lov_store_info_name_val" value="" />

            <!-- modal body -->
            <div class="modal-body">
                <div>
                  <button type="button" class="btn btn-sm btn-success default" id="modal_lov_store_info_btn_blank">
                      Kosong
                  </button>

                  <button class="btn btn-danger btn-sm default" data-dismiss="modal">
                       Tutup
                  </button>
                </div>

                <div style="padding-bottom: 20px;"></div>
                <div class="row">
                    <label class="control-label col-md-2">Pencarian :</label>
                    <div class="col-md-9">
                        <div class="input-group col-md-9">
                            <!-- <input id="i_search_lov_store_info" type="text" class="form-control"> -->
                            <input type="text" class="form-control" id="i_search_lov_store_info" placeholder="Search">
                            <span class="input-group-btn">
                                <button class="btn  btn-primary default" type="button" onclick="filter_lov_store_info()">Cari</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div style="padding-bottom: 10px;"></div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="grid-table-lov_store_info"></table>
                        <div id="grid-pager-lov_store_info"></div>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.end modal -->

<script>
    $(function($) {
        $("#modal_lov_store_info_btn_blank").on('click', function() {
            $("#"+ $("#modal_lov_store_info_id_val").val()).val("");
            $("#"+ $("#modal_lov_store_info_name_val").val()).val("");
            $("#modal_lov_store_info").modal("toggle");
        });
    });

    function modal_lov_store_info_show(the_id_field, the_code_field) {
        modal_lov_store_info_set_field_value(the_id_field, the_code_field);
        $("#modal_lov_store_info").modal({backdrop: 'static'});
        modal_lov_store_info_prepare_table();
    }


    function modal_lov_store_info_set_field_value(the_id_field, the_code_field) {
         $("#modal_lov_store_info_id_val").val(the_id_field);
         $("#modal_lov_store_info_name_val").val(the_code_field);
    }

    function modal_lov_store_info_set_value(the_id_val, the_code_val) {
         $("#"+ $("#modal_lov_store_info_id_val").val()).val(the_id_val);
         $("#"+ $("#modal_lov_store_info_name_val").val()).val(the_code_val);
         $("#modal_lov_store_info").modal("toggle");

         $("#"+ $("#modal_lov_store_info_id_val").val()).change();
         $("#"+ $("#modal_lov_store_info_name_val").val()).change();
    }


    function modal_lov_store_info_prepare_table() {
        var grid_selector = "#grid-table-lov_store_info";
        var pager_selector = "#grid-pager-lov_store_info";

        jQuery("#grid-table-lov_store_info").jqGrid({
            url: '<?php echo WS_JQGRID."store.storeinfo_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'Store Info ID', name: 'store_info_id', width: 100, align: "left", editable: false, hidden:true},
                {label: 'Kode Gudang', name: 'code', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Lokasi',name: 'name',width: 150, align: "left",editable: false },
                {label: 'Keterangan',name: 'description',width: 150, align: "left",editable: false },
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

                var grid = $('#grid-table-lov_store_info');
                var sel_id = grid.jqGrid('getGridParam', 'selrow');
                var store_info_id = grid.jqGrid('getCell', sel_id, 'store_info_id');
                var name = grid.jqGrid('getCell', sel_id, 'name');

                modal_lov_store_info_set_value(store_info_id,name);

            },
            sortorder:'',
            pager: '#grid-pager-lov_store_info',
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
                      $("#grid-table-lov_store_info").setSelection($("#grid-table-lov_store_info").getDataIDs()[0],true);
                      // $("#grid-table-lov_store_info").focus();
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."store.supplier_controller/crud"; ?>',
            caption: ""

        });

        jQuery('#grid-table-lov_store_info').jqGrid('navGrid', '#grid-pager-lov_store_info',
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
                serializeEditData: serializeJSON,
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
                serializeEditData: serializeJSON,
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
                serializeDelData: serializeJSON,
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

    $('#i_search_lov_store_info').on('keyup', function(event){
        event.preventDefault();
        if(event.keyCode === 13) {
            var i_search_lov_store_info = $('#i_search_lov_store_info').val();
            jQuery("#grid-table-lov_store_info").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."store.supplier_controller/read"; ?>',
                postData: {
                    i_search : i_search_lov_store_info
                }
            });
            $("#grid-table-lov_store_info").trigger("reloadGrid");
        }
    });

    function filter_lov_store_info(){
        var i_search_lov_store_info = $('#i_search_lov_store_info').val();
        
        jQuery("#grid-table-lov_store_info").jqGrid('setGridParam',{
                url: '<?php echo WS_JQGRID."store.supplier_controller/read"; ?>',
                postData: {
                    i_search : i_search_lov_store_info
                }
            });
            $("#grid-table-lov_store_info").trigger("reloadGrid");
    }
</script>