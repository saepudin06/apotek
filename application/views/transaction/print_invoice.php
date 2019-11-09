<?php
    $ci = & get_instance();
    $userdata = $ci->session->userdata;
    $transactionorder_id = $ci->input->post('transactionorder_id');
?>
<div class="row">
    <div class="col-12">        
        <div class="card mb-4">
            <div class="separator mb-2"></div>
            <div class="card-body"> 
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-1">
                        <img src="<?php echo base_url()?>upload/apotek.png" width="100%" height="100%">
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            Apotek
                        </div>
                        <div class="row">
                            <h3>Ating</h3> &nbsp;&nbsp; <h4><i>Ciparay</i></h4>
                        </div>
                        <div class="row">
                            STRA : 19910101/STRA-UNJANI/2013/19813
                        </div>
                        <div class="row">
                            Jl. Raya Laswi RT.06 RW.03 Ds. Pakutandang Kab. Bandung
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>    
                <hr />
                <br>

                <?php
                    $sqla = "SELECT transactionorder_id,
                                    to_char(trx_date, 'dd/mm/yyyy hh24:mi:ss') trx_date,
                                    to_char(created_date, 'yyyymmddhh24miss') created_date,
                                    updated_date,
                                    update_by,
                                    created_by,
                                    qty,
                                    ttl_amount,
                                    status,
                                    cus_payment,
                                    bu_id,
                                    status_posting
                             FROM transactionorder 
                             WHERE transactionorder_id = ?";
                    $qa = $ci->db->query($sqla, array($transactionorder_id));
                    $row = $qa->row_array();

                    $change = (float)$row["cus_payment"] - (float)$row["ttl_amount"];
                ?>
                <div class="row">
                    <div class="col-md-6">
                        Tanggal : <strong><?php echo $row['trx_date'];?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Pegawai : <strong><?php echo strtoupper($row['created_by']);?></strong>
                    </div>
                    <div class="col-md-6" style="text-align:right">
                        Nomor Invoice : <strong><?php echo "INV-".$row['created_date'].$row['transactionorder_id'];?></strong>
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <th scope="col">#</th>
                                <th scope="col">Nama Product</th>
                                <th scope="col" style="text-align: center;">Qty</th>
                                <th scope="col" style="text-align: right;">Harga</th>
                                <th scope="col" style="text-align: right;">Total</th>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM vw_transactionorder_dt WHERE transactionorder_id = ?";
                                    $q = $ci->db->query($sql, array($transactionorder_id));
                                    $items = $q->result_array();

                                    $no = 1;
                                    foreach ($items as $item) {
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $item["product_name"];?></td>
                                        <td style="text-align: center;"><?php echo $item["qty"];?></td>
                                        <td style="text-align: right;"><?php echo number_format($item["sell_price"],0,",",".");?></td>
                                        <td style="text-align: right;"><?php echo number_format($item["amount"],0,",",".");?></td>
                                    </tr>
                                <?php
                                        $no++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="col">Total :</th>
                                    <td style="text-align: right;"><?php echo number_format($row["ttl_amount"],0,",",".");?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Bayar :</th>
                                    <td style="text-align: right;"><?php echo number_format($row["cus_payment"],0,",",".");?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Kembali :</th>
                                    <td style="text-align: right;"><?php echo number_format($change,0,",",".");?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <center><button type="button" class="btn btn-primary btn-lg" onclick="printStruck()"> <i class="glyph-icon simple-icon-printer"> Cetak Struk</i></button><button type="button" class="btn btn-danger btn-lg" onclick="backToCashier()"> <i class="glyph-icon simple-icon-direction"> Kembali</i></button></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function backToCashier(){
        loadContentWithParams("transaction.cashier", {});
    }

    function printStruck(){
        var transactionorder_id = "<?php echo $this->input->post('transactionorder_id');?>";
        $.ajax({
            url: "<?php echo WS_JQGRID."transaction.cashier_controller/printStruk"; ?>" ,
            type: "POST",
            dataType: "json",
            data: {transactionorder_id:transactionorder_id},
            success: function (data) {
                if (data.success){

                    swal("", data.message, "success");

                }else{
                    swal("", data.message, "warning");
                }
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
        // alert(transactionorder_id);
    }
</script>