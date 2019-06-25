<?php

require('fpdf181/fpdf.php');


class invoiceall extends FPDF {
    var $width;
    var $height;
    var $initX;
    var $initY;
    var $initX2;
    var $endY;
	
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
	//$this->SetFont('Arial', 'B', 8);
		/*
		if ($data["faktur"] == 'Faktur Pajak Standar') {
			$this->Cell(29, 8, $data["faktur"]);
		} else {
			$this->Cell(33, 8, $data["faktur"]);
		}
		*/
		//$this->Cell(33, 8, "Faktur Pajak");
		//$this->SetFont('');
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
	
}


$pdf = new invoiceall();
$pdf->AddPage();
$pdf->Ln(10);
// tampilin header
/*$pdf->SetFont('');
$pdf->Cell(69, 10, "");
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(89, 10, "BIAYA PENGGUNAAN", 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell(15, 10, "TELKOM", 0, 0, 'R');
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(14, 10, "Solution", 0, 0, 'R');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell(52, 10, "");
$pdf->Cell(83, 10, "TELKOM", 0, 0, 'R');
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(15, 10, "Solution", 0, 0, 'R');
$pdf->SetTextColor(0);
$pdf->Cell(37, 10, "BILLING STATEMENT", 0, 0, 'R');
$pdf->Ln(5);*/
//$pdf->Cell(110, 10, ": ".$nkpw_pkp, 1);
$pdf->Ln();

$pdf->SetTextColor(0);

//buat nampilin PT Telkom dan alamat
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(30, 10, "INVOICE");
$pdf->SetFont('');
$pdf->Ln(5);
/*$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(58, 10, "JL. JAPATI NO. 1 BANDUNG 40133");
$pdf->SetFont('');
$pdf->Ln(5);*/

$invoice_num = '098908709890-201701';
// buat nampilin npwp/pkp
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 15, "Invoice Number");
$pdf->SetFont('');
$pdf->Cell(5, 15, " : ", 0, 0);
$pdf->Cell(30, 15, $invoice_num, 0, 0);
$pdf->Ln(5);

//buat nampilin official receipt no 
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 10, " ");
$pdf->SetFont('');
$pdf->Cell(48, 10, '', 0, 0);


// Merubah //
$y = $pdf->GetY();
$pdf->SetFillColor(245, 233, 222);
$pdf->SetFontSize(7);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.1);
$position = 5;
$positionTxt = $position + 2;
$pdf->Rect($x+$position, $y, 100, 18);

$pdf->SetFont('Arial', 'B', 8);
$pdf->setKata2('PT TELEKOMUNIKASI INDONESIA Tbk,',35,$x+$positionTxt,50,10,4);
$pdf->SetFont('Arial', '', 8);
$pdf->setKata2('Jl. Japati No. 1 Bandung',35,$x+$positionTxt,50,10,4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setKata2('UP : SGM SSO',35,$x+$positionTxt,50,10,4);


$pdf->SetX($x);

$pdf->setY($y+5);
// Merubah //

$pdf->Ln(5);


$pdf->Ln(5);

// buat nampilin bulan tagih
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 15, "Project Name");
$pdf->SetFont('');
$pdf->Cell(5, 15, " : ", 0, 0);
//$tagih = explode(" ", $bln_tagih);
//$billingMonth = $db->getBulanTagihan($billPeriod,$accountNum); 
//$pdf->Cell(10, 15, "Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Telkom Triwulan 1 2016,  ", 0, 0);
$kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Telkom Triwulan 1 2016';

// $setkata2 ('str', 'width ', 'left margin', 'ln all words ', 'ln / margin bottom') 

$pdf->setKata2($kata,90,45,50,15,5);
//$pdf->Cell(10, 10, ": ".$tagih[1]." ".$tagih[2], 0, 0);
$pdf->Ln(1);

// buat garis
$xLine = $pdf->GetX();
$yLine = $pdf->GetY()+8;
$pdf->SetLineWidth(1);
$pdf->Line($xLine, $yLine, $xLine+185, $yLine);
$pdf->Ln(10);

		
$curr_type = 'Rp.';
$totalll = 22000000;

 $pdf->SetFont('Arial', 'B', 9);
 $deviasi='';

 // cell('length', 'margin top', txt, ?, ?, 'align')
$pdf->Cell(60, 10, "Tagihan Bulan Ini ".$deviasi);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 12.5, " : ", 0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(5, 12.5, $curr_type);  
$pdf->Cell(40, 12.5, number_format($totalll,2,'.',','), 0, 0, 'R');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'BI', 9);
$pdf->Cell(115, 10, "New Charge");
$pdf->Ln();
$pdf->SetFont('');
 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 10, 'Nilai Tagihan'); 
