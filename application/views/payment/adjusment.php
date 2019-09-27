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
                    <a href="javascript:;">Adjustment</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Adjustment</li>
            </ol>
        </nav>
        
    </div>
    
</div>

<div class="row">    
    <div class="col-12">        
        <div class="card mb-4">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 mb-1 col-md-4" role="tablist">
                <li class="nav-item w-30 text-center">
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Adjustment</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Dokumen Pendukung</strong></a>
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
                        <h5 class="mb-4">Form Adjustment</h5>

                        <form method="post" id="form_data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-4">
                                    <input class="form-control" id="adj_id" name="adj_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
                                     <select class="form-control" id="d_c" name="d_c" onchange="dcChange()">
                                        <option value=""> -- Pilih Debit/Kredit -- </option>
                                            <option value="1"> Debit </option>
                                            <option value="-1"> Kredit </option>
                                    </select>
                                    <span>Debit/Kredit</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="acc_name" name="acc_name" placeholder="" autocomplete="off" autofocus="" readonly="" />
                                    <span>No. Akun</span>
                                </label>

                                <div class="col-md-1">
                                    <button class="btn btn-primary default" type="button" onclick="search_acc('acc_num', 'acc_name')">Cari <i class="simple-icon-question"></i></button>
                                </div>

                                <input class="form-control" type="hidden" id="acc_num" name="acc_num" placeholder="" autocomplete="off" readonly="" />

                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control datepicker" id="adj_date" name="adj_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Tanggal</span>
                                </label>

                                <label class="form-group has-float-label col-md-3">
                                    <input class="form-control" id="amount" name="amount" onkeypress="return isNumberKey(event)" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Total *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="description" name="description" placeholder="" autocomplete="off" autofocus=""  />
                                    <span>Keterangan</span>
                                </label>
                            </div>

                            <button class="btn btn-secondary" type="submit" id="btn-submit">OK</button>
                            <button class="btn btn-danger" type="button" id="btn-cancel">Batal</button>

                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_map_account'); ?>

<script type="text/javascript">
    function search_acc(id, code){
        var account_type = 0;
        var dc = $('#d_c').val();
        

        // if(dc == '1'){
        //     account_type = 18;
        // }else if(dc == '-1'){
        //     account_type = 19;
        // }else{
            account_type = 0;
        // }
        
        modal_lov_map_account_show(id, code, account_type);
    }

    
</script>

