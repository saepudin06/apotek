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
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Role</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Menu</strong></a>
                </li>
            </ul>
            <div class="separator mb-2"></div>
            <div class="card-body">            
                <!-- <h5 class="mb-4">Form Menu</h5> -->
                <div class="row">
                <div class="col-md-12">

                    <form method="post" id="form_data">

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <input type="hidden" class="form-control" id="role_id" name="role_id" placeholder="" value="<?php echo $this->input->post("role_id","");?>" />                            

                        <?php
                            $ci = & get_instance();
                            $ci->load->model('admin/menus');
                            $table = $ci->menus;
                            $items = $table->getMenu();

                        ?>
                        <?php foreach($items as $item):?>
                            <p class="text-muted text-small"><?php echo $item['menu_title'];?></p>   
                            <div class="form-row">   
                                <ul class="list-unstyled mb-5" style="padding-left: 20px;">
                                <?php
                                    $ci = & get_instance();
                                    $ci->load->model('admin/sub_menus');
                                    $table2 = $ci->sub_menus;
                                    $subitems = $table2->getSubMenu($item['menu_id']);

                                ?>

                                <?php foreach($subitems as $subitem):?> 
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="submenu[]" id="<?php echo 'category'.$subitem['sub_menu_id'];?>" value="<?php echo $subitem['sub_menu_id'];?>">
                                            <label class="custom-control-label" for="<?php echo 'category'.$subitem['sub_menu_id'];?>"><?php echo $subitem['sub_menu_title'];?></label>
                                        </div>
                                    </li>                                     
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                        
                        <button class="btn btn-secondary" type="submit" id="btn-submit">OK</button>
                        <button class="btn btn-primary" type="button" id="btn-refresh">Refresh Semua</button>
                    </form>
                </div>

                <div class="col-md-7">
                    <div class="col-md-12">
                        
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$("#tab-1").on("click", function(event) {

    event.stopPropagation();
    loadContentWithParams("admin.roles", {});
});
</script>

<script type="text/javascript">
    function loadDataCheckBox(){

        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?php echo WS_JQGRID."admin.role_menus_controller/read"; ?>',
            data: {
                role_id : '<?php echo $this->input->post('role_id');?>',
                _search : '',
                rows    : 100
            },
            success: function(data) {
                
                for (var i = 0; i < data.rows.length; i++){
                    var idcheck = 'category'+data.rows[i].sub_menu_id;

                    //chceked checkbox
                    $('#'+idcheck).attr('checked', true);
                    
                }                
               
            }
        });
    }
</script>

<script type="text/javascript">
    /* load data*/
    loadDataCheckBox();

    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault();   
        $("#btn-submit").attr("disabled", "disabled");

        var data = new FormData(this);
        var sub_menu_id = $('#sub_menu_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.role_menus_controller/insertdata"; ?>';
        
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
                    swal("", data.message, "success");
                }else{
                    swal("", data.message, "warning");
                }

                loadDataCheckBox();
               
            }
        });
        
        $("#btn-submit").removeAttr('disabled');
        return false;
    }));


    /*refresh*/

    $('#btn-refresh').on('click', function(){
        location.reload();
    });

</script>
