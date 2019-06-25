<?php

require('fpdf181/fpdf.php');
require('invClassExtend.php');


$pdf = new invoiceall();
$pdf->AddPage();
$pdf->Ln(10);

$invoice_num = '098908709890-201701';
// buat nampilin npwp/pkp
$pdf->SetFont('Arial', 'BU', 20);
$pdf->Cell(180,10, "RECEIPT  ",0,0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(180,10, "KWITANSI",0,0,'L');

$pdf->Ln(2);
// buat garis
$pdf->SetFont('Arial', '', 9);
$xLine = $pdf->GetX();
$yLine = $pdf->GetY()+8;
$pdf->SetLineWidth(0.5);
$pdf->Line($xLine, $yLine, $xLine+190, $yLine);
$pdf->Ln(10);

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
$pdf->Rect($x+$position, $y, 190, 125);

$totalll = 22000000;

$pos = 15;

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, " Receipt No. ");
$pdf->Cell(5, 12.5, " : ", 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 12.5, $invoice_num, 0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(115, 10, " Kwitansi No.");
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, " Receipt From ");
$pdf->Cell(5, 12.5, " : ", 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 12.5, 'PT TELEKOMUNIKASI INDINESIA Tbk.', 0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(115, 10, " Sudah terima dari ");
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, " The Sum Of ");
$pdf->Cell(5, 12.5, " : ", 0, 0);
$pdf->SetFont('Arial', 'i', 9);
$kata = '# Dua Puluh Dua Juta Rupiah # Dua Puluh Dua Juta Rupiah # Dua Puluh Dua Juta Rupiah # Dua Puluh Dua Juta Rupiah';
$pdf->setKata2($kata,70,75,50,12.5,4);
//$pdf->Cell(40, 12.5, 'PT TELEKOMUNIKASI INDINESIA Tbk.', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(115, 2, " Banyaknya Uang ");
$pdf->Ln(5);
 
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, " In Payment Of");
$pdf->Cell(5, 12.5, " : ", 0, 0);
$pdf->SetFont('Arial', '', 9);
$kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Revitalisasi Gedung Revitalisasi';
$pdf->setKata2($kata,70,75,50,12.5,4);
//$pdf->Cell(40, 12.5, 'PT TELEKOMUNIKASI INDINESIA Tbk.', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(115, 2, " Untuk Pembayaran ");
$pdf->Ln(10);

$pdf->Cell(60, 10, " Amount ");
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 12.5, " : ", 0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(5, 12.5, $curr_type, 'TBL');  
$pdf->Cell(40, 12.5, number_format($totalll,2,'.',',').'  ', 'TBR', 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 12.5,'Jakarta , 30 Maret 2017', 'T', 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'BI', 9);
$pdf->Cell(115, 10, " Jumlah");
$pdf->Ln();
$pdf->SetFont('');

// ------------------- TTD ---------------//
$pos = 145;
$pdf->Image('MAT+TTD.jpg', $pos, null, 40, 30);

$kata = 'M. WISNU ADJI';
$pdf->setKata2($kata,90,$pos,50,5,5,0,'C');

$kata = 'Finance & GA Director';
$pdf->setKata2($kata,90,$pos,50,5,5,0,'C');
// ------------------- TTD ---------------//

$pdf->SetFont('Arial', 'I', 9);
$kata = ' Payment by Cheque / Bilyet Giro is considered legal after being honored';
$pdf->setKata2($kata,100,10,50,12.5,4);
$kata = ' Pembayaran dengan Cek / Giro dianggap sah setelah diuangkan';
$pdf->setKata2($kata,100,10,50,12.5,4);

$pdf->Output();
OCILogOff($conn);
?>