<script>
    jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."payment.adjusment_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'adj_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'Bisnis Unit ID', name: 'bu_id', width: 240, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Debit/Kredit', name: 'd_c', width: 240, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: 'Status', name: 'status', width: 240, align: "left", editable: false, search:false, sortable:false, hidden:true},
                {label: '<center>Action (Status)</center>',width: 150, align: "center",
                    formatter:function(cellvalue, options, rowObject) {
                        var status = rowObject['status'];
                        var adj_id = rowObject['adj_id'];
                        

                        if(status != 'VERIFIED' && status != 'STOCK-SUM' ){
                            return '<button class="btn btn-primary btn-xs default" onclick="updateStatus(\''+adj_id+'\')">Update</button>';
                        }else{
                            return '<strong><p class="text-success">'+status+'</p></strong>';
                        }
                    }
                },
                {label: 'Tanggal', name: 'adj_date', width: 150, align: "left", editable: false, search:false, sortable:false},         
                {label: 'No. Akun', name: 'acc_num', width: 240, align: "left", editable: false, search:false, sortable:false},
                {label: 'Nama Akun', name: 'acc_name', width: 240, align: "left", editable: false, search:false, sortable:false},
                {label: 'Unit Bisnis', name: 'bu_name', width: 150, align: "left", editable: false, search:false, sortable:false},
                {label: 'Total', name: 'amount', width: 150, align: "right", editable: false, search:false, sortable:false, hidden: true},       
                {label: 'Keterangan', name: 'description', width: 250, align: "left", editable: false, search:false, sortable:false},
                {label: 'Pembuat', name: 'created_by', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal Dibuat', name: 'created_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Pengubah', name: 'update_by', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Tanggal Diubah', name: 'update_date', width: 100, align: "left", editable: false, search:false, sortable:false},
                
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
                var status = $('#grid-table').jqGrid('getCell', rowid, 'status');

                if(status == 'VERIFIED' || status == 'STOCK-SUM'){
                    $('#btn-edit').hide();
                    $('#btn-delete').hide();
                }else{
                    $('#btn-edit').show();
                    $('#btn-delete').show();
                }
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
                      // $("#grid-table").focus();
                },500);

            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."payment.adjusment_controller/crud"; ?>',
            caption: "Adjustment"

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
                     // alert("Adding Row");
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
                        swal('','Silakan pilih salah satu baris','info');
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
                        swal('','Silakan pilih salah satu baris','info');
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
        $(grid_selector).jqGrid( 'setGridWidth', $("#grid-ui").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

    $(window).bind('resize', function() {
        responsive_jqgrid('#grid-table', '#grid-pager');    
    }).trigger('resize');

</script>


<script type="text/javascript">
    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');
        var adj_id = grid.jqGrid('getGridParam', 'selrow');

        if(adj_id == null) {
            swal('','Silakan pilih salah satu baris','info');
            return false;
        }

        
        loadContentWithParams("payment.adjustment_evd", {
            adj_id: adj_id
        });
    });

</script>

<script type="text/javascript">

    function setData(rowid){
        
        var bu_id = $('#grid-table').jqGrid('getCell', rowid, 'bu_id');
        var acc_name  = $('#grid-table').jqGrid('getCell', rowid, 'acc_name');
        var acc_num  = $('#grid-table').jqGrid('getCell', rowid, 'acc_num');
        var amount  = $('#grid-table').jqGrid('getCell', rowid, 'amount');
        var adj_date  = $('#grid-table').jqGrid('getCell', rowid, 'adj_date');
        var description  = $('#grid-table').jqGrid('getCell', rowid, 'description');
        var d_c  = $('#grid-table').jqGrid('getCell', rowid, 'd_c');
        
        $('#adj_id').val(rowid);
        $('#bu_id').val(bu_id);
        $('#acc_name').val(acc_name);        
        $('#acc_num').val(acc_num);        
        $('#amount').val(amount);        
        $('#adj_date').val(adj_date);        
        $('#description').val(description);        
        $('#d_c').val(d_c);        

    }

    $('#btn-cancel').on('click',function(){
        $('#form-ui').hide();
        $('#grid-ui').slideDown( "slow" );
    });

    /*delete*/
    function delete_data(rowid){
        swal({
              title: "",
              text: "Apakah anda ingin menghapus data ini?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                var del = { id_ : rowid };
                itemJSON = JSON.stringify(del);

                $.ajax({
                    url: "<?php echo WS_JQGRID."payment.adjusment_controller/crud"; ?>" ,
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
        var adj_id = $('#adj_id').val();
            
        var var_url = '<?php echo WS_JQGRID."payment.adjusment_controller/create"; ?>';
        if(adj_id) var_url = '<?php echo WS_JQGRID."payment.adjusment_controller/update"; ?>';
        
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
            url: '<?php echo WS_JQGRID."payment.adjusment_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."payment.adjusment_controller/read"; ?>',
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

    function updateStatus(adj_id){
        swal({
              title: "",
              text: "[Verifikasi Update Stock]\nApakah anda yakin?",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes!",
              closeOnConfirm: true
            },
            function(){

                $.ajax({
                    url: "<?php echo WS_JQGRID."payment.adjusment_controller/updateStatus"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: { adj_id : adj_id},
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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function dcChange(){
        $('#acc_num').val('');
        $('#acc_name').val('');
    }
    
</script>