<?php $this->load->view('cashier/header.php'); ?>    

    <main>
        <div class="container-fluid">       
            
            <div class="row">    
                <div class="col-12">        
                    <div class="card mb-4">
                        
                        <div class="separator mb-2"></div>
                        <div class="card-body">            
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-group has-float-label">
                                        <input class="form-control" id="product_label" name="product_label" placeholder="" autocomplete="off" onkeyup="addprod()" onchange="addprod()" />
                                        <span>Barcode *</span>
                                    </label>
                                </div>   
                                <div class="col-md-1">
                                    <label class="form-group has-float-label">
                                        <input class="form-control" id="qty" name="qty" value="1" autocomplete="off" placeholder="" readonly="" />
                                        <span>Qty *</span>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-primary default" onclick="cariproduk()">Cari Produk</button>
                                </div> 
                                <div class="col-md-5" style="text-align: right;">
                                    <input type="hidden" name="total_qty" id="total_qty" value="0" />
                                    <input type="hidden" name="subtotal" id="subtotal" value="0" />
                                    <h1><label class="control-label" id="sub-total">Sub Total : 0 </label></h1>
                                </div>
                                <div class="col-md-12" id="grid-ui">         
                                    <table id="grid-table"></table>
                                    <div id="grid-pager"></div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-2" style="padding-top: 5px;"><button type="button" class="btn btn-secondary btn-sm mb-1 default" onclick="help()">Help</button></div>
                                <div class="col-md-10" style="padding-top: 5px; text-align: right;"><button type="button" class="btn btn-success btn-sm mb-1 default" onclick="bayar()">Bayar</button></div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php $this->load->view('lov/lov_help'); ?>
    <?php $this->load->view('lov/lov_secret_key'); ?>
    <?php $this->load->view('lov/lov_payment'); ?>
    <?php $this->load->view('lov/lov_product_search'); ?>


<?php $this->load->view('cashier/footer.php'); ?>
