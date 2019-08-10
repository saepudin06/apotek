<div class="row">
    <div class="col-12">
        <div class="mb-2">
            <div class="float-sm-right text-zero">
                <button type="submit" class="btn btn-primary" id="btn-submit">SUBMIT</button>

                <div class="btn-group ">
                    <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                        <label class="custom-control custom-checkbox mb-0 d-inline-block">
                            <input type="checkbox" class="custom-control-input" id="checkAll" value="checkall">
                            <span class="custom-control-label"></span>
                        </label>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split pl-2 pr-2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <!-- <div class="dropdown-menu dropdown-menu-right"> -->
                        <!-- <a class="dropdown-item" href="#">Action</a> -->
                        <!-- <a class="dropdown-item" href="#">Another action</a> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Transaction</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Order Detail</li>
            </ol>
        </nav>
        <!-- <div class="separator mb-5"></div> -->
    </div>

    <div class="mb-2">
        <div class="collapse d-md-block" id="displayOptions" style="padding-left: 30px;">
            <div class="d-block d-md-inline-block">
                <div class="btn-group float-md-left mr-1 mb-1">
                    <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Order By
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-item asc" onclick="orderby('asc')">Ascending</div>
                        <div class="dropdown-item desc" onclick="orderby('desc')">Descending</div>
                    </div>
                </div>
                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                    <input id="search-data" value="<?php echo $this->input->post("search","");?>" onchange="searchData()" placeholder="Search...">
                </div>  
                <div class="float-md-left mr-1 mb-1">
                    <button type="button" onclick="backtopage()" class="btn btn-outline-secondary btn-xs mb-1">Kembali</button>
                </div>              
            </div>
        </div>
    </div>
    <div class="separator mb-5"></div>
    
</div>

<div class="row">
    <div class="col-12 list" data-check-all="checkAll">        

        <form method="post" id="form_data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <input type="hidden" class="form-control" id="purchase_order_id" name="purchase_order_id" placeholder="" value="<?php echo $this->input->post("purchase_order_id","");?>" /> 
            
            <?php
                $ci = & get_instance();
                $ci->load->model('transaction/purchase_order_det');

                $idd = $ci->input->post("purchase_order_id","");
                $orderby = $ci->input->post("orderby","");
                $search = $ci->input->post("search","");
                $table = $ci->purchase_order_det;
                $items = $table->getPODet($idd,$orderby,$search);

            ?>
            <?php foreach($items as $item):?>

            <input type="hidden" class="form-control" name="purchase_req_det_id[]" placeholder="" value="<?php echo $item['purchase_req_det_id'];?>" />

            <input type="hidden" class="form-control" name="purchase_order_det_id[]" placeholder="" value="<?php echo $item['purchase_order_det_id'];?>" />

            <div class="card d-flex flex-row mb-3">
                <div class="d-flex flex-grow-1 min-width-zero">
                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                        <a class="list-item-heading mb-1 truncate w-20 w-xs-100" href="javascript:;">
                            <?php echo $item['product_name'];?>
                        </a>
                        <p class="mb-1 text-muted text-small w-10 w-xs-100">Qty : <?php echo $item['qty'];?></p>
                        <p class="mb-1 text-muted text-small w-15 w-xs-100">Basic Price : <?php echo $item['basic_price'];?></p>
                        <div class="w-10 w-xs-100">
                            <div class="form-group">
                                <input type="text" name="qty[]" onkeypress="return isNumberKey(event)" value="<?php echo $item['po_qty'];?>" class="form-control" style="font-size: 11px !important" placeholder="Qty">
                            </div>
                        </div>
                        <div class="w-20 w-xs-100">
                            <div class="form-group">
                                <input type="text" name="basic_price[]" onkeypress="return isNumberKey(event)" value="<?php echo $item['po_basic_price'];?>" class="form-control" style="font-size: 11px !important" placeholder="Basic Price">
                            </div>
                        </div>
                        <div class="w-10 w-xs-100">
                            <?php 
                                // if($item['status_id'] == 1){
                                //     $fill = "badge-secondary";                                              
                                // }else if($item['status_id'] == 2){
                                //     $fill = "badge-primary";
                                // }else{
                                    // $fill = "badge-success";
                                // }

                            ?>
                            <!-- <span class="badge badge-pill <?php echo $fill;?>"><?php echo $item['status_code'];?></span> -->
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                        <label class="custom-control custom-checkbox mb-0">                            
                            <input type="checkbox" name="check[<?php echo $item['purchase_req_det_id'];?>]" class="custom-control-input chk" id="<?php echo 'checkbox'.$item['purchase_req_det_id'];?>" value="1">
                            <span class="custom-control-label"></span>
                        </label>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </form>

    </div>
</div>

<script type="text/javascript"> 

    $('#checkAll').on('change', function(){
        
        if($('#checkAll').prop('checked')) {
            $('.chk').attr('checked', true);
        }else{
            $('.chk').removeAttr('checked');
        }

    });

    loadDataCheckBox();

    function loadDataCheckBox(){

        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/read"; ?>',
            data: {
                purchase_order_id : '<?php echo $this->input->post('purchase_order_id');?>',
                _search : '',
                rows    : 100
            },
            success: function(data) {
                
                for (var i = 0; i < data.rows.length; i++){
                    var idcheck = 'checkbox'+data.rows[i].purchase_req_det_id;

                    //chceked checkbox
                    $('#'+idcheck).attr('checked', true);
                    
                }                
               
            }
        });
    }

    function orderby(order){
        if(order == 'asc'){
            $(".asc").addClass("active");
            $(".desc").removeClass("active");
        }else{
            $(".desc").addClass("active");
            $(".asc").removeClass("active");
        }

        loadContentWithParams("transaction.purchase_order_det", {
            purchase_order_id: "<?php echo $this->input->post("purchase_order_id","");?>",
            orderby: order,
            search: $('#search-data').val()
        });
    }

    function searchData(){
        loadContentWithParams("transaction.purchase_order_det", {
            purchase_order_id: "<?php echo $this->input->post("purchase_order_id","");?>",
            orderby: "<?php echo $this->input->post("orderby","");?>",
            search: $('#search-data').val()
        });
    }

    $("#btn-submit").on('click', function(){

        var var_url = '<?php echo WS_JQGRID."transaction.purchase_order_det_controller/insertdata"; ?>';

        // var data = $('#form_data').serialize();
        var data = $('#form_data').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: var_url,
            data: data, 
            success: function(data) {

                if(data.success) {                                        
                    swal("", data.message, "success");
                    searchData();
                }else{
                    swal("", data.message, "warning");
                }

                // loadDataCheckBox();
               
            }
        });

        return false;   
            
        
    });

    function backtopage(){
        loadContentWithParams("transaction.purchase_order", {});
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>