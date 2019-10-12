<?php defined('BASEPATH') OR exit('No direct script access allowed');

require('fpdf/fpdf.php');
require('fpdf/invClassExtend.php');

class Purchase_req_det_pdf extends CI_Controller{

	var $fontSize = 10;
    var $fontFam = 'Arial';
    var $yearId = 0;
    var $yearCode="";
    var $paperWSize = 297;
    var $paperHSize = 210;
    var $height = 5;
    var $currX;
    var $currY;
    var $widths;
    var $aligns;

    function __construct() {
        parent::__construct();
        //$this->formCetak();
        $pdf = new FPDF();
        $this->startY = $pdf->GetY();
        $this->startX = $this->paperWSize-42;
        $this->lengthCell = $this->startX+20;
    }

    function newLine($pdf){
        $pdf->Cell($this->lengthCell, $this->height, "", "", 0, 'L');
        $pdf->Ln();
    }

    function pdf() {
    	$purchase_request_id = getVarClean('purchase_request_id','int',0);

    	$ci = & get_instance();
        $ci->load->model('transaction/purchase_req_det');
        $table = $ci->purchase_req_det;
        $table->setCriteria("purchase_request_id=".$purchase_request_id);

        $count = $table->countAll();
        $items = $table->getAll(0, -1);

        $pdf = new FPDF();


    
	    $pdf->AliasNbPages();
	    $pdf->AddPage("L", "A4");
	    $pdf->SetFont('Arial', 'B', 16);

	    $pdf->Cell($this->lengthCell, $this->height, "Daftar Permintaan Pembelian", "", 0, 'L');
	    $pdf->SetFont('Arial', 'B', 10);
	    $pdf->Ln(8);

	    $kolom1 = ($this->lengthCell * 4) / 10;
	    $kolom2 = ($this->lengthCell * 2) / 10;
	    $kolom3 = ($this->lengthCell * 2) / 10;
	    $kolom4 = ($this->lengthCell * 2) / 10;

	    $pdf->Cell($kolom1, $this->height, "Produk", "TBLR", 0, 'L');
	    $pdf->Cell($kolom2, $this->height, "Harga Awal", "TBLR", 0, 'R');
	    $pdf->Cell($kolom3, $this->height, "Jumlah", "TBLR", 0, 'R');
	    $pdf->Cell($kolom4, $this->height, "Total", "TBLR", 0, 'R');
	    $pdf->Ln();

	    $pdf->SetFont('Arial', '', 10);
    	$pdf->SetWidths(array($kolom1, $kolom2, $kolom3, $kolom4));
    	$pdf->SetAligns(array("L", "R", "R", "R"));

	    foreach($items as $item) { 

                $pdf->RowMultiBorderWithHeight(array($item['product_name'],
                                                 number_format($item['basic_price']),
                                                 number_format($item['qty']),
                                                 number_format($item['amount'])),
                array('TBLR',
                      'TBLR',
                      'TBLR',
                      'TBLR'
                      )
                    ,$this->height);
        }
        
        $pdf->Output("","I");        
    }

    
}