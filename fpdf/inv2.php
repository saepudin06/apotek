<?php

require('fpdf181/fpdf.php');
require('invClassExtend.php');


$pdf = new invoiceall();
$pdf->AddPage();
$pdf->Ln(10);

$invoice_num = '098908709890-201701';
// buat nampilin npwp/pkp
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 10, "NOMOR");
$pdf->SetFont('');
$pdf->Cell(5, 10, " : ", 0, 0);
$pdf->Cell(30, 10, $invoice_num, 0, 0);
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 10, "Jakarta, 27 September 2016");
$pdf->Ln(10);

$pdf->Cell(30, 10, "Kepada Yth,");
$pdf->Ln(5);
$pdf->Cell(30, 10, "SGM SSO");
$pdf->Ln(5);
$pdf->Cell(30, 10, "PT TELEKOMUNIKASI INDONESIA Tbk.");
$pdf->Ln(5);
$pdf->Cell(30, 10, "Jl. Japati No. 1 Bandung");

$pdf->Ln(10);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 10, "Perihal");
$pdf->SetFont('');
$pdf->Cell(5, 10, " : ", 0, 0);
$kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Telkom Triwulan 1 2016';
$pdf->setKata2($kata,90,35,50,10,5);
$pdf->Ln(10);

$kata = 'Dengan Hormat, ';
$pdf->setKata2($kata,90,10,50,10,5);
$kata = 'Menunjuk kontrak perjanjian pengadaan revitalisasi gedung Telkom Triwulan 1 Tahun 2016 Nomor : 098908709890-201701 / 098908709890-201701 Tanggal 25 Februari 2016 ';
$pdf->setKata2($kata,120,10,50,10,5);
$kata = 'bersama ini disampaikan tagihan tersebut sebagai berikut : ';
$pdf->setKata2($kata,120,10,50,10,5);
$pdf->Ln(5);
$curr_type = 'Rp.';
// Merubah //
$y = $pdf->GetY();
$pdf->SetFillColor(245, 233, 222);
$pdf->SetFontSize(7);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.1);
$position = 1;
$positionTxt = $position + 2;
$pdf->Rect($x+$position, $y+1, 180, 18);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 10, '  Nilai Tagihan', $x+$positionTxt); 
$pdf->Cell(5, 10, $curr_type,0,0,'R');   
$pdf->Cell(50, 10, number_format(20000000,2, '.', ','), 0, 0, 'R');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 10, '  PPN ', $x+$positionTxt); 
$pdf->Cell(20, 10, '10%',0,0,'R');   
$pdf->Cell(10, 10, 'X',0,0,'R');   
$pdf->Cell(10, 10, $curr_type,0,0,'R');   
$pdf->Cell(50, 10, number_format(20000000,2, '.', ',').'   ', 0, 0, 'R');
$pdf->Cell(5, 10, $curr_type,0,0,'R');   
$pdf->Cell(50, 10, number_format(2000000,2, '.', ','), 0, 0, 'R');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 10, '  Total', $x+$positionTxt); 
$pdf->Cell(5, 10, $curr_type,0,0,'R');   
$pdf->Cell(50, 10, number_format(22000000,2, '.', ','), 0, 0, 'R');
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 10, 'Terbilang', 10); 
$pdf->Cell(3, 10, " : ", 0, 0);
$pdf->SetFont(''); 
$kata = '# Dua Puluh Dua Juta Rupiah ';
$pdf->setKata2($kata,90,30,50,10,5);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 9);
$kata = 'Untuk pembayaran tagihan tersebut diatas dapat di transfer ke rekening PT. Graha Sarana Duta di Mandiri Wisma Alia ACC:123-0098-158-51-4, bukti transfer dan bukti potong pph pasal 23 agar dikirim kepada kami pada kesempatan pertama.';
$pdf->setKata2($kata,120,10,50,10,5);
$pdf->Ln(10);
$kata = 'Demikian disampaikan atas perhatian dan kerjasamanya kami ucapkan terima kasih';
$pdf->setKata2($kata,120,10,50,10,5);
$pdf->Ln(10);

$pos = 10;
$kata = 'Hormat Kami,';
$pdf->setKata2($kata,90,$pos,50,10,5);
$pdf->Ln(1);
$pdf->Image('MAT+TTD.jpg', $pos, null, 40, 30);

$kata = 'M. WISNU ADJI';
$pdf->setKata2($kata,90,$pos,50,5,5);

$kata = 'Finance & GA Director';
$pdf->setKata2($kata,90,$pos,50,5,5);


$pdf->SetX($x);

$pdf->setY($y+5);
// Merubah //

/*$curr_type = 'Rp.';
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
$kata = 'A/C : IDR : 123-0098-158-51-4';
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
// ------------------- TTD ---------------//*/


$pdf->Output();
OCILogOff($conn);
?>



