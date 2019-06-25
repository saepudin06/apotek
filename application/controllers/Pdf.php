<?php defined('BASEPATH') OR exit('No direct script access allowed');

require('fpdf/fpdf.php');
require('fpdf/invClassExtend.php');

class Pdf extends CI_Controller
{

    function __construct() {

        parent::__construct();
        //$this->pathInvoice = 'images/invoice/';
        $this->pathInvoice = './application/third_party/uploads/invoice_signer/';
     
    }

    function index() {
        check_login();
    }

    function Invoice($account_num, $periode, $page){
        
        $this->load->model('invoice/invoice');
        $table = $this->invoice;
        
        $param['account_num'] = $account_num;
        $param['periode'] = $periode;
        
        $data = $table->getCustInfo($param);
        

        $param['invoice_num'] = $data[0]['invoice_num'];
        $table->setPrintSeq($param);
        $dataCust = $table->getCustInfo2($param);
        $kontrak = $table->getKontrak($param);
        
        if($dataCust[0]['kontrak_param'] == 'NO_DATA'){
                $kontrak_id = @$dataCust[0]['kontrak_param'];
        }else{
                $kontrak_id = @$dataCust[0]['kontrak_param'];
        }

        if($dataCust[0]['kontrak_date_param'] == 'NO_DATA'){
                $kontrak_sd = @$dataCust[0]['kontrak_date_param'];
        }else{
                $kontrak_sd = @$dataCust[0]['kontrak_date_param'];
        }
       
        $up = @$dataCust[0]['up'];
        $tgl = @$dataCust[0]['tgl2'];
        $real_inv_num = @$dataCust[0]['real_inv_num'];
        $perihal = @$dataCust[0]['perihal'];
        $signer = explode('|', $dataCust[0]['signer']);
        $bank = explode('|', $dataCust[0]['bank']);

        $pdf = new invoiceall();
        $pdf->AddPage();
        $pdf->Ln(10);
        $pdf->SetTitle('Invoice');
        $pdf->Ln();

        $pdf->SetTextColor(0);

        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(30, 10, "INVOICE");
        $pdf->SetFont('');
        $pdf->Ln(5);

        $invoice_num = @$data[0]['invoice_num'];
        // buat nampilin npwp/pkp
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 15, "Invoice Number");
        $pdf->SetFont('');
        $pdf->Cell(5, 15, " : ", 0, 0);
        $pdf->Cell(30, 15, $real_inv_num, 0, 0);
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
        $pdf->Rect($x+$position, $y, 100, 26);

        $pdf->SetFont('Arial', 'B', 8);
        $customer_name = @$data[0]['customer_name'];
        $pdf->setKata2($customer_name,50,$x+$positionTxt,65,10,4);
        $pdf->SetFont('Arial', '', 8);
        $pdf->setKata2(@$data[0]['address'],65,$x+$positionTxt,50,10,4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setKata2('UP : '.$up,35,$x+$positionTxt,50,10,4);

        $pdf->SetX($x);
        $pdf->setY($y+5);

        $pdf->Ln(20);

        // buat nampilin bulan tagih
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 15, "Project Name");
        $pdf->SetFont('');
        $pdf->Cell(5, 15, " : ", 0, 0);
        //$kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Telkom Triwulan 1 2016 '.$account_num .'-'.$periode;
        $kata = $perihal;


        $pdf->setKata2($kata,90,45,50,15,5);
        $pdf->Ln(1);

        // buat garis
        $xLine = $pdf->GetX();
        $yLine = $pdf->GetY()+8;
        $pdf->SetLineWidth(1);
        $pdf->Line($xLine, $yLine, $xLine+185, $yLine);
        $pdf->Ln(10);

                
        $curr_type = 'Rp.';
        $invoice_num = $real_inv_num;        
        //$invoice_num = @$data[0]['invoice_num'];        
        $customer_name = @$data[0]['customer_name'];        
        $address = @$data[0]['address'];        
        $jumlah = number_format(@$data[0]['invoice_mny'],2, '.', ',');
        $ppn = number_format(@$data[0]['invoice_tax'],2, '.', ',');
        $total = number_format(@$data[0]['tot_bill'],2, '.', ',');
        $txtInd = @$data[0]['invoice_txt_ind'];
        $txtEng = @$data[0]['invoice_txt_eng'];     
        $npwp = @$data[0]['npwp'];     


