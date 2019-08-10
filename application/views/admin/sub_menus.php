<div class="row">
    <div class="col-12 list">
        <div class="float-sm-right text-zero">
            <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                <input onchange="searchData()" id="search-data" placeholder="Search...">
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
                <li class="breadcrumb-item active" aria-current="page">Menu</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Menu</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Sub Menu</strong></a>
                </li>
            </ul>
            <div class="separator mb-2"></div>
            <div class="card-body">            
                <!-- <h5 class="mb-4">Form Menu</h5> -->
                <div class="row">
                <div class="col-md-5">

                    <form method="post" id="form_data">

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <input type="hidden" class="form-control" id="menu_id" name="menu_id" placeholder="" value="<?php echo $this->input->post("menu_id","");?>" />                            

                        <label class="form-group has-float-label">
                            <input class="form-control" id="sub_menu_id" name="sub_menu_id" placeholder="" autocomplete="off" readonly="" />
                            <span>ID *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="sub_data_link" name="sub_data_link" value="<?php echo $this->input->post("menu_url","");?>" placeholder="" autocomplete="off" readonly="" />
                            <span>Data Link *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="sub_menu_title" name="sub_menu_title" placeholder="" autocomplete="off" />
                            <span>Sub Menu *</span>
                        </label>

                        <div class="row">
                            <div class="col-md-9">
                                <label class="form-group has-float-label">
                                    <input class="form-control" id="sub_menu_icon" name="sub_menu_icon" placeholder="" autocomplete="off" />
                                    <span>Icon *</span>                                                  
                                </label>     
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary default" type="button" onclick="search_icon('sub_menu_icon')">Search</button>
                            </div>
                        </div>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="sub_data_source" name="sub_data_source" placeholder="" autocomplete="off" />
                            <span>Data Source *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" type="number" id="sub_menu_order" name="sub_menu_order" min="1" value="1" autocomplete="off" placeholder="" />
                            <span>Listing No *</span>
                        </label>

                        

                        <button class="btn btn-primary" type="reset" id="btn-add">Add</button>
                        <button class="btn btn-secondary" type="submit" id="btn-submit">Submit</button>
                        <button class="btn btn-danger" type="button" id="btn-delete">Delete</button>
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

<?php $this->load->view('lov/lov_icon'); ?>

<script type="text/javascript">

function search_icon(fieldicon){
    modal_lov_icon_show(fieldicon);
}

$("#tab-1").on("click", function(event) {

    event.stopPropagation();
    loadContentWithParams("admin.menus", {});
});
</script>

<script>
    jQuery(function($) {
        $("#btn-delete").attr("disabled", "disabled");

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."admin.sub_menus_controller/crud"; ?>',
            postData: { menu_id : '<?php echo $this->input->post('menu_id'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'sub_menu_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Menu ID', name: 'menu_id', width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Sub Menu', name: 'sub_menu_title', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Icon', name: 'sub_menu_icon', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'Data Link', name: 'sub_data_link', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Data Source', name: 'sub_data_source', width: 120, align: "left", editable: false, search:false, sortable:false},
                {label: 'Listing No', name: 'sub_menu_order', width: 120, align: "left", editable: false, search:false, sortable:false},
                
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
            editurl: '<?php echo WS_JQGRID."admin.sub_menus_controller/crud"; ?>',
            caption: "Sub Menu"

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
                searchicon: 'fa fa-search orange bigger-120',
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
        
        var menu_id = $('#grid-table').jqGrid('getCell', rowid, 'menu_id');
        var sub_menu_title = $('#grid-table').jqGrid('getCell', rowid, 'sub_menu_title');
        var sub_menu_icon  = $('#grid-table').jqGrid('getCell', rowid, 'sub_menu_icon');
        var sub_data_link  = $('#grid-table').jqGrid('getCell', rowid, 'sub_data_link');
        var sub_data_source  = $('#grid-table').jqGrid('getCell', rowid, 'sub_data_source');
        var sub_menu_order  = $('#grid-table').jqGrid('getCell', rowid, 'sub_menu_order');
        
        $('#sub_menu_id').val(rowid);
        $('#menu_id').val(menu_id);
        $('#sub_menu_title').val(sub_menu_title);
        $('#sub_menu_icon').val(sub_menu_icon);
        $('#sub_data_link').val(sub_data_link);
        $('#sub_data_source').val(sub_data_source);
        $('#sub_menu_order').val(sub_menu_order);

        $("#btn-delete").removeAttr('disabled');
        $("#btn-add").removeAttr('disabled');
        
        setTimeout(function() {
            $('#sub_menu_title').focus();
        }, 2000);

    }

    /*add*/
    $("#btn-add").on('click',function(){
        $("#grid-table").jqGrid('resetSelection');
        $("#btn-delete").attr("disabled", "disabled");
        $('#sub_menu_title').focus();
    });

    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault();   
        $("#btn-submit").attr("disabled", "disabled");

        var data = new FormData(this);
        var sub_menu_id = $('#sub_menu_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.sub_menus_controller/create"; ?>';
        if(sub_menu_id) var_url = '<?php echo WS_JQGRID."admin.sub_menus_controller/update"; ?>';
        
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
                var sub_menu_id = $('#sub_menu_id').val();

                var del = { id_ : sub_menu_id };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."admin.sub_menus_controller/crud"; ?>" ,
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
            }
        );


    });
</script>
<script type="text/javascript">
    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."admin.sub_menus_controller/read"; ?>',
            postData: {
                i_search : $('#search-data').val(),
                menu_id : '<?php echo $this->input->post('menu_id'); ?>'
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
        responsive_jqgrid('#grid-table', '#grid-pager');
    }

    function resetSearch(){
        $('#form_data').trigger("reset");
        
        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."admin.sub_menus_controller/read"; ?>',
            postData: {
                i_search : '',
                menu_id : '<?php echo $this->input->post('menu_id'); ?>'
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
    }
</script>