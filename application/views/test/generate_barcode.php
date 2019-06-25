<div class="row">
    <div class="col-12 list">

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Administration</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Barcode</li>
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
                        aria-selected="true"><strong>Generate Barcode</strong></a>
                </li>
            </ul>
            <div class="separator mb-2"></div>
            <div class="card-body">            

                <div class="row">
                <div class="col-md-8">

                    <div class="col-md-12">
                        <div class="row">
                            
                            <div class="col-md-5">
                                <label class="form-group has-float-label">
                                    <input class="form-control" id="product_code" name="product_code" placeholder="" autocomplete="off" />
                                    <span>Code *</span>
                                </label>
                            </div>

                            <div  class="col-md-2">
                                <button class="btn btn-secondary default mb-1" type="button" onclick="generateCode()">Generate</button>
                            </div>

                        </div>
                    </div>                        

                    <div class="col-md-12">
                        
                    </div>

                </div>

                <div class="col-md-4">
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>    
    $('#product_code').focus();

    function generateCode(){
        // alert('test');
        var code = $('#product_code').val();
        var url = "<?php echo base_url(); ?>"+"barcode/generate_barcode?";
        url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        url += "&text="+code;
        // console.log(url);
        // openInNewTab(url);
        window.location.href = url;
    }

    function openInNewTab(url) {
        window.open(url, 'Testing', 'left=0,top=0,width=800,height=500,toolbar=no,scrollbars=yes,resizable=yes');
    }

</script>