         $pdf->SetFont('Arial', 'B', 9);
         $deviasi='';

         // cell('length', 'margin top', txt, ?, ?, 'align')
        $pdf->Cell(60, 10, "Tagihan Bulan Ini ".$deviasi);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(50, 12.5, " : ", 0, 0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(5, 12.5, $curr_type);  
        $pdf->Cell(40, 12.5, $total, 0, 0, 'R');
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
        $pdf->Cell(30, 10, $jumlah, 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 10, 'PPN 10%'); 
        $pdf->Cell(5, 10, " : ", 0, 0);
        $pdf->SetFont('');
        $pdf->Cell(5, 10, $curr_type);   
        $pdf->Cell(30, 10, $ppn, 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 10, 'Terbilang'); 
        $pdf->Cell(5, 10, " : ", 0, 0);
        $pdf->SetFont(''); 
        $kata = '# '.$txtInd;
        $pdf->setKata2($kata,90,75,50,10,5);
        $pdf->SetFont('Arial', 'I', 8);
        $kata = '# '.$txtEng;
        //$pdf->setKata2($kata,90,75,50,10,5);

        // ------------------- BANK INFO ---------------//
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 8);
        $kata = 'Please make full payment to transfer to our rupiah or dollar account as per the following details :';
        $pdf->setKata2($kata,120,10,50,10,5);
        //$kata = 'Behalf of PT. Graha Sarana Duta';
        $kata = $bank[0];
        $pdf->setKata2($kata,90,10,50,10,5);
        $kata = 'Mandiri Wisma Alia';
        $pdf->setKata2($kata,90,10,50,10,5);
        //$kata = 'ACC : IDR : 123-0098-158-51-4';
        $kata = 'ACC : '.$bank[1].' : '.$bank[2];
        $pdf->setKata2($kata,90,10,50,10,5);
        $pdf->Ln(10);
        // ------------------- BANK INFO ---------------//

        // ------------------- TTD ---------------//
        $pos = 150;
        //$kata = 'Jakarta 01 Maret 2017';
        $kata = 'Jakarta '.$tgl;
        $pdf->setKata2($kata,90,$pos,50,10,5);
        $pdf->Ln(20);

        /*$signature = 'signer/MAT+TTD.jpg';
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);*/

        //$kata = 'M. WISNU ADJI';
        $kata = $signer[0];
        $pdf->setKata2($kata,90,$pos,50,5,5);

        //$kata = 'Finance & GA Director';
        $kata = $signer[1];
        $pdf->setKata2($kata,90,$pos,50,5,5);
        // ------------------- TTD ---------------//

        //2
   
