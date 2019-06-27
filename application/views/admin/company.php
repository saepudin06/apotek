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
                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="javascript:;" role="tab"
                        aria-selected="true"><strong>Company</strong></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>BUnit</strong></a>
                </li>
            </ul>
            
            <div class="separator mb-2"></div>
            <div class="card-body">            
                
                <div class="row">
                    <div class="col-md-12" id="form-ui">    
                        <h5 class="mb-4">Form Company</h5>

                        <form method="post" id="form_data" enctype="multipart/form-data" accept-charset="utf-8">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-row">
                                <!-- <input class="form-control" name="file" type="file" /> -->
                                <label class="form-group has-float-label col-md-12">
                                    <input class="form-control" type="file" id="logo" name="logo" placeholder="" autocomplete="off" />
                                    <span>Logo *</span>
                                </label>
                            </div>

                            <div class="form-row">
                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="company_id" name="company_id" placeholder="" autocomplete="off" readonly="" />
                                    <span>ID *</span>
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
                                <label class="form-group has-float-label col-md-8">
                                    <input class="form-control" id="address" name="address" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Address *</span>
                                </label>

                                <label class="form-group has-float-label col-md-4">
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
                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control" id="tax_num" name="tax_num" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Tax Num *</span>
                                </label>

                                <label class="form-group has-float-label col-md-6">
                                    <input class="form-control datepicker" id="since_date" name="since_date" placeholder="" autocomplete="off" autofocus="" />
                                    <span>Since Date *</span>
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


<script type="text/javascript">
    $("#tab-2").on("click", function(event) {

        event.stopPropagation();
        company_id = $('#company_id').val(); 
        company_name = $('#name').val(); 

        if(company_id == null || company_id == '') {
            swal('','Company not saved','info');
            return false;
        }

        loadContentWithParams("admin.bunit", {
            company_id: company_id,
            company_name : company_name
        });
    });
</script>

<script type="text/javascript">

    setData();

    function setData(){
        
        $.ajax({
                url: '<?php echo WS_JQGRID."admin.company_controller/getcompany"; ?>',
                type: "POST",
                dataType: 'json',
                data: {},
                success: function (data) {
                    if (data.success){
                        var company_id = data.rows.company_id;
                        var registration_num = data.rows.registration_num;
                        var subtitle = data.rows.subtitle;
                        var name = data.rows.name;
                        var address = data.rows.address;
                        var city = data.rows.city;
                        var no_telp = data.rows.no_telp;
                        var no_hp = data.rows.no_hp;
                        var email = data.rows.email;
                        var website = data.rows.website;
                        var tax_num = data.rows.tax_num;
                        var since_date = data.rows.since_date;
                        
                        $('#company_id').val(company_id);
                        $('#registration_num').val(registration_num);
                        $('#subtitle').val(subtitle);
                        $('#name').val(name);        
                        $('#address').val(address);        
                        $('#city').val(city);        
                        $('#no_telp').val(no_telp);        
                        $('#no_hp').val(no_hp);        
                        $('#email').val(email);        
                        $('#website').val(website);        
                        $('#tax_num').val(tax_num);        
                        $('#since_date').val(since_date);   
                    }else{
                        $('#company_id').val('');
                        $('#registration_num').val('');
                        $('#subtitle').val('');
                        $('#name').val('');
                        $('#address').val('');
                        $('#city').val('');
                        $('#no_telp').val('');
                        $('#no_hp').val('');
                        $('#email').val('');
                        $('#website').val('');
                        $('#tax_num').val('');
                        $('#since_date').val('');
                    }
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });

    }

    $('#btn-delete').on('click',function(){

        company_id = $('#company_id').val();  

        if(company_id == null || company_id == '') {
            swal('','Company not saved','info');
            return false;
        }
        
        delete_data(company_id);
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
                    url: "<?php echo WS_JQGRID."admin.company_controller/crud"; ?>" ,
                    type: "POST",
                    dataType: "json",
                    data: {items:itemJSON, oper:'del'},
                    success: function (data) {
                        if (data.success){

                            swal("", data.message, "success");
                            $('#form_data').trigger("reset");     
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
        var company_id = $('#company_id').val();
            
        var var_url = '<?php echo WS_JQGRID."admin.company_controller/create"; ?>';
        if(company_id) var_url = '<?php echo WS_JQGRID."admin.company_controller/update"; ?>';
        
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
                    setData();
                }else{
                    swal("", data.message, "warning");
                }
               
            }
        });
        
        
        return false;
    }));

</script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight:'TRUE',
        autoclose: true,
        orientation: 'bottom'
    });

</script>