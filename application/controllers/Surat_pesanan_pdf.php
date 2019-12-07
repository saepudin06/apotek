<?php defined('BASEPATH') OR exit('No direct script access allowed');

require('fpdf/fpdf.php');
require('fpdf/invClassExtend.php');

class Surat_pesanan_pdf extends CI_Controller{

	var $fontSize = 10;
    var $fontFam = 'Arial';
    var $yearId = 0;
    var $yearCode="";
    var $paperWSize = 120;
    var $paperHSize = 150;
    var $height = 5;
    var $currX;
    var $currY;
    var $widths;
    var $aligns;

    function __construct() {
        parent::__construct();
        //$this->formCetak();
        $pdf = new FPDF('P','mm',array(120,150));
        $this->startY = $pdf->GetY();
        $this->startX = $this->paperWSize-40;
        $this->lengthCell = $this->startX+20;
    }

    function newLine($pdf){
        $pdf->Cell($this->lengthCell, $this->height, "", "", 0, 'P');
        $pdf->Ln();
    }

    function pdf() {
        $purchase_order_id = getVarClean('purchase_order_id','int',0);
        $supplier_id = getVarClean('supplier_id','int',0);
        $supplier_name = getVarClean('supplier_name','str','');

    	$ci = & get_instance();
        $ci->load->model('transaction/purchase_order');
        $table = $ci->purchase_order;


        $sql = "SELECT TO_CHAR (po_date, 'dd-mm-yyyy') po_date,
                        code                         
                FROM vw_po_info WHERE purchase_order_id = ?";

        $result = $table->db->query($sql, array($purchase_order_id));
        $rows = $result->row_array();


        $pdf = new FPDF('P','mm',array(120,150));
    
	    $pdf->AliasNbPages();
	    $pdf->AddPage();
	    $pdf->SetFont('Arial', 'B', 9);

        $col1 = ($this->lengthCell * 2) / 10;
        $col2 = ($this->lengthCell * 8) / 10;

        $pdf->Image(base_url().'upload/apotek.png', 10, 10, 20);

        $pdf->Cell($col1, $this->height, "", 0, 0, 'L');
        $pdf->Cell($col2, $this->height, "Apotek", 0, 0, 'L');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($col1, $this->height, "", 0, 0, 'L');
        $pdf->Cell($col2, $this->height, "Ating Ciparay", 0, 0, 'L');
        $pdf->Ln(4);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($col1, $this->height, "", 0, 0, 'L');
        $pdf->Cell($col2, $this->height, "Apoteker : Rinaldi Ardian, S.Farm., Apt", 0, 0, 'L');
        $pdf->Ln(4);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($col1, $this->height, "", 0, 0, 'L');
        $pdf->Cell($col2, $this->height, "STRA : 19910101/STRA-UNJANI/2013/19813", 0, 0, 'L');
        $pdf->Ln(4);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($col1, $this->height, "", 'B', 0, 'L');
        $pdf->Cell($col2, $this->height, "Jl. Raya Laswi RT.06 RW.03 Ds. Pakutandang Kab. Bandung", 'B', 0, 'L');
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Ln(6);
        $pdf->Cell($this->lengthCell, $this->height, "Surat Pesanan", "", 0, 'C');
	    $pdf->SetFont('Arial', '', 8);
	    $pdf->Ln(10);

	    $kolom1 = ($this->lengthCell * 2) / 15;
        $kolom2 = ($this->lengthCell * 6) / 15;
	    $kolom3 = ($this->lengthCell * 7) / 15;
	    
	    $pdf->Cell($kolom1, $this->height, "Pesanan", 0, 0, 'L');
        $pdf->Cell($kolom2, $this->height, ": Obat", 0, 0, 'L');
	    $pdf->Cell($kolom3, $this->height, "Bandung, ".$rows['po_date'], 0, 0, 'L');

        $pdf->Ln(5);
        $pdf->Cell($kolom1, $this->height, "Nomor", 0, 0, 'L');
        $pdf->Cell($kolom2, $this->height, ": ".$rows['code'], 0, 0, 'L');
        $pdf->Cell($kolom3, $this->height, "Kepada Yth, ", 0, 0, 'L');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($kolom1, $this->height, "", 0, 0, 'L');
        $pdf->Cell($kolom2, $this->height, "", 0, 0, 'L');
        $pdf->Cell($kolom3, $this->height, "     ".strtoupper($supplier_name), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        
        $pdf->Ln(10);
        $pdf->Cell($kolom1, $this->height, "Harap Dikirim :", 0, 0, 'L');
        $pdf->Ln(5);

        $sql = "SELECT TO_CHAR (po_date, 'dd-mm-yyyy') po_date,
                        code                         
                FROM vw_po_info WHERE purchase_order_id = ?";

        $result = $table->db->query($sql, array($purchase_order_id));
        $rows = $result->row_array();



        $query = "SELECT b.name, a.qty 
                  FROM vw_purchase_order_det_child a, products b
                  WHERE a.product_id = b.product_id
                  AND purchase_order_id = ?
                  AND supplier_id = ?";

        $result = $table->db->query($query, array($purchase_order_id, $supplier_id));
        $items = $result->result();

        // print_r($items); exit;

        $kol1 = ($this->lengthCell * 1) / 15;
        $kol2 = ($this->lengthCell * 7) / 15;
        $kol3 = ($this->lengthCell * 1) / 15;
        $kol4 = ($this->lengthCell * 6) / 15;

	    $pdf->SetFont('Arial', 'B', 8);

        $pdf->Cell($kol1, $this->height, "No.", 'TB', 0, 'L');
        $pdf->Cell($kol2, $this->height, "Produk", 'TB', 0, 'L');
        $pdf->Cell($kol3, $this->height, "Jml", 'TB', 0, 'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 8);
    	$pdf->SetWidths(array($kol1, $kol2, $kol3));
    	$pdf->SetAligns(array("L", "L", "C"));
        $no = 1;
	    foreach($items as $item) { 

                $pdf->RowMultiBorderWithHeight(array($no,
                                                 $item->name,
                                                 $item->qty),
                array('',
                      '',
                      ''
                      )
                    ,$this->height);

                $no++;
        }

        $pdf->Ln(30);
        $pdf->Cell($kol1+$kol2+$kol3+$kol1+$kol1, $this->height, "", '', 0, 'L');
        $pdf->Cell($kol4, $this->height, "Hormat Kami", 0, 0, 'L');
        
        $pdf->Output("","I");        
    }

    
}