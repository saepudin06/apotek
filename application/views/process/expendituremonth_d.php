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
                    <a href="javascript:;">Process</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Expenditure Monthly</li>
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
                        aria-selected="true"><strong>Expenditure Monthly</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Details</strong></a>
                </li>
            </ul>
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">
                    <div class="col-md-4">
                        <!-- <h3>Total: <span clas="btn-success">3123131</span> </h3> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="grid-ui">         
                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
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
            url: '<?php echo WS_JQGRID."process.expendituremonth_d_controller/read_dt"; ?>',
            postData: { i_period : '<?php echo $this->input->post('i_period'); ?>'},
            datatype: "json",
            mtype: "POST",
            loadui: "disable",
            colModel: [
                {label: 'ID', name: 'keyid', key: true, width: 5, sorttype: 'text', editable: true, hidden: true},
                {label: 'Group Acc', name: 'group_acc', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Amount', name: 'amount', width: 100, align: "right", editable: false, search:false, sortable:false, hidden: false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},
                {label: 'BU Name', name: 'bu_name', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Period Expenditure', name: 'period_expenditure', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Period Trans', name: 'period_trans', width: 100, align: "left", editable: false, search:false, sortable:false},
                {label: 'Posting Date', name: 'posting_date', width: 100, align: "left", editable: false, search:false, sortable:false}
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
            shrinkToFit: true,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/
                // setData(rowid);
            },
            sortorder:'',
            // set the subGrid property to true to show expand buttons for each row
             subGrid: true, // set the subGrid property to true to show expand buttons for each row
             subGridRowExpanded: showChildGrid, // javascript function that will take care of showing the child grid
             subGridOptions : {
                 // load the subgrid data only once
                 // and the just show/hide
                 reloadOnExpand :false,
                 // select the row when the expand column is clicked
                 selectOnExpand : true,
                 plusicon : "ui-icon iconsmind-Maximize",
                 minusicon  : "ui-icon iconsmind-Minimize"
                // openicon : "ace-icon fa fa-chevron-right center orange"
            },  // batas sub group
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            footerrow: true,
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }

                var sum = $("#grid-table").jqGrid('getCol', 'amount', false, 'sum');
                $("#grid-table").jqGrid('footerData','set', {group_acc: 'Total :', amount: sum});

                setTimeout(function(){
                      $("#grid-table").setSelection($("#grid-table").getDataIDs()[0],true);
                      // $("#grid-table").focus();
                },500);

            },
            //memanggil controller jqgrid yang ada di controller read
            editurl: '<?php echo WS_JQGRID."process.expendituremonth_d_controller/read_dt"; ?>',
            caption: "Detail"

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

     function showChildGrid(parentRowID, parentRowKey) {
        var childGridID = parentRowID + "_table";
        var childGridPagerID = parentRowID + "_pager";

        console.log("Masuk Group :" + parentRowID  );

        // send the parent row primary key to the server so that we know which grid to show
        var childGridURL = "<?php echo WS_JQGRID.'process.expendituremonth_d_controller/read'; ?>";

        // add a table and pager HTML elements to the parent grid row - we will render the child grid here
        $('#' + parentRowID).append('<table id=' + childGridID + '></table><div id=' + childGridPagerID + ' class=scroll></div>');

        $("#" + childGridID).jqGrid({
            url: childGridURL,
            mtype: "POST",
            datatype: "json",
            page: 1,
            rownumbers: true, // show row numbers
            rownumWidth: 35,
            shrinkToFit: true,
            loadui: "disable",
//            scrollbar : false,
            postData:{celValue:encodeURIComponent(parentRowKey)},
            colModel: [
                { label: 'ID', name: 'keyid', key: true, width:100, editable: false,hidden:true },
                { label: 'Acc.Num', name: 'account_num', width:200, align:"left", editable:false},
                { label: 'Acc.Desc', name: 'acc_desc', width:300, align:"left", editable:false},
                { label: 'Amount', name: 'amount', width:100, align:"right", editable:false, formatter: 'currency', formatoptions : {decimalSeparator: ",", decimalPlaces:0, thousandsSeparator:"."}},
                { label: 'Create By', name: 'created_by', width:100, align:"left", editable:false},
                { label: 'Create Date', name: 'created_date', width:100, align:"left", editable:false},
                { label: 'Update Date', name: 'update_date', width:100, align:"left", editable:false},
                { label: 'Update By', name: 'update_by', width:100, align:"left", editable:false}
            ],
//            loadonce: true,
            width: "100%",
            height: '100%',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            }
//            pager: "#" + childGridPagerID
        });

    }

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
    $("#tab-1").on("click", function(event) {

        event.stopPropagation();
        var grid = $('#grid-table');

        loadContentWithParams("process.expendituremonth", {});
    });
</script>

<script type="text/javascript">
    function searchData(){

        jQuery("#grid-table").jqGrid('setGridParam',{
            url: '<?php echo WS_JQGRID."process.expendituremonth_d_controller/read"; ?>',
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
            url: '<?php echo WS_JQGRID."product.stockproductdetails_controller/read"; ?>',
            postData: {
                i_search : ''
            }
        });
        
        $("#grid-table").trigger("reloadGrid");
    }


</script>