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
                    <a class="nav-link" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>User</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link active" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Change Password</strong></a>
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
                            <input class="form-control" id="user_id" name="user_id" value="<?php echo $this->input->post('user_id');?>" placeholder="" autocomplete="off" readonly="" />
                            <span>ID *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="user_name" name="user_name" value="<?php echo $this->input->post('user_name');?>" placeholder="" autocomplete="off" readonly="" />
                            <span>Username *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input class="form-control" id="user_full_name" name="user_full_name" value="<?php echo $this->input->post('user_full_name');?>" placeholder="" autocomplete="off" readonly="" />
                            <span>Fullname *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="" autocomplete="off" />
                            <span>Password *</span>
                        </label>

                        <label class="form-group has-float-label">
                            <input type="password" class="form-control" id="re_user_password" name="re_user_password" placeholder="" autocomplete="off" />
                            <span>Re-password *</span>
                        </label>

                        <button class="btn btn-secondary" type="submit" id="btn-submit">Submit</button>

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
setTimeout(function() {
    $('#user_password').focus();
}, 2000);

$("#tab-1").on("click", function(event) {
    event.stopPropagation();
    loadContentWithParams("admin.users", {});
});
</script>

<script type="text/javascript">

    /* submit */
    $("#form_data").on('submit', (function (e) {

        e.preventDefault();   
        $("#btn-submit").attr("disabled", "disabled");

        var data = new FormData(this);
            
        var var_url = '<?php echo WS_JQGRID."admin.users_controller/updatePassword"; ?>';
        
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
        $('#form_data').trigger("reset");
        return false;
    }));

</script>
