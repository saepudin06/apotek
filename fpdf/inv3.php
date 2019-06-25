<?php

require('fpdf181/fpdf.php');
require('invClassExtend.php');


$pdf = new invoiceall();
$pdf->AddPage();
$pdf->Ln(10);

$invoice_num = '098908709890-201701';
// buat nampilin npwp/pkp
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180,10, "Faktur Pajak",0,0,'C');
$pdf->Ln(10);

$curr_type = 'Rp.';

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(190, 7, ' Kode dan Nomor Seri Faktur Pajak : 030.033-16.68310110', 1, 1); 
$pdf->Cell(190, 7, ' Pengusaha Kena Pajak', 1, 0); 
$pdf->Ln();
$curr_type = 'Rp.';

// Rectangle //
$y = $pdf->GetY();
$pdf->SetFillColor(245, 233, 222);
$pdf->SetFontSize(7);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.1);
$position = 0;
$positionTxt = $position + 2;
$pdf->Rect($x+$position, $y, 190, 18);

$marginTop = 7;
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, $marginTop, ' Nama', $x+$positionTxt); 
$pdf->Cell(5, $marginTop, ':',0,0);   
$pdf->Cell(50, $marginTop, 'PT GRAHA SARANA DUTA', 0, 0, 'L');

$pdf->Ln(4);

$pdf->Cell(15, $marginTop, ' Alamat', $x+$positionTxt); 
$pdf->Cell(5, $marginTop, ':',0,0);   
$kata = 'JL. KEBON SIRIH NO.10, GAMBIR, JAKARTA PUSAT ';
$pdf->setKata2($kata,90,30,50,$marginTop,4);

$pdf->Cell(15, $marginTop, ' NPWP', $x+$positionTxt); 
$pdf->Cell(5, $marginTop, ':',0,0);   
$pdf->Cell(50, $marginTop, '01.000.013.1-093.000', 0, 0, 'L');
$pdf->Ln(10);

$pdf->Cell(190, 7, ' Pembeli Barang Kena Pajak / Penerima jasa Kena Pajak', 1, 0); 
$pdf->Ln(7);

// Rectangle //
$y = $pdf->GetY();
$pdf->SetFillColor(245, 233, 222);
$pdf->SetFontSize(7);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.1);
$position = 0;
$positionTxt = $position + 2;
$pdf->Rect($x+$position, $y, 190, 18);

$marginTop = 7;
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, $marginTop, ' Nama', $x+$positionTxt); 
$pdf->Cell(5, $marginTop, ':',0,0);   
$pdf->Cell(50, $marginTop, 'PT GRAHA SARANA DUTA', 0, 0, 'L');

$pdf->Ln(4);

$pdf->Cell(15, $marginTop, ' Alamat', $x+$positionTxt); 
$pdf->Cell(5, $marginTop, ':',0,0);   
$kata = 'JL. KEBON SIRIH NO.10, GAMBIR, JAKARTA PUSAT ';
$pdf->setKata2($kata,90,30,50,$marginTop,4);

$pdf->Cell(15, $marginTop, ' NPWP', '0', 0); 
$pdf->Cell(5, $marginTop, ':',0,0);   
$pdf->Cell(50, $marginTop, '01.000.013.1-093.000', 0, 0, 'L');

//$pdf->BasicTable($header, $data);
$pdf->Ln(10);
$pdf->Cell(10,10,'No','BLR', 0,'C');
$pdf->Cell(130,10,'Nama Barang Kena Pajak / Jasa Kena Pajak','BR',0,'C');
$pdf->MultiCell(50,5,'Harga Jual / Penggantian / Uang Muka / Termin','BR','C',false);

// row table 
$y = $pdf->GetY();
$x = $pdf->GetX();
$MCwidth = 130;

$product = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Revitalisasi Gedung Revitalisasi';
$McH = strlen($product) > 80 ? 5 : 10;

$pdf->Cell(10,10,'1','BLR', 0,'C');
$pdf->MultiCell($MCwidth,$McH,$product.strlen($product),'BR','L',false);
$pdf->SetXY($x + $MCwidth +10, $y);
$pdf->Cell(50,10,'200000000','BR',0,'R');
$pdf->Ln(10);

$pdf->Cell(140,5,'Harga Jual / Penggantian','BLR',0,'L');
$pdf->Cell(50,5,'200000000','BR',0,'R');
$pdf->Ln(5);
$pdf->Cell(140,5,'Dikurangi Potongan Harga','BLR',0,'L');
$pdf->Cell(50,5,'200000000','BR',0,'R');
$pdf->Ln(5);
$pdf->Cell(140,5,'Dikurangi Uang Muka','BLR',0,'L');
$pdf->Cell(50,5,'200000000','BR',0,'R');
$pdf->Ln(5);
$pdf->Cell(140,5,'Dasar Pengenaan Pajak','BLR',0,'L');
$pdf->Cell(50,5,'200000000','BR',0,'R');
$pdf->Ln(5);
$pdf->Cell(140,5,'PPN = 10% x Dasar Pengenaan Pajak','BLR',0,'L');
$pdf->Cell(50,5,'200000000','BR',0,'R');
$pdf->Ln(5);
$pdf->Cell(140,5,'Total PPnBM (Pajak Penjualan Barang Mewah)','BLR',0,'L');
$pdf->Cell(50,5,'200000000','BR',0,'R');
$pdf->Ln(5);
$kata = 'Sesuai dengan ketentuan yang berlaku, Direktorat Jenderal Pajak mengatur bahwa Faktur Pajak ini telah ditandatangani secara elektronik sehingga tidak diperlukan tanda tangan basah pada Faktur Pajak ini.';
$pdf->setKata2($kata,120,10,50,10,4);
$pdf->Ln(5);
// ------------------- TTD ---------------//
$pos = 150;
$kata = 'JAKARTA PUSAT, 30 Maret 2017';
$pdf->setKata2($kata,90,$pos,50,10,5);
$pdf->Ln(1);
/*$pdf->Image('MAT+TTD.jpg', 10, null, 40, 30);
$start_x = $pdf->GetX();
$start_y = $pdf->GetY();
$pdf->SetXY($start_x + 40 + 2, $start_y);*/
$pdf->Image('MAT+TTD.jpg', $pos, null, 40, 30);

$kata = 'SUHERDI';
$pdf->setKata2($kata,90,$pos,50,5,5);

/*$kata = 'Finance & GA Director';
$pdf->setKata2($kata,90,$pos,50,5,5);*/
// ------------------- TTD ---------------//

$pdf->Output();
OCILogOff($conn);
?>



