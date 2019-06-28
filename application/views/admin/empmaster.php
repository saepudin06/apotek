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
                <li class="breadcrumb-item active" aria-current="page">Employee</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <!-- <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Company</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>BUnit</strong></a>
                </li>
            </ul> -->
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">
                    <div class="col-md-12" id="grid-ui">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>

                    <div class="col-md-12" id="form-ui" style="display: none;">    
                        <h5 class="mb-4">Form Employee</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="emp_id" name="emp_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="no_ktp" name="no_ktp" placeholder="" autocomplete="off" autofocus="" />
                                    <span>NIK. *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="name" name="name" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Name *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control datepicker" id="production_date" name="production_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Production Date *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control datepicker" id="birthdate" name="birthdate" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Birth Date *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="placeofbirth" name="placeofbirth" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Place of Birth *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="no_telp" name="no_telp" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Telphone *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="no_hp" name="no_hp" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Handphone *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="tax_no" name="tax_no" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Tax No. *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
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

                                <label class="form-group has-float-label col-md-3">
                                    <select class="form-control" id="status">
                                        <option value="1">Active</option>
                                        <option value="2">Not Active</option>
                                    </select>
                                    <span>Status *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="address" name="address" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Address *</span>
                                </label>
                            </div>


                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="name_emrgency" name="name_emrgency" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Name Emrgency *</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="emergency_contact" name="emergency_contact" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Emrgency Contact *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="address_emrgncy" name="address_emrgncy" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Emrgency Address *</span>
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

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."admin.empmaster_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'emp_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'BU ID', name: 'bu_id', width: 100, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Bussiness Unit', name: 'bu_name', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'NIK', name: 'no_ktp', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Name', name: 'name', width: 200, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tax No.', name: 'tax_no', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Telphone', name: 'no_telp', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Handphone', name: 'no_hp', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Production Date', name: 'production_date', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Status', name: 'status', width: 150, align: "left", editable: false, search:false, sortable:false, hidden: true},
                {label: 'Status?', name: 'status_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Address', name: 'address', width: 300, align: "left", editable: false, search:false, sortable:false},
                {label: 'Birth Date', name: 'birthdate', width: 300, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Place of Birth', name: 'placeofbirth', width: 300, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Emrgency Contact', name: 'emergency_contact', width: 300, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Address Emrgency', name: 'address_emrgncy', width: 300, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Name Emrgency', name: 'name_emrgency', width: 300, align: "left", editable: false, search:false, sortable:false, hidden:true},
                
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
            editurl: '<?php echo WS_JQGRID."admin.empmaster_controller/crud"; ?>',
            caption: "Employee"

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
                     $('#bu_id').val(null).trigger('change');
                     $('#status').val('1').trigger('change');
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
        
        var bu_id = $('#grid-table').jqGrid('getCell', rowid, 'bu_id');
        var name = $('#grid-table').jqGrid('getCell', rowid, 'name');
        var address  = $('#grid-table').jqGrid('getCell', rowid, 'address');
        var no_telp  = $('#grid-table').jqGrid('getCell', rowid, 'no_telp');
        var no_hp  = $('#grid-table').jqGrid('getCell', rowid, 'no_hp');
        var tax_no  = $('#grid-table').jqGrid('getCell', rowid, 'tax_no');
        var no_ktp  = $('#grid-table').jqGrid('getCell', rowid, 'no_ktp');
        var birthdate  = $('#grid-table').jqGrid('getCell', rowid, 'birthdate');
        var placeofbirth  = $('#grid-table').jqGrid('getCell', rowid, 'placeofbirth');
        var production_date  = $('#grid-table').jqGrid('getCell', rowid, 'production_date');
        var status  = $('#grid-table').jqGrid('getCell', rowid, 'status');
        var emergency_contact  = $('#grid-table').jqGrid('getCell', rowid, 'emergency_contact');
        var name_emrgency  = $('#grid-table').jqGrid('getCell', rowid, 'name_emrgency');
        var address_emrgncy  = $('#grid-table').jqGrid('getCell', rowid, 'address_emrgncy');
        
        $('#emp_id').val(rowid);        
        $('#bu_id').val(bu_id);    
        $('#bu_id').trigger('change');

        $('#name').val(name);        
        $('#address').val(address);        
        $('#no_telp').val(no_telp);        
        $('#no_hp').val(no_hp);        
        $('#tax_no').val(tax_no);        
        $('#no_ktp').val(no_ktp);        
        $('#birthdate').val(birthdate);        
        $('#placeofbirth').val(placeofbirth);        
        $('#production_date').val(production_date);        
        $('#status').val(status);   
        $('#status').trigger('change');

        $('#emergency_contact').val(emergency_contact);        
        $('#name_emrgency').val(name_emrgency);        
        $('#address_emrgncy').val(address_emrgncy);        

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
                    url: "<?php echo WS_JQGRID."admin.empmaster_controller/crud"; ?>" ,
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
        data.append("bu_id", $("#bu_id").val());
        data.append("status", $("#status").val());

        var emp_id = $('#emp_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.empmaster_controller/create"; ?>';
        if(emp_id) var_url = '<?php echo WS_JQGRID."admin.empmaster_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."admin.empmaster_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."admin.empmaster_controller/read"; ?>',
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

    $('.select2-single').select2();
</script>