        $pdf->AddPage();
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(15, 10, "NOMOR");
        $pdf->SetFont('');
        $pdf->Cell(5, 10, " : ", 0, 0);
        $pdf->Cell(30, 10, $invoice_num, 0, 0);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 10, "Jakarta, ".$tgl);
        $pdf->Ln(10);

        $pdf->Cell(30, 10, "Kepada Yth,");
        $pdf->Ln(5);
        $pdf->Cell(30, 10, @$data[0]['account_name']);
        $pdf->Ln(5);
        $pdf->Cell(30, 10, $customer_name);
        $pdf->Ln(5);
        $pdf->Cell(30, 10, $address);

        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 10, "Perihal");
        $pdf->SetFont('');
        $pdf->Cell(5, 10, " : ", 0, 0);
        //$kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Telkom Triwulan 1 2016';
        $kata = $perihal;
        $pdf->setKata2($kata,90,35,50,10,5);
        $pdf->Ln(10);

        $kata = 'Dengan Hormat, ';
        $pdf->setKata2($kata,90,10,50,10,5);
        $kata = 'Menunjuk kontrak perjanjian pengadaan '.$perihal.' Nomor : '.$kontrak_id.' Tanggal '.$kontrak_sd;
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
        $pdf->Cell(50, 10, $jumlah, 0, 0, 'R');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 10, '  PPN ', $x+$positionTxt); 
        $pdf->Cell(20, 10, '10%',0,0,'R');   
        $pdf->Cell(10, 10, 'X',0,0,'R');   
        $pdf->Cell(10, 10, $curr_type,0,0,'R');   
        $pdf->Cell(50, 10, $jumlah.'   ', 0, 0, 'R');
        $pdf->Cell(5, 10, $curr_type,0,0,'R');   
        $pdf->Cell(50, 10, $ppn, 0, 0, 'R');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(120, 10, '  Total', $x+$positionTxt); 
        $pdf->Cell(5, 10, $curr_type,0,0,'R');   
        $pdf->Cell(50, 10, $total, 0, 0, 'R');
        $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(15, 10, 'Terbilang', 10); 
        $pdf->Cell(3, 10, " : ", 0, 0);
        $pdf->SetFont(''); 
        $kata = '# '.$txtInd;
        $pdf->setKata2($kata,90,30,50,10,5);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 9);
        $kata = 'Untuk pembayaran tagihan tersebut diatas dapat di transfer ke rekening '.$bank[0].' di Mandiri Wisma Alia ACC:'.$bank[2].', bukti transfer dan bukti potong pph agar dikirim kepada kami pada kesempatan pertama.';
        $pdf->setKata2($kata,120,10,50,10,5);
        $pdf->Ln(10);
        $kata = 'Demikian disampaikan atas perhatian dan kerjasamanya kami ucapkan terima kasih';
        $pdf->setKata2($kata,120,10,50,10,5);
        $pdf->Ln(10);

        $pos = 10;
        $kata = 'Hormat Kami,';
        $pdf->setKata2($kata,90,$pos,50,10,5);
        $pdf->Ln(20);

        /*$signature = 'signer/MAT+TTD.jpg';
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);*/

        //$kata = 'M. WISNU ADJI';
        $kata = $signer[0];
        $pdf->setKata2($kata,90,$pos,50,5,5);

        //$kata = 'Finance & GA Director';
        $kata = $signer[1];
        $pdf->setKata2($kata,90,$pos,50,5,5);


        $pdf->SetX($x);

        $pdf->setY($y+5);

        //3 faktur dihilangkan 

        //4
 
        $pdf->AddPage();
        $pdf->Ln(10);

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
        $pdf->Cell(40, 12.5, $customer_name, 0, 0, 'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(115, 10, " Sudah terima dari ");
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(60, 10, " The Sum Of ");
        $pdf->Cell(5, 12.5, " : ", 0, 0);
        $pdf->SetFont('Arial', 'i', 9);
        $kata = '# '.$txtInd;
        $pdf->setKata2($kata,70,75,50,12.5,4);
        //$pdf->Cell(40, 12.5, 'PT TELEKOMUNIKASI INDINESIA Tbk.', 0, 0, 'L');
        $posit = strlen($kata ) > 70 ? 2 : 10;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(115, $posit, " Banyaknya Uang ");
        $pdf->Ln(10);
         
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(60, 10, " In Payment Of");
        $pdf->Cell(5, 12.5, " : ", 0, 0);
        $pdf->SetFont('Arial', '', 9);
        //$kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Revitalisasi Gedung Revitalisasi';
        $kata = $perihal;
        if(strlen($kata) < 80){
            $posHW = 10;
        }else{
            $posHW = 2;
        }
        $pdf->setKata2($kata,70,75,50,12.5,4);
        //$pdf->Cell(40, 12.5, 'PT TELEKOMUNIKASI INDINESIA Tbk.', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(115, $posHW, " Untuk Pembayaran ");
        $pdf->Ln(10);

        $pdf->Cell(60, 10, " Amount ");
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(5, 12.5, " : ", 0, 0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(5, 12.5, $curr_type, 'TBL');  
        $pdf->Cell(40, 12.5, $total.'  ', 'TBR', 0, 'R');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(80, 12.5,'Jakarta ,'.$tgl, '', 0, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(115, 10, " Jumlah");
        $pdf->Ln();
        $pdf->SetFont('');

        // ------------------- TTD ---------------//
        $pos = 145;
        //$signature = 'signer/MAT+TTD.jpg';
       /* $signature = $signer[2];
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);*/
        $pdf->Ln(20);
        //$kata = 'M. WISNU ADJI';
        $kata = $signer[0];
        $pdf->setKata2($kata,90,$pos,50,5,5,0,'C');

        //$kata = 'Finance & GA Director';
        $kata = $signer[1];
        $pdf->setKata2($kata,90,$pos,50,5,5,0,'C');
        // ------------------- TTD ---------------//
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 9);
        $kata = ' Payment by Cheque / Bilyet Giro is considered legal after being honored';
        $pdf->setKata2($kata,100,10,50,12.5,4);
        $kata = ' Pembayaran dengan Cek / Giro dianggap sah setelah diuangkan';
        $pdf->setKata2($kata,100,10,50,12.5,4);

        $pdf->Output();
    }

    function InvoicePage1($account_num, $periode, $print){
        
        $this->load->model('invoice/invoice');
        $table = $this->invoice;
        
        $param['account_num'] = $account_num;
        $param['periode'] = $periode;

        $data = $table->getCustInfo($param);
        
        $pdf = new invoiceall();
        $pdf->AddPage();
        $pdf->Ln(10);
       
        $pdf->Ln();

        $pdf->SetTextColor(0);

        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(30, 10, "INVOICE");
        $pdf->SetFont('');
        $pdf->Ln(5);

        $invoice_num = @$data[0]['invoice_num'];
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
        $pdf->Rect($x+$position, $y, 100, 20);

        $pdf->SetFont('Arial', 'B', 8);
        $customer_name = @$data[0]['account_name'];
        $pdf->setKata2($customer_name,35,$x+$positionTxt,50,10,4);
        $pdf->SetFont('Arial', '', 8);
        $pdf->setKata2(@$data[0]['address'],80,$x+$positionTxt,50,10,4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->setKata2('UP : SGM SSO',35,$x+$positionTxt,50,10,4);

        $pdf->SetX($x);
        $pdf->setY($y+5);

        $pdf->Ln(15);

        // buat nampilin bulan tagih
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 15, "Project Name");
        $pdf->SetFont('');
        $pdf->Cell(5, 15, " : ", 0, 0);
        $kata = 'Tagihan Pekerjaan Pengadaan Revitalisasi Gedung Telkom Triwulan 1 2016 '.$account_num .'-'.$periode;


        $pdf->setKata2($kata,90,45,50,15,5);
        $pdf->Ln(1);

        // buat garis
        $xLine = $pdf->GetX();
        $yLine = $pdf->GetY()+8;
        $pdf->SetLineWidth(1);
        $pdf->Line($xLine, $yLine, $xLine+185, $yLine);
        $pdf->Ln(10);

                
        $curr_type = 'Rp.';
        $jumlah = @$data[0]['invoice_mny'];
        $ppn = @$data[0]['invoice_tax'];
        $total = @$data[0]['tot_bill'];
        $txtInd = @$data[0]['invoice_txt_ind'];
        $txtEng = @$data[0]['invoice_txt_eng'];

         $pdf->SetFont('Arial', 'B', 9);
         $deviasi='';

         // cell('length', 'margin top', txt, ?, ?, 'align')
        $pdf->Cell(60, 10, "Tagihan Bulan Ini ".$deviasi);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(50, 12.5, " : ", 0, 0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(5, 12.5, $curr_type);  
        $pdf->Cell(40, 12.5, number_format($total,2,'.',','), 0, 0, 'R');
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
        $pdf->Cell(30, 10, number_format($jumlah,2, '.', ','), 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 10, 'PPN 10%'); 
        $pdf->Cell(5, 10, " : ", 0, 0);
        $pdf->SetFont('');
        $pdf->Cell(5, 10, $curr_type);   
        $pdf->Cell(30, 10, number_format($ppn,2, '.', ','), 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 10, 'Terbilang'); 
        $pdf->Cell(5, 10, " : ", 0, 0);
        $pdf->SetFont(''); 
        $kata = '# '.$txtInd;
        $pdf->setKata2($kata,90,75,50,10,5);
        $pdf->SetFont('Arial', 'I', 8);
        $kata = '# '.$txtEng;
        //$pdf->setKata2($kata,90,75,50,10,5);

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

        $signature = 'signer/MAT+TTD.jpg';
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);

        $kata = 'M. WISNU ADJI';
        $pdf->setKata2($kata,90,$pos,50,5,5);

        $kata = 'Finance & GA Director';
        $pdf->setKata2($kata,90,$pos,50,5,5);
        // ------------------- TTD ---------------//

        if($print){
            $pdf->Output();
        }
    }

    function InvoicePage2($account_num, $periode, $print){


        $this->load->model('invoice/invoice');
        $table = $this->invoice;
        
        $param['account_num'] = $account_num;
        $param['periode'] = $periode;

        $data = $table->getCustInfo($param);
 
        $invoice_num = @$data[0]['invoice_num'];        
        $customer_name = @$data[0]['account_name'];        
        $address = @$data[0]['address'];        
        $jumlah = @$data[0]['invoice_mny'];
        $ppn = @$data[0]['invoice_tax'];
        $total = @$data[0]['tot_bill'];
        $txtInd = @$data[0]['invoice_txt_ind'];
        $txtEng = @$data[0]['invoice_txt_eng'];     
        
        $pdf = new invoiceall();
        $pdf->AddPage();
        $pdf->Ln(10);

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
        $pdf->Cell(30, 10, $customer_name);
        $pdf->Ln(5);
        $pdf->Cell(30, 10, $address);

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
        $pdf->Cell(50, 10, number_format($jumlah,2, '.', ','), 0, 0, 'R');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 10, '  PPN ', $x+$positionTxt); 
        $pdf->Cell(20, 10, '10%',0,0,'R');   
        $pdf->Cell(10, 10, 'X',0,0,'R');   
        $pdf->Cell(10, 10, $curr_type,0,0,'R');   
        $pdf->Cell(50, 10, number_format($jumlah,2, '.', ',').'   ', 0, 0, 'R');
        $pdf->Cell(5, 10, $curr_type,0,0,'R');   
        $pdf->Cell(50, 10, number_format($ppn,2, '.', ','), 0, 0, 'R');

        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(120, 10, '  Total', $x+$positionTxt); 
        $pdf->Cell(5, 10, $curr_type,0,0,'R');   
        $pdf->Cell(50, 10, number_format($total,2, '.', ','), 0, 0, 'R');
        $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(15, 10, 'Terbilang', 10); 
        $pdf->Cell(3, 10, " : ", 0, 0);
        $pdf->SetFont(''); 
        $kata = '# '.$txtInd;
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

        //$signature = 'signer/MAT+TTD.jpg';
        $signature = 'signer/MAT+TTD.jpg';
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);

        $kata = 'M. WISNU ADJI';
        $pdf->setKata2($kata,90,$pos,50,5,5);

        $kata = 'Finance & GA Director';
        $pdf->setKata2($kata,90,$pos,50,5,5);


        $pdf->SetX($x);

        $pdf->setY($y+5);

        if($print){
            $pdf->Output();
        }
    }

    function InvoicePage3($account_num, $periode, $print){
        
        $this->load->model('invoice/invoice');
        $table = $this->invoice;
        
        $param['account_num'] = $account_num;
        $param['periode'] = $periode;

        $data = $table->getCustInfo($param);
 
        $invoice_num = @$data[0]['invoice_num'];        
        $customer_name = @$data[0]['account_name'];        
        $address = @$data[0]['address'];        
        $jumlah = number_format(@$data[0]['invoice_mny'],2, '.', ',');
        $ppn = number_format(@$data[0]['invoice_tax'],2, '.', ',');
        $total = number_format(@$data[0]['tot_bill'],2, '.', ',');
        $txtInd = @$data[0]['invoice_txt_ind'];
        $txtEng = @$data[0]['invoice_txt_eng'];     
        $npwp = @$data[0]['npwp'];     

        $pdf = new invoiceall();
        $pdf->AddPage();
        $pdf->Ln(10);

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
        $pdf->Cell(50, $marginTop, $customer_name, 0, 0, 'L');

        $pdf->Ln(4);

        $pdf->Cell(15, $marginTop, ' Alamat', $x+$positionTxt); 
        $pdf->Cell(5, $marginTop, ':',0,0);   
        $kata = $address;
        $pdf->setKata2($kata,90,30,50,$marginTop,4);

        $pdf->Cell(15, $marginTop, ' NPWP', '0', 0); 
        $pdf->Cell(5, $marginTop, ':',0,0);   
        $pdf->Cell(50, $marginTop, $npwp, 0, 0, 'L');

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
        $pdf->Cell(50,10,$jumlah,'BR',0,'R');
        $pdf->Ln(10);

        $pdf->Cell(140,5,'Harga Jual / Penggantian','BLR',0,'L');
        $pdf->Cell(50,5,$jumlah,'BR',0,'R');
        $pdf->Ln(5);
        $pdf->Cell(140,5,'Dikurangi Potongan Harga','BLR',0,'L');
        $pdf->Cell(50,5,'0,00','BR',0,'R');
        $pdf->Ln(5);
        $pdf->Cell(140,5,'Dikurangi Uang Muka','BLR',0,'L');
        $pdf->Cell(50,5,'0,00','BR',0,'R');
        $pdf->Ln(5);
        $pdf->Cell(140,5,'Dasar Pengenaan Pajak','BLR',0,'L');
        $pdf->Cell(50,5,$jumlah,'BR',0,'R');
        $pdf->Ln(5);
        $pdf->Cell(140,5,'PPN = 10% x Dasar Pengenaan Pajak','BLR',0,'L');
        $pdf->Cell(50,5,$ppn,'BR',0,'R');
        $pdf->Ln(5);
        $pdf->Cell(140,5,'Total PPnBM (Pajak Penjualan Barang Mewah)','BLR',0,'L');
        $pdf->Cell(50,5,'0,00','BR',0,'R');
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
        $signature = 'signer/MAT+TTD.jpg';
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);

        $kata = 'SUHERDI';
        $pdf->setKata2($kata,90,$pos,50,5,5);

        /*$kata = 'Finance & GA Director';
        $pdf->setKata2($kata,90,$pos,50,5,5);*/
        // ------------------- TTD ---------------//

        if($print){
            $pdf->Output();
        }

    }

    function InvoicePage4($account_num, $periode, $print){
        
        $this->load->model('invoice/invoice');
        $table = $this->invoice;
        
        $param['account_num'] = $account_num;
        $param['periode'] = $periode;

        $data = $table->getCustInfo($param);
 
        $invoice_num = @$data[0]['invoice_num'];        
        $customer_name = @$data[0]['account_name'];        
        $address = @$data[0]['address'];        
        $jumlah = number_format(@$data[0]['invoice_mny'],2, '.', ',');
        $ppn = number_format(@$data[0]['invoice_tax'],2, '.', ',');
        $total = number_format(@$data[0]['tot_bill'],2, '.', ',');
        $txtInd = @$data[0]['invoice_txt_ind'];
        $txtEng = @$data[0]['invoice_txt_eng'];     
        $npwp = @$data[0]['npwp'];     



        $pdf = new invoiceall();
        $pdf->AddPage();
        $pdf->Ln(10);

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
        $pdf->Cell(40, 12.5, $customer_name, 0, 0, 'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(115, 10, " Sudah terima dari ");
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(60, 10, " The Sum Of ");
        $pdf->Cell(5, 12.5, " : ", 0, 0);
        $pdf->SetFont('Arial', 'i', 9);
        $kata = '# '.$txtInd;
        $pdf->setKata2($kata,70,75,50,12.5,4);
        //$pdf->Cell(40, 12.5, 'PT TELEKOMUNIKASI INDINESIA Tbk.', 0, 0, 'L');
        $posit = strlen($kata ) > 70 ? 2 : 10;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(115, $posit, " Banyaknya Uang ");
        $pdf->Ln(10);
         
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
        $pdf->Cell(40, 12.5, $total.'  ', 'TBR', 0, 'R');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(80, 12.5,'Jakarta , 30 Maret 2017', 'T', 0, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'BI', 9);
        $pdf->Cell(115, 10, " Jumlah");
        $pdf->Ln();
        $pdf->SetFont('');

        // ------------------- TTD ---------------//
        $pos = 145;
        $signature = 'signer/MAT+TTD.jpg';
        $signature = $this->pathInvoice.$signature;
        $pdf->Image($signature, $pos, null, 40, 30);

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

         if($print){
            $pdf->Output();
        }
    }

}