$pdf->Cell(5, 10, " : ", 0, 0);
$pdf->SetFont('');
$pdf->Cell(5, 10, $curr_type);   
$pdf->Cell(30, 10, number_format(20000000,2, '.', ','), 0, 0, 'R');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 10, 'PPN 10%'); 
$pdf->Cell(5, 10, " : ", 0, 0);
$pdf->SetFont('');
$pdf->Cell(5, 10, $curr_type);   
$pdf->Cell(30, 10, number_format(2000000,2, '.', ','), 0, 0, 'R');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 10, 'Terbilang'); 
$pdf->Cell(5, 10, " : ", 0, 0);
$pdf->SetFont(''); 
$kata = '# Dua Puluh Dua Juta Rupiah';
$pdf->setKata2($kata,90,75,50,10,5);
$pdf->SetFont('Arial', 'I', 8);
$kata = '# Twenty Two Million Rupiah';
$pdf->setKata2($kata,90,75,50,10,5);

// ------------------- BANK INFO ---------------//
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 8);
$kata = 'Please make full payment to transfer to our rupiah or dollar account as per the following details :';
$pdf->setKata2($kata,120,10,50,10,5);
$kata = 'Behalf of PT. Graha Sarana Duta';
$pdf->setKata2($kata,90,10,50,10,5);
$kata = 'Mandiri Wisma Alia';
$pdf->setKata2($kata,90,10,50,10,5);
$kata = 'ACC : IDR : 123-0098-158-51-4';
$pdf->setKata2($kata,90,10,50,10,5);
$pdf->Ln(10);
// ------------------- BANK INFO ---------------//

// ------------------- TTD ---------------//
$pos = 150;
$kata = 'Jakarta 01 Maret 2017';
$pdf->setKata2($kata,90,$pos,50,10,5);
$pdf->Ln(1);
$pdf->Image('MAT+TTD.jpg', $pos, null, 40, 30);

$kata = 'M. WISNU ADJI';
$pdf->setKata2($kata,90,$pos,50,5,5);

$kata = 'Finance & GA Director';
$pdf->setKata2($kata,90,$pos,50,5,5);
// ------------------- TTD ---------------//

/*$y = $pdf->GetY();

$inword_ind = "Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta ";
$inword_eng = "Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta Satu Juta ";

$x = $pdf->GetX();
if (strlen($inword_ind) > 80) {
    $addr = explode(" ",$inword_ind);
    $str = arr
    foreach ($addr as $val) {
        $str[$i] .= $val." ";
        if (strlen($str[$i]) > 75) {
            $i++;
        }
    }
    foreach ($str as $val) {
        $pdf->SetX($x);
        $pdf->Cell(50, 8, " ".trim($val));
        $pdf->Ln(5);

    }
} else {
    $pdf->Cell(100, 8, $inword_ind);
    $pdf->Ln(5);
}

$y2 = $pdf->GetY();

// untuk amount in words
$pdf->SetY($y+5);
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(48, 10, "Amount in Words");
$pdf->SetFont('');
$pdf->SetY($y2);

if (strlen($inword_eng) > 80) {
    $addr = explode(" ",$inword_eng);
    $str = array();
    $i = 0;

    foreach ($addr as $val) {
        $str[$i] .= $val." ";
        if (strlen($str[$i]) > 75) {
            $i++;
        }
    }
    $pdf->SetFont('Arial', 'I', 9);
    foreach ($str as $val) {
        $pdf->SetX($x);
        $pdf->Cell(50, 8, " ".trim($val));
        $pdf->Ln(5);
    }
} else {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Cell(100, 8, $inword_eng);
    $pdf->Ln(5);
}*/

/*if (strtoupper($isSave) == 'T'){
	//$filename = "./files/".$accountNum."_".$billPeriod.".pdf";
	$filename = "./files_nonpots/".str_replace(' ','',$data["invoice_no"]).".pdf";
	$pdf->Output($filename);
	//echo"accountNum=".$accountNum." ";
	//echo"billPeriod=".$billPeriod." ";
	//echo"filename=".$filename." ";
	$db->addFiles($accountNum,$billPeriod,0,$filename);
}else{
	$pdf->Output('Telkom_Invoice_'.$_GET['ACCOUNT_NUM'].'_'.$_GET['BILL_PERIOD'].'.pdf','I');
}*/

$pdf->Output();
OCILogOff($conn);
?>



