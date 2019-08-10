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
                    <a href="javascript:;">System</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Role</li>
            </ol>
        </nav>
        <!-- <div class="separator mb-5"></div> -->
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Role</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Menu</strong></a>
                </li>
            </ul>
            <div class="separator mb-2"></div>
            <div class="card-body">            
                <!-- <h5 class="mb-4">Form Menu</h5> -->
                <div class="row">
                <div class="col-md-5">

                    <form method="post" id="form_data">

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <label class="form-group has-float-label">
                            <input class="form-control" id="role_id" name="role_id" placeholder="" autocomplete="off" readonly="" />
                            <span>ID *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="role_name" name="role_name" placeholder="" autocomplete="off" />
                            <span>Role *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="description" name="description" placeholder="" autocomplete="off" />
                            <span>Description</span>
                        </label>

                        <button class="btn btn-primary" type="reset" id="btn-add">Tambah</button>
                        <button class="btn btn-secondary" type="submit" id="btn-submit">OK</button>
                        <button class="btn btn-danger" type="button" id="btn-delete">Hapus</button>
                    </form>
                </div>

                <div class="col-md-7">
                    <div class="col-md-12" id="grid-ui">
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>
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
    role_id = grid.jqGrid ('getGridParam', 'selrow');
    role_name = grid.jqGrid ('getCell', role_id, 'role_name');

    if(role_id == null) {
        swal('','Silakan pilih salah satu baris','info');
        return false;
    }

    loadContentWithParams("admin.role_menus", {
        role_id: role_id,
        role_name : role_name
    });
});
</script>

<script>
    jQuery(function($) {       

        $("#btn-delete").attr("disabled", "disabled");

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."admin.roles_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'role_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Role', name: 'role_name', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Description', name: 'description', width: 200, align: "left", editable: false, search:false, sortable:false},
                
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 5,
            rowList: [5,10,20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/
                setData(rowid);
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
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."admin.roles_controller/crud"; ?>',
            caption: "Roles"

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

    $(window).bind('resize', function() {
        responsive_jqgrid('#grid-table', '#grid-pager');    
    }).trigger('resize');

</script>

<script type="text/javascript">

    function setData(rowid){
        
        var role_name = $('#grid-table').jqGrid('getCell', rowid, 'role_name');
        var description = $('#grid-table').jqGrid('getCell', rowid, 'description');
        
        $('#role_id').val(rowid);
        $('#role_name').val(role_name);
        $('#description').val(description);

        $("#btn-delete").removeAttr('disabled');
        $("#btn-add").removeAttr('disabled');

        setTimeout(function() {
            $('#role_name').focus();
        }, 2000);

    }

    /*add*/
    $("#btn-add").on('click',function(){
        $("#grid-table").jqGrid('resetSelection');
        $("#btn-delete").attr("disabled", "disabled");
        $('#role_name').focus();
    });

    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault();   
        $("#btn-submit").attr("disabled", "disabled");

        var data = new FormData(this);
        var role_id = $('#role_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.roles_controller/create"; ?>';
        if(role_id) var_url = '<?php echo WS_JQGRID."admin.roles_controller/update"; ?>';
        
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
                }else{
                    swal("", data.message, "warning");
                }
               
            }
        });
        
        $("#btn-submit").removeAttr('disabled');
        return false;
    }));

    /*delete*/
    $("#btn-delete").on('click',function(){
        swal(
            {
              title: "",
              text: "Apakah anda ingin menghapus data ini?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){
                var role_id = $('#role_id').val();

                var del = { id_ : role_id };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."admin.roles_controller/crud"; ?>" ,
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
            }
        );


    });
</script>
<script type="text/javascript">
    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."admin.roles_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."admin.roles_controller/read"; ?>',
            postData: {
                i_search : ''
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
    }
</script>