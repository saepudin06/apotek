<?php
class invoiceall extends FPDF {
    var $width;
    var $height;
    var $initX;
    var $initY;
    var $initX2;
    var $endY;
    var $widths;
	
	function setKata2($kata,$jarak,$setX,$setCellW,$setCellH,$setLn){
		$str = array();
		$index = 0;
		$start = 0;
		while (strlen($kata) > $jarak){
			$this->SetX($setX);
			$str[$index] = trim(substr($kata,0,strrpos(substr($kata,0,$jarak),' ',-1)));
			$this->Cell($setCellW, $setCellH, $str[$index]);
			$this->Ln($setLn);
			$start = strlen($str[$index])+1;
			$kata = substr($kata,$start,strlen($kata));
			$index++;
		}
		$this->SetX($setX);
		$str[$index] = trim($kata);
		$this->Cell($setCellW, $setCellH, $str[$index]);
		$this->Ln($setLn);
	}
	
	function drawOtherContent($data,$dataFileName){
        $this->SetX($this->initX-5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 8, "Note");
        $this->Ln(5);

        $this->SetX($this->initX-5);
        $this->SetFont('');
        $this->Cell(6, 8, "1");
        $this->Cell(100, 8, "Ijin Pembubuhan Tanda Bea Meterai Lunas dengan Sistem Komputerisasi dari");
        $this->Ln(5);

        $x = $this->x;
        $y = $this->y;

        $this->SetX($this->initX-5);
        $this->SetFont('');
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "Dir. Jend. Pajak Nomor : ".$data["invoice_num"].", Tanggal : ".$data["tanggal"]);
        $this->Ln(5);

        $this->Line($this->initX+2, $this->y+2, $this->initX-5+118, $this->y+2);

        $this->SetX($this->initX-5);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "Permission for posted stamp duty settlement by computerization system for Director");
        $this->Ln(5);

        $this->SetX($this->initX-5);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "General of Taxes No: ".$data["invoice_num"].", Dated : ".$data["date_eng"]);
        $this->Ln(5);

        $this->SetX($this->initX-5);
        $this->SetFont('');
        $this->Cell(6, 8, "2");
        $this->Cell(35, 8, "Kuitansi ini berlaku sebagai");
	
		$this->Cell(75, 8, "Faktur Pajak sesuai dengan Keputusan Direktur");
        $this->Ln(5);

        $this->SetX($this->initX-5);
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "Jendral Pajak No. 10/PJ/2010, tanggal 9 Maret 2010");
        $this->Ln(5);

        $this->Line($this->initX+2, $this->y+2, $this->initX-5+118, $this->y+2);

        $this->SetFont('Arial', 'I', 8);
        $this->SetX($this->initX-5);
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "This Billing receipt is certified as tax form with regard to the Decree of Director General");
        $this->Ln(5);

        $this->SetX($this->initX-5);
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "of Taxes No. 10/PJ/2010, dated March 9, 2010");
        $this->Ln(5);

        $this->SetFont('');
        $this->SetX($this->initX-5);
        $this->Cell(6, 8, "3");
        $this->Cell(100, 8, "Kuitansi ini sah jika pembayaran telah diterima");
        $this->Ln(5);

        $this->Line($this->initX+2, $this->y+2, $this->initX-5+118, $this->y+2);

        $this->SetFont('Arial', 'I', 8);
        $this->SetX($this->initX-5);
        $this->Cell(6, 8, "");
        $this->Cell(100, 8, "This billing receipt is valid only when the payment have already been received");
        $this->Ln(5);
		
		//echo($data["curr_type"]);
		if ($data["curr_type"] == "USD" || $data["curr_type"] == "EUR") {
			$this->SetFont('');
			$this->SetX($this->initX-5);
			$this->Cell(6, 8, "4");
			$this->Cell(100, 8, "Kurs ".$data["curr_type"]." minggu ini");
	        $this->Ln(5);
			
	        $this->Line($this->initX+2, $this->y+2, $this->initX-5+50, $this->y+2);
			$this->SetY($this->y-3);
			$this->SetX($this->initX-5+56);
			$this->Cell(50, 8, "RP. ". number_format($data["kurs"],2,'.',','));
			$this->Ln(4);

	        $this->SetFont('Arial', 'I', 8);
	        $this->SetX($this->initX-5);
	        $this->Cell(6, 8, "");
	        $this->Cell(100, 8, $data["curr_type"]."/IDR Exchange Rate this week");
	        $this->Ln(5);
		}

        //$this->SetFillColor(200);
        $x+=140;
        //$this->Rect($x, $y, 50, 59);
        $xIsi = $x;
        $this->SetY($y);
		$this->SetFont('Arial', '', 9);
        
        $this->SetX($xIsi);
        // $this->Cell(50, 8, $data["ttd_lok"].", ".$this->dateIndo("1", date("n"), date("Y")));
        $this->Cell(50, 8, $data["ttd_lok"].", ".$data["tgl_ttd"]);
        $this->Ln(10);
		$this->SetFont('');

        $this->SetX($xIsi+5);
        if (is_file($data["ttd_file"]))
			$folder = "../ttd/";
			$this->Image($folder.$dataFileName["file_name2"], null, null, 40, 30);
			//$this->Image($data["ttd_file"], null, null, 30, 30);
            //$this->Image($data["ttd_file"]);
	 //else
		//echo($data["ttd_file"]);
        $this->Ln(5);
		$ttd = explode("|", $data["ttd_name"]);
        $this->SetFont('Arial', 'BU', 9);
        $this->SetX($xIsi);
        $this->Cell(50, 8, $dataFileName["ttd_nama"]);
        $this->Ln(5);
		$this->SetFont('Arial', '', 9);
        $this->SetX($xIsi);
		$this->setKata2($dataFileName["ttd_jab"],29,$xIsi,50,8,5);
        //$this->Cell(50, 8, $dataFileName["ttd_jab"]);
        $this->Ln(5);
    }
	
    function headerInvoiceReciept($header) {
		$this->Ln(10);
        $popHeader = explode(";", $header);
        $this->SetFont('Arial', 'B',13);
        foreach ($popHeader as $val) {
            $this->Cell($this->ws, 10, $val, 0, 0, 'C');
            $this->Ln(5);
        }
        $this->Ln();
    }
	
	function  dateIndo($d, $m, $y) {
	    $bulan;
	    switch ($m) {
	        case "1" :
	            $bulan = "Januari";
	            break;
	        case "2" :
	            $bulan = "Februari";
	            break;
	        case "3" :
	            $bulan = "maret";
	            break;
	        case "4" :
	            $bulan = "April";
	            break;
	        case "5" :
	            $bulan = "Mei";
	            break;
	        case "6" :
	            $bulan = "Juni";
	            break;
	        case "7" :
	            $bulan = "Juli";
	            break;
	        case "8" :
	            $bulan = "Agustus";
	            break;
	        case "9" :
	            $bulan = "September";
	            break;
	        case "10" :
	            $bulan = "Oktober";
	            break;
	        case "11" :
	            $bulan = "November";
	            break;
	        case "12" :
	            $bulan = "Desember";
	            break;	        
	    }
		
	    return $d." ".$bulan." ".$y;
	}

    function drawSquare($invoiceno) {
        $this->width = 180;
        $this->height = 120;
        $this->initX = $this->GetX()+10;
        $this->initX2 = $this->initX + 110;

        $this->Rect($this->initX, $this->GetY(), $this->width, $this->height);
		$this->SetFont('Arial', 'B',14);
        $this->Cell($this->ws, 10, 'OFFICIAL RECEIPT', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell($this->ws, 10, 'INVOICE NUMBER : '.$invoiceno, 0, 0, 'C');
        $this->Ln(5);
        $this->initY = $this->GetY()+5;
        $this->Line($this->initX, $this->initY, $this->initX+$this->width, $this->initY);

        $this->Line($this->initX2, $this->initY, $this->initX2, $this->initY+$this->height-15);
        $this->Ln();
        $this->initX += 5;
        $this->initX2 += 5;
    }

    function drawContentReceipt($data,$npwp) {
        $this->SetX($this->initX);
        $this->SetFont('Arial', 'BU', 8);
		
        $this->Cell(40, 8, "Terima dari");
		$y = $this->y+4;
        $this->SetFont('');
		$this->SetX($this->initX+40);
		$x3 = $this->x;
		$this->Cell(2, 8, ":");
		$addr =  $data["cust_name"];
		$addrLength = strlen($addr);
		$this->setKata2($addr,34,$x3+2,50,8,5);
		
		$y2 = $this->y;
		
		$this->SetY($y);
        $this->SetX($this->initX);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(40, 8, "Received From");
        $this->SetFont('');
		$this->SetY($y2);
		$addrs = explode(";", $data["addr"]);
        $addr = $addrs[0];
        $addrLength = strlen($addr);
        $y = $this->GetY();
        $x = $x3;//$this->GetX();
		
		$this->setKata2($addr,35,$x+2,50,8,5);
		
        $this->SetX($x+1);
		$this->Cell(1, 8, " ");
		$this->Cell(40, 8, $addrs[1]. " ". $addrs[2]);
		$this->Ln(5);
		$this->SetX($x);
        $this->SetFont('Arial', 'B', 8);
		$this->Cell(2, 8, " ");
        $this->Cell(50, 8, " NPWP : ".$npwp);//$data["nomor_seri"]);
		if ( !empty($data["nppkp"]) && $data["nppkp"] != '-') {
	        $this->SetY($this->y+5);
	        $this->SetX($x);
	        $this->Cell(50, 8, " NPPKP : ".$data["nppkp"]);
		}
        $this->Ln(10);
        
        $this->SetX($this->initX);
		
        $this->SetFont('Arial', 'BU', 8);
        $this->Cell(40, 8, "Uang Sejumlah");
        $this->SetFont('');
		$this->Cell(2, 8, ":");
		$y2 = $this->y+4;
        $invoiceInd = $data["invoice_txt_ind"];
        $y = $this->GetY();
        $x3 = $this->GetX();
		
		$this->setKata2($invoiceInd,45,$x3,50,8,5);
		
		$y = $this->y;
		$this->SetY($y2);
        $this->SetX($this->initX);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(40, 8, "The Sum Of");
        $this->SetFont('Arial', 'I', 8);
        $invoiceInd = $data["invoice_txt_eng"];
		$this->SetY($y);
		//$this->Cell(1, 8, ":");
        $y = $this->GetY();
        $x = $x3;//$this->GetX();
		
		$this->setKata2($invoiceInd,47,$x3,50,8,5);

        $this->SetX($this->initX);
        $this->SetFont('Arial', 'BU', 8);
        $this->Cell(40, 8, "Untuk Pembayaran");
        $this->SetFont('');
		$this->Cell(2, 8, ":");
        $this->Cell(50, 8, "Biaya Jasa Layanan Telkom Solution");
        $this->Ln(4);
        $this->SetX($this->initX);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(40, 8, "In Payment Of");
        $this->Ln(5);

        $this->SetX($this->initX);
        $this->SetFont('');
        $this->Cell(40, 8, "");
		$this->Cell(2, 8, " ");
        $this->Cell(22, 8, "Invoice Number");
		$this->Cell(5, 8, ":");
		$this->Cell(20, 8, $data["invoice_no"]);
        $this->Ln(5);
		
		$this->SetX($this->initX);
        $this->SetFont('');
        $this->Cell(40, 8, "");
		$this->Cell(2, 8, " ");
        $this->Cell(22, 8, "Account Number");
		$this->Cell(5, 8, ":");
		$this->Cell(20, 8, $data["formatted_prefix"]);
        $this->Ln(5);
		
		$this->SetX($this->initX);
        $this->SetFont('');
        $this->Cell(40, 8, "");
		$this->Cell(2, 8, " ");
        $this->Cell(22, 8, "Billing Month");
		$this->Cell(5, 8, ":");
		$this->Cell(20, 8, $data["tagih_date"]);
        $this->Ln(5);
		
        $this->endY = $this->GetY();
    }

    function drawSideContent($data) {
        if ($data["curr_type"] == "IDR") {
			$curr_type = "Rp.";
		} else if ($data["curr_type"] == "USD") {
			$curr_type = "US$";
		} else {
			$curr_type = "EUR";
		}
        //$this->SetX($this->initX2);
        $this->SetY($this->initY+5);

        $this->SetFont('Arial', 'BU', 8);
        $this->SetX($this->initX2);
        $this->Cell(20, 8, "Jumlah");
		$this->SetFont('Arial', 'B',9);
		$this->Cell(10, 8, ": ". $curr_type);
        $this->Cell(34, 8, number_format(($data["tot_bill"]-$data["invoice_tax"]) , 2, '.', ','), 0, 0, 'R');
        $this->Ln(4);
		$this->SetFont('');

        $this->SetFont('Arial', 'I', 8);
        $this->SetX($this->initX2);
        $this->Cell(20, 8, "Amount");
        $this->Ln(10);
        
        $this->SetFont('Arial', 'BU', 8);
        $this->SetX($this->initX2);
        $this->Cell(20, 8, "PPN");
		$this->SetFont('Arial', 'B',9);
		$this->Cell(10, 8, ": ". $curr_type);
		
        $this->Cell(34, 8, number_format($data["invoice_tax"], 2, '.', ','), 0, 0, 'R');
        $this->Ln(4);
		
		$this->SetFont('Arial', 'I', 8);
        $this->SetX($this->initX2);
        $this->Cell(20, 8, "VAT");

        $this->Line($this->initX2-5, $this->initY+95,$this->initX2+65,$this->initY+95);
        $this->Ln(10);
        
        $this->SetY($this->initY+95);
        $this->SetX($this->initX2);
		$this->SetFont('Arial', 'BU',9);
        $this->Cell(20, 8, "Total");
		$this->SetFont('Arial', 'B',9);
		$this->Cell(10, 8, ": ". $curr_type);

        $this->Cell(34, 8, number_format(($data["tot_bill"]),2,'.',','), 0, 0, 'R');
        $this->Ln(20);
    }

    function headerInvoiceDetail($data,$billingMonth,$due_date) {

		$this->Ln(17);
		$this->SetFont('Arial', 'B', 11);
        $this->Cell(109, 9, "RINCIAN BIAYA PENGGUNAAN", 0, 0, 'R');
        $this->SetTextColor(0, 0, 255);
        
		$this->SetFont('Arial', 'BI', 11);
        $this->Cell(17, 9, "TELKOM", 0, 0, 'R');
        $this->SetTextColor(255, 0, 0);
        $this->Cell(17, 9, "Solution", 0, 0, 'R');
        $this->SetTextColor(0);
        $this->Ln(5);

        $this->SetFont('Arial', 'I', 11);
        $this->SetTextColor(0, 0, 255);
        $this->Cell(98, 9, "TELKOM", 0, 0, 'R');
        $this->SetTextColor(255, 0, 0);
        $this->Cell(16, 9, "Solution", 0, 0, 'R');
        $this->SetTextColor(0);
        $this->Cell(29, 9, "DETAIL USAGE", 0, 0, 'R');
        $this->SetTextColor(0);

        $this->Ln(10);
		
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($this->ws, 9, $data["cust_name"], 0, 0, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 8);
		$this->Cell(30,9,"");
        $this->Cell(22, 9, "Nomor Tagihan.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(53, 9, "Invoice Number");
        $this->SetFont('');
        $this->Cell(50, 9, ": ".$data["invoice_no"]);
        $this->Ln(5);
		
		$this->SetFont('Arial', 'B', 8);
		$this->Cell(30,9,"");
        $this->Cell(10, 9, "NPWP.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(65, 9, "NPWP");
        $this->SetFont('');
        $this->Cell(2, 9, ":");
		$this->SetFont('Arial', 'B', 8);
		$this->Cell(49, 9, $data["npwp"]);
		
        $this->Ln(5);

        
        $this->SetFont('Arial', 'B', 8);
		$this->Cell(30,9,"");
        $this->Cell(12, 9, "CIDNAS.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(63, 9, "Customer ID");
        $this->SetFont('');
        $this->Cell(50, 9, ": ".$data["cid_nas"]);
        $this->Ln(5);
		
		$this->SetFont('Arial', 'B', 8);
		$this->Cell(30,9,"");
        $this->Cell(23, 9, "Nomor Account.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "Account Number");
        $this->SetFont('');
        $this->Cell(50, 9, ": ".$data["formatted_prefix"]);
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 8);
		$this->Cell(30,9,"");
        $this->Cell(21, 9, "Bulan Tagihan.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(54, 9, "Billing Month");
        $this->SetFont('');
        $this->Cell(50, 9, ": ".$billingMonth);
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 8);
		$this->Cell(30,9,"");
        $this->Cell(37, 9, "Tanggal Akhir Pembayaran.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(38, 9, "Due Date");
        $this->SetFont('');
        //$this->Cell(50, 9, ": ".$data["due"]);
		$this->Cell(50, 9, ": ".$due_date);
        $this->Ln(10);
    }

    function drawTableData($data, $curr_type,$totTagihan,$tableName,$cust_ref) {
		
		
        $this->SetFont('Arial', '', 6);

        $tot = 0;
        foreach ($data as $key => $val) {
            $this->SetFont('Arial', 'BU', 7);
            $this->Cell(90, 9, "* ".$val);
            $this->Ln(5);

            $this->SetFont('Arial', 'B', 7);
            // judul
            $this->Cell(10, 9, "No.");
            $this->Cell(80, 9, "DESCRIPTION", 0, 0);
            $this->Cell(28, 9, "ID", 0, 0, 'C');
            $this->Cell(12, 9, "BW", 0, 0, 'C');
            $this->Cell(20, 9, "PERIOD", 0, 0, 'C');
            $this->Cell(20, 9, "AMOUNT (".$curr_type.")", 0, 0, 'C');
            $this->Ln(3);

         
			
            $this->Cell(10, 9, "");
			$this->SetFont("Arial", 'B', 7);
            $this->Cell(134, 9, "Sub. ".$val, 0, 0, 'C');
            $this->Cell(22, 9, number_format($subTot ,2,'.',','), 0, 0, 'R');
            $this->Ln(5);

            OCIFreeStatement($stmt5);
            $tot += $subTot;
			//$tot += $totTagihan;
        }
        $this->Cell(10, 9, "");
		$this->SetFont("Arial", 'B', 8);
        $this->Cell(133, 9, "Total Tagihan", 0, 0, 'C');
      //  $this->Cell(23, 9, number_format($totTagihan,2,'.',','), 0, 0, 'R');
        $this->Cell(23, 9, number_format($tot,2,'.',','), 0, 0, 'R');
        $this->Ln(5);
    }

    function drawHeaderContent($data) {
		$this->Ln(10);
		$this->SetFont('');
        $this->Cell(65, 10, "");
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(93, 10, "INFORMASI CARA DAN TEMPAT PEMBAYARAN", 0, 0, 'R');
        $this->Ln(4);

        $this->Cell(65, 10, "");
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(93, 10, "PAYMENT INFO AND PAYMENT LOCATION", 0, 0, 'R');
        $this->Ln(4);

        $this->Cell(65, 10, "");
        $this->SetTextColor(0, 0, 255);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(80, 10, "TELKOM", 0, 0, 'R');
        $this->SetTextColor(255, 0, 0);
        $this->Cell(14, 10, "Solution", 0, 0, 'R');
        $this->Ln(5);
        $this->SetTextColor(0);

        $this->Line(70, $this->y+2, 167, $this->y+2);
		$this->SetFont('');
        $this->Cell(66, 10, "");
        $this->SetFont('Arial', '', 8);
        $this->Cell(93, 10, "Tunjukkan lembar ini kepada Teller Bank saat pembayaran dilakukan", 0, 0, 'R');
        $this->Ln(4);

        $this->Cell(59, 10, "");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(65, 10, "Please show this form to the Bank's Teller during", 0, 0, 'R');
		$this->SetTextColor(0, 0, 255);
		$this->Cell(12, 10, "TELKOM", 0, 0, 'R');
        $this->SetTextColor(255, 0, 0);
        $this->Cell(11, 10, "Solution", 0, 0, 'R');
		$this->SetTextColor(0);
		$this->Cell(12, 10, "payment", 0, 0, 'R');
        $this->Ln();
		
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(50, 9, $data["cust_name"]);
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(23, 9, "Nomor Account.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "Account Number");
        $this->SetFont('');
        $this->Cell(50, 9, ": ".$data["formatted_prefix"]);
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(22, 9, "Bulan Tagihan.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(53, 9, "Billing Month");
        $this->SetFont('');
        $this->Cell(50, 9, ": ".$data["month_ind"]);
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(23, 9, "Jumlah Tagihan.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "Bill Ammount");
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(50, 9, ": ".$data["curr_type"]. " " .number_format($data["tot_bill"],2,'.',','));
        $this->Ln(15);
    }

    function drawContent($data) {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 9, "1.");
        $this->Cell(28, 9, "NOMOR ACCOUNT.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "ACCOUNT NUMBER");
        $this->Ln(5);

        $this->SetFont('');
        $this->Cell(4, 9, "");
        $this->Cell(89, 9, "Nomor Account/Account Number tagihan "
            ."TELKOMSolution ini adalah : ");
		$this->SetFont('Arial', 'B', 8);
		$this->Cell(23, 9, $data["formatted_prefix"]);
        $this->Ln(5);

        $this->SetFont('');
        $this->Cell(4, 9, "");
        $this->Cell(65, 9, "Nomor Account ini wajib disampaikan/dicantumkan");
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(60, 9, "sebagai referensi saat pembayaran dilakukan");
        $this->Ln(5);

        $this->Line($this->x+5, $this->y+2, $this->x+140, $this->y+2);

        $this->SetFont('Arial', 'I');
        $this->Cell(4, 9, "");
        $this->Cell(53, 9, "This TELKOMSolution Account Number : ");
		$this->SetFont('Arial', 'B', 8);
		$this->Cell(23, 9, $data["formatted_prefix"], 0, 0);
        $this->Ln(5);

        $this->SetFont('Arial', 'I');
        $this->Cell(4, 9, "");
        $this->Cell(180, 9, "Account Number should be written as a payment reference");
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 9, "2.");
        $this->Cell(35, 9, "JUMLAH PEMBAYARAN.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "PAYMENT AMOUNT");
        $this->Ln(5);

        $kata = "Jumlah yang harus dibayar pada bulan ini ".$data["before_payment_cut_ind"]
        ." adalah sebesar : ";

        $this->setKata($kata, 80, '', '',5);
		$kata = $data["curr_type"]." ".number_format($data["hasil_potongan"],2,'.',',');
		$this->setKata($kata, 80, 'B', '',5);
		
		if (!empty($data["after_payment_cut_ind"])) {
			$kata = trim($data["after_payment_cut_ind"]);
			$this->setKata($kata, 80, '', '',5);
		}
		
        $this->Line($this->x+5, $this->y+2, $this->x+140, $this->y+2);

        $kata = "This month billing amount" .
        $data["before_payment_cut_eng"] ." is  ";
        

        $this->setKata($kata, 80, 'I', '',5);
		
		$this->setKata($kata, 80, '', '',5);
		$kata = $data["curr_type"]." ".number_format($data["hasil_potongan"],2,'.',',');
		$this->setKata($kata, 80, 'B', '',5);
		
		if (!empty($data["after_payment_cut_eng"])) {
			$kata = trim($data["after_payment_cut_eng"]);
			$this->setKata($kata, 80, 'I', '',5);
		}

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 9, "3.");
        $this->Cell(50, 9, "CARA DAN TEMPAT PEMBAYARAN.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "METHOD AND PAYMENT LOCATION");
        $this->Ln(5);
		
		$kata = "Loket Bank Payment Gateway (Host to Host)";
		$this->setKata($kata, 100, 'B', 'a.',5);
		
        $kata = "Loket Bank Payment Gateway adalah pembayaran di Bank yang secara langsung terintegrasi dengan database TELKOM.";
        $this->setKata($kata, 100, '', '-',5);

        $kata = "Pembayaran dengan cara ini hanya dapat dilakukan pada bank yang sudah bekerja sama dengan Telkom untuk layanan pembayaran tagihan TELKOMSolution, yaitu :";
        $this->setKata($kata, 100, '', '-',5);
		
		$bank_gateway = explode(";",$data["bank_gateway"]);
		
		for ($i=1; $i<count($bank_gateway); $i++) {
			$kata = $i.". ".$bank_gateway[$i-1]." (Seluruh cabang ".$bank_gateway[$i-1]." di Indonesia)";
			$this->setKata($kata, 100, '', '-',5);			
		}


        $this->Line($this->x+9, $this->y+2, $this->x+140, $this->y+2);

        $kata = "Bank Payment Gateway is the payment location in the bank that " .
            "is integrated with Telkom's database. " .
            "This payment method can be done only with Participant Banks " .
            "that have already have cooperation with Telkom for TELKOMSolution " .
            "Billing Payment :";
        $this->setKata($kata, 100, 'I', '-',5);

        for ($i=1; $i<count($bank_gateway); $i++) {
			$kata = $i.". ".$bank_gateway[$i-1]." (All ".$bank_gateway[$i-1]." Branch Office Throughout Indonesia)";
			$this->setKata($kata, 100, 'I', '-',5);			
		}

        $kata = "Transfer";
        $this->setKata($kata, 100, 'B', 'b.',5);

        $kata = "Pembayaran dapat juga dilakukan melalui transfer rekening :";
        $this->setKata($kata, 100, '', '-',5);

        $this->Line($this->x+9, $this->y+2, $this->x+140, $this->y+2);

        $kata = "Payment also can be done through Bank Transfer :";
        $this->setKata($kata, 100, 'I', '-',5);
		
		if (!empty($data["bank_owner_eng"])) {
			$kata = "IDR";
	        $this->setKata($kata, 100, 'B', '-',5);
		}

        $kata = $data["bank_owner_ind"];
        $this->setKata($kata, 100, 'B', '-',5);

        $kata = $data["bank_name_ind"];
        $this->setKata($kata, 100, 'B', '-',5);

        $kata = $data["bank_address_ind"]." ".$data["bank_zipcode_ind"];
        $this->setKata($kata, 100, 'B', '-',5);

        $kata = $data["bank_account_ind"];
        $this->setKata($kata, 100, 'B', '-',5);

        if (!empty($data["bank_owner_eng"])) {
			$kata = "USD";
			$this->setKata($kata, 100, 'B', '-',5);

            $kata = $data["bank_owner_eng"];
            $this->setKata($kata, 100, 'B', '-',5);

            $kata = $data["bank_name_eng"];
            $this->setKata($kata, 100, 'B', '-',5);

            $kata = $data["bank_address_eng"]." ".$data["bank_zipcode_eng"];
            $this->setKata($kata, 100, 'B', '-',5);

            $kata = $data["bank_account_eng"];
            $this->setKata($kata, 100, 'B', '-',5);
        }
		$this->Ln(2);
		$this->SetFont('');
        $this->Cell(8, 9, "");
        $kata = "Bukti Transfer agar dikirimkan kepada kami melalui " .
            "fax nomor : ";
		$this->Write(5, $kata);
        //$this->setKata($kata, 100, '', '-');
		
		$kata = $data["fax"];
		//$this->setKata($kata, 100, 'B', '-');
		$this->SetFont('Arial', 'B', 8);
		$this->Write(5,$kata);
		$this->Ln(3);
        $this->Line($this->x+9, $this->y+2, $this->x+140, $this->y+2);
		$this->Ln(2);
		$this->Cell(8, 9, "");
		$this->SetFont('Arial', 'I', 8);
        $kata = "Please fax the transfer receipt to us via fax no : ";
		$this->Write(5, $kata);
        //$this->setKata($kata, 100, 'I', '-');
		
		//$this->SetX($this->x+10);
		//$this->SetFont('Arial', 'B', '9');
		//$this->Cell(15, 9, $data["fax"]);
		//$this->Ln(5);
		$this->SetFont('Arial', 'B', 8);
		$kata = $data["fax"];
		$this->Write(5, $kata);
		$this->Ln(2);
		$this->SetFont('');

		//$this->setKata($kata, 100, 'B', '-');
		
		$bankGateway = explode(";",$data["bank_gateway"]);
		
		foreach ($bankGateway as $val) {
			if (!empty($val)) {
				$bank .= $val." dan ";
			}
		}
		
		//echo ($bank);
		
		$str = substr_replace($bank, "", -5, -1);

		$kata = "Auto/Direct Debit";
		$this->setKata($kata, 100, 'B', 'c.',5);
         $kata = "Adalah cara pembayaran tagihan TELKOMSolution dengan " .
            "memberikan kuasa kepada bank untuk mendebit secara langsung " .
            "rekening pelanggan setiap bulan. Untuk pengajuan pembayaran " .
            "dengan auto/direct debit, pelanggan dapat langsung ke bank yang " .
            "mempunyai kerjasama dengan TELKOM untuk layanan pembayaran " .
            "tagihan TELKOMSolution, yaitu : ".trim($str).".";
        $this->setKata($kata, 100, '', '-',5);

        $kata = "Apabila terjadi putus kontrak (berhenti berlangganan), " .
            "pelanggan berkewajiban untuk memberikan informasi kepada " .
            "Auto/Direct Debit bersangkutan.";
        $this->setKata($kata, 100, '', '-',5);

        $this->Line($this->x+9, $this->y+2, $this->x+140, $this->y+2);

        $kata = "One of the TELKOMSolution payment method by giving the " .
            "bank an authorization to auto debit your account directly every month.";
        $this->setKata($kata, 100, 'I', '-',5);

        $kata = "for Auto Debit Payment, customer can go directly to " .
            "the participant bank that already have cooperation with TELKOM. " .
            "In case of contract termination, customer must inform auto debit bank.";
        $this->setKata($kata, 100, 'I', '-',5);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4, 9, "4.");
        $this->Cell(43, 9, "BATAS WAKTU PEMBAYARAN.");
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(52, 9, "PAYMENT DUE DATE");
        $this->Ln(5);

        $kata = "Dalam rangka meningkatkan pelayanan, sesuai informasi " .
            "kami sebelumnya, terhitung mulai bulan tagihan Juni 2007, " .
            "Telkom memberlakukan ketentuan baru tentang pola pembayaran, " .
            "denda, isolir dan pemutusan layanan. Untuk menghindari " .
            "terjadinya sanksi denda dan isolir, mohon pembayaran dapat " .
            "dilakukan sebelum tanggal : " . $data["bill_last_day"];
        $this->setKata($kata, 100, '', '',5);

        $this->Line($this->x+5, $this->y+2, $this->x+140, $this->y+2);

        $kata = "As we have previously informed, effectively start in " .
            "June 2007, Telkom will apply new regulation of termination " .
            "payment method, sanction and service termination. To avoid " .
            "fine/termination sanction,the payment should be receive/done " .
            "before : ". $data["bill_last_day"];
        $this->setKata($kata, 100, 'I', '',5);

    }

    function setKata($kata, $jarak, $ind, $tamb,$ln) {
        if (strlen($kata) > $jarak) {
            $expKata = explode(" ", $kata);
            $str = array();
            foreach ($expKata as $val) {
                $str[$i] .= $val." ";

                if (strlen($str[$i]) > $jarak-10) {
                    $i++;
                }
            }

            $count = 0;
            foreach ($str as $val) {
                $this->Cell(4, 9, "");
                if (!empty($tamb)) {
                    $this->SetFont('Arial', 'B');
                    if ($count == 0 && $tamb != '-')
                    $this->Cell(4, 9, $tamb);
                    else
                    $this->Cell(4, 9, '');
                    $this->SetFont('');
                }
                $this->SetFont('Arial', $ind);
                $this->Cell(140, 9, $val);
                $this->Ln($ln);
                $count++;
            }
        } else {
            $this->Cell(4, 9, "");
            if (!empty($tamb)) {
                $this->SetFont('Arial', 'B');
                if ($count == 0 && $tamb != '-')
                $this->Cell(4, 9, $tamb);
                else
                $this->Cell(4, 9, '');
                $this->SetFont('');
            }
            $this->SetFont('Arial', $ind);
            $this->Cell(140, 9, $kata);
            $this->Ln($ln);
        }
    }
	
    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }
function newLine(){
        $this->Cell($this->lengthCell, $this->height, "", "", 0, 'L');
        $this->Ln();
    }
    
    function kotakKosong($pembilang, $penyebut, $jumlahKotak){
        $lkotak = $pembilang / $penyebut * $this->lengthCell;
        for($i = 0; $i < $jumlahKotak; $i++){
            $this->Cell($lkotak, $this->height, "", "LR", 0, 'L');
        }
    }
    
    function kotak($pembilang, $penyebut, $jumlahKotak, $isi){
        $lkotak = $pembilang / $penyebut * $this->lengthCell;
        for($i = 0; $i < $jumlahKotak; $i++){
            $this->Cell($lkotak, $this->height, $isi, "TBLR", 0, 'C');
        }
    }
    
    function getNumberFormat($number, $dec) {
            if (!empty($number)) {
                return number_format($number, $dec);
            } else {
                return "";
            }
    }
    
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    
    function RowMultiBorderWithHeight($data, $border = array(),$height)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=$height*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //$this->Rect($x,$y,$w,$h);
            $this->Cell($w, $h, '', isset($border[$i]) ? $border[$i] : 1, 0);
            $this->SetXY($x,$y);
            //Print the text
            $this->MultiCell($w,$height,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    
    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r", '', $txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
{
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
    
    function Footer() {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','B',8);
        // Print centered page number
        //$this->Cell(0,10,'Halaman '.$this->PageNo(),0,0,'R');
    }
    
    function __destruct() {
        return null;
    }

}

?>