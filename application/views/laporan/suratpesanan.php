<div class="row">
    <div class="col-12 list">
        <div class="float-sm-right text-zero">
            <!-- <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top"> -->
                <!-- <input onchange="searchData()" id="search-data" placeholder="Pencarian..."> -->
            <!-- </div> -->
        </div>

        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="<?php base_url(); ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Laporan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Surat Pesanan</li>
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
                        aria-selected="true"><strong>Surat Pesanan</strong></a>
                </li>
                <!-- <li class="nav-item w-50 text-center">
                    <a class="nav-link" id="tab-2" data-toggle="tab" href="javascript:;" role="tab" aria-selected="false"><strong>Detail</strong></a>
                </li> -->
            </ul>
            
            <div class="separator mb-2"></div>
            <div class="card-body">      

                <div class="form-row">
                    <label class="form-group has-float-label col-md-3">
                        <input class="form-control" id="po_num" name="po_num" placeholder="" autocomplete="off" autofocus="" readonly="" />
                        <span>Kode Pembelian *</span>
                    </label>

                    <input type="hidden" id="purchase_order_id" name="purchase_order_id" placeholder="" autocomplete="off" />

                    <div class="col-md-1">
                        <button class="btn btn-primary default" type="button" onclick="search_po('purchase_order_id', 'po_num')">Search</button>
                    </div>

                    <label class="form-group has-float-label col-md-3">
                        <select id="supplier_id" name="supplier_id" class="form-control">
                            <?php
                                $ci = & get_instance();
                                $ci->load->model('store/supplier');
                                $table = $ci->supplier;
                                $items = $table->getAll(0, -1);

                            ?>
                             <option value=""> ---- Pilih Supplier ---- </option>
                            <?php foreach($items as $item):?>
                                <option value="<?php echo $item['supplier_id'];?>"> <?php echo $item['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                        <span>Supplier *</span>
                    </label>

                    <div class="col-md-2">
                        <button class="btn btn-success default" type="button" onclick="generate()">Cetak Surat Pesanan</button>
                    </div>
                    
                </div>         
                
                <div class="row">
                    
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('lov/lov_purchase_order'); ?>

<script type="text/javascript">
    function search_po(id, code){
        modal_lov_purchase_order_show(id, code);
    }

    function generate(){
        var purchase_order_id = $('#purchase_order_id').val();
        var supplier_id = $('#supplier_id').val();
        var supplier_name = $( "#supplier_id option:selected" ).text();


        if(purchase_order_id == null || purchase_order_id == '') {
            swal('','Kode pembelian belum dipilih','info');
            return false;
        }

        if(supplier_id == null || supplier_id == '') {
            swal('','Supplier belum dipilih','info');
            return false;
        }

        $.ajax({
            url: "<?php echo WS_JQGRID."transaction.purchase_order_det_controller/cekSuratPesanan"; ?>" ,
            type: "POST",
            dataType: "json",
            data: {
                    purchase_order_id: purchase_order_id,
                    supplier_id: supplier_id
                  },
            success: function (data) {
                if (data.success){
                    download_pdf(purchase_order_id, supplier_id, supplier_name);
                }else{
                    swal("", "Surat Pesanan tidak ditemukan", "warning");
                }
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });

    }


    function download_pdf(purchase_order_id, supplier_id, supplier_name){

        var url = "<?php echo base_url() . "surat_pesanan_pdf/pdf/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&purchase_order_id="+purchase_order_id;
            url += "&supplier_id="+supplier_id;
            url += "&supplier_name="+supplier_name;

        window.open(url);    

    }
</script>