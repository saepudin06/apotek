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
                <li class="breadcrumb-item active" aria-current="page">User</li>
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
                        aria-selected="true"><strong>User</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Change Password</strong></a>
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
                            <input class="form-control" id="user_id" name="user_id" placeholder="" autocomplete="off" readonly="" />
                            <span>ID *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="user_name" name="user_name" placeholder="" autocomplete="off" />
                            <span>Username *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="user_full_name" name="user_full_name" placeholder="" autocomplete="off" />
                            <span>Fullname *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="" autocomplete="off" />
                            <span>Email *</span>
                        </label>

                        <div class="pass">
                        <label class="form-group has-float-label">
                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="" autocomplete="off" />
                            <span>Password *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input type="password" class="form-control" id="re_user_password" name="re_user_password" placeholder="" autocomplete="off" />
                            <span>Re-password *</span>
                        </label>
                        </div>

                        <label class="form-group has-float-label">
                            <select id="user_status" name="user_status" class="form-control">
                                <option value="1"> Active</option>
                                <option value="0"> Not Active</option>
                            </select>
                            <span>Status *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <select id="role_id" name="role_id" class="form-control">
                                <?php
                                    $ci = & get_instance();
                                    $ci->load->model('admin/roles');
                                    $table = $ci->roles;
                                    $items = $table->getRole();

                                ?>
                                <?php foreach($items as $item):?>
                                    <option value="<?php echo $item['role_id'];?>"> <?php echo $item['role_name'];?></option>
                                <?php endforeach; ?>
                            </select>
                            <span>Role *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <select id="p_employee_id" name="p_employee_id" class="form-control select2-single">
                                <?php
                                    $ci = & get_instance();
                                    $ci->load->model('admin/empmaster');
                                    $table = $ci->empmaster;
                                    $items = $table->getEmp();

                                ?>
                                <option value=""> -- Pilih -- </option>
                                <?php foreach($items as $item):?>
                                    <option value="<?php echo $item['emp_id'];?>"> <?php echo $item['name'];?></option>
                                <?php endforeach; ?>
                            </select>
                            <span>Pegawai </span>
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
    user_id = grid.jqGrid ('getGridParam', 'selrow');
    user_name = grid.jqGrid ('getCell', user_id, 'user_name');
    user_full_name = grid.jqGrid ('getCell', user_id, 'user_full_name');

    if(user_id == null) {
        swal('','Silahkan pilih salah satu user','info');
        return false;
    }

    loadContentWithParams("admin.change_pass_user", {
        user_id: user_id,
        user_name : user_name,
        user_full_name : user_full_name
    });
});
</script>

<script>
    jQuery(function($) {       

        $("#btn-delete").attr("disabled", "disabled");

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."admin.users_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'user_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Username', name: 'user_name', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Fullname', name: 'user_full_name', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'E-mail', name: 'user_email', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'Status', name: 'status_active', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'User Status', name: 'user_status', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Role', name: 'role_name', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Pegawai', name: 'emp_name', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Role ID', name: 'role_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Emp ID', name: 'p_employee_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden:true},
                
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 5,
            rowList: [5,10,20],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
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
            editurl: '<?php echo WS_JQGRID."admin.users_controller/crud"; ?>',
            caption: "User"

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

    function setData(rowid){
        
        var user_name = $('#grid-table').jqGrid('getCell', rowid, 'user_name');
        var user_full_name = $('#grid-table').jqGrid('getCell', rowid, 'user_full_name');
        var user_email = $('#grid-table').jqGrid('getCell', rowid, 'user_email');
        var user_status = $('#grid-table').jqGrid('getCell', rowid, 'user_status');
        var role_id = $('#grid-table').jqGrid('getCell', rowid, 'role_id');
        
        $('#user_id').val(rowid);
        $('#user_name').val(user_name);
        $('#user_full_name').val(user_full_name);
        $('#user_email').val(user_email);
        $('#user_status').val(user_status);
        $('#role_id').val(role_id);

        $('.pass').hide();

        $("#btn-delete").removeAttr('disabled');
        $("#btn-add").removeAttr('disabled');

        setTimeout(function() {
            $('#user_name').focus();
        }, 2000);

    }

    /*add*/
    $("#btn-add").on('click',function(){
        $("#grid-table").jqGrid('resetSelection');
        $("#btn-delete").attr("disabled", "disabled");
        $('#user_name').focus();
        $('.pass').show();
    });

    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault();   
        $("#btn-submit").attr("disabled", "disabled");

        var data = new FormData(this);
        var user_id = $('#user_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.users_controller/create"; ?>';
        if(user_id) var_url = '<?php echo WS_JQGRID."admin.users_controller/update"; ?>';
        
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
                var user_id = $('#user_id').val();

                var del = { id_ : user_id };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."admin.users_controller/crud"; ?>" ,
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
            url: '<?php echo WS_JQGRID."admin.users_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."admin.users_controller/read"; ?>',
            postData: {
                i_search : ''
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
    }

    $('.select2-single').select2();
</script>