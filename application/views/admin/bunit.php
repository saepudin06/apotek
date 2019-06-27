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
                    <a href="javascript:;">System</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Company</li>
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
                        aria-selected="true"><strong>Company</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>BUnit</strong></a>
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
                        <h5 class="mb-4">Form Bussiness Unit (<?php echo $this->input->post('company_name', ''); ?>)</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="bu_id" name="bu_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="company_id" name="company_id" value="<?php echo $this->input->post('company_id'); ?>" placeholder="" autocomplete="off" readonly="" />
                                    <span>Company ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="registration_num" name="registration_num" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Registration No. *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="name" name="name" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Name *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="subtitle" name="subtitle" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Subtitle *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="tax_num" name="tax_num" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Tax Num *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="city" name="city" placeholder="" autocomplete="off" autofocus="" />
                                    <span>City *</span>
                                </label>
                            </div>


                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="no_telp" name="no_telp" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Telphone *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="no_hp" name="no_hp" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Handphone *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="email" name="email" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Email *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="website" name="website" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Website *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-12">
                                    <input class="form-control" id="address" name="address" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Address *</span>
                                </label>
                            </div>

                            <button class="btn btn-secondary" type="submit" id="btn-submit">Submit</button>
                            <button class="btn btn-danger" type="button" id="btn-delete">Delete</button>

                        </form>
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
            url: '<?php echo WS_JQGRID."admin.bunit_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'bu_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Company ID', name: 'company_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Registration Num', name: 'registration_num', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Name', name: 'name', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'Email', name: 'email', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Website', name: 'website', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Telphone', name: 'no_telp', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Handphone', name: 'no_hp', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Subtitle', name: 'subtitle', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tax Num', name: 'tax_num', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'City', name: 'city', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Address', name: 'address', width: 300, align: "left", editable: false, search:false, sortable:false},
                
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
                      $("#grid-table").focus();
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."admin.bunit_controller/crud"; ?>',
            caption: "Bussiness Unit (<?php echo $this->input->post('company_name', ''); ?>)"

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
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();

        loadContentWithParams("admin.company", {});
    });
</script>

<script type="text/javascript">

    function setData(rowid){
        
        var company_id = $('#grid-table').jqGrid('getCell', rowid, 'company_id');
        var name = $('#grid-table').jqGrid('getCell', rowid, 'name');
        var address  = $('#grid-table').jqGrid('getCell', rowid, 'address');
        var no_telp  = $('#grid-table').jqGrid('getCell', rowid, 'no_telp');
        var no_hp  = $('#grid-table').jqGrid('getCell', rowid, 'no_hp');
        var email  = $('#grid-table').jqGrid('getCell', rowid, 'email');
        var website  = $('#grid-table').jqGrid('getCell', rowid, 'website');
        var registration_num  = $('#grid-table').jqGrid('getCell', rowid, 'registration_num');
        var subtitle  = $('#grid-table').jqGrid('getCell', rowid, 'subtitle');
        var tax_num  = $('#grid-table').jqGrid('getCell', rowid, 'tax_num');
        var city  = $('#grid-table').jqGrid('getCell', rowid, 'city');
        
        $('#bu_id').val(rowid);        
        $('#company_id').val(company_id);        
        $('#name').val(name);        
        $('#address').val(address);        
        $('#no_telp').val(no_telp);        
        $('#no_hp').val(no_hp);        
        $('#email').val(email);        
        $('#website').val(website);        
        $('#registration_num').val(registration_num);        
        $('#subtitle').val(subtitle);        
        $('#tax_num').val(tax_num);        
        $('#city').val(city);        

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
                    url: "<?php echo WS_JQGRID."admin.bunit_controller/crud"; ?>" ,
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
        var bu_id = $('#bu_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.bunit_controller/create"; ?>';
        if(bu_id) var_url = '<?php echo WS_JQGRID."admin.bunit_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."admin.bunit_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."admin.bunit_controller/read"; ?>',
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

</script>