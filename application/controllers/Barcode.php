<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once('barcodegen/class/BCGFontFile.php');
require_once('barcodegen/class/BCGColor.php');
require_once('barcodegen/class/BCGDrawing.php');
require_once('barcodegen/class/BCGcode128.barcode.php');


class Barcode extends CI_Controller
{

    function __construct() {

        parent::__construct();
        $this->load->helper(array('url','download'));   
     
    }

    function index() {
        check_login();
    }

    function generate_barcode() {

        $text = $this->input->get('text');
        $scale=6; 
        $fontsize=18; 
        $thickness=30;
        $dpi=72;

        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $drawException = null;

        try {
            $code = new BCGcode128(); // kalo pake yg code39, klo yg lain mesti disesuaikan
            $code->setScale($scale); // Resolution
            $code->setThickness($thickness); // Thickness
            $code->setForegroundColor($color_black); // Color of bars
            $code->setBackgroundColor($color_white); // Color of spaces
            $code->setFont(0); // Font (or 0)
            $code->parse($text); // Text

        } catch(Exception $exception) {
            $drawException = $exception;
        }

        /* Here is the list of the arguments
        1 - Filename (empty : display on screen)
        2 - Background color */
        $drawing = new BCGDrawing('', $color_white);
        if($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setDPI($dpi);
            $drawing->setBarcode($code);
            $drawing->draw();
        }

        // ini cuma labeling dari sisi aplikasi saya, penamaan file menjadi png barcode.
        $filename_img_barcode = $text.'.png';
        // folder untuk menyimpan barcode
        // $drawing->setFilename( FCPATH . UPLOAD_REAL_PATH .'barcode/'. $filename_img_barcode);
        $drawing->setFilename('./application/third_party/uploads/barcode/'. $filename_img_barcode);
        // proses penyimpanan barcode hasil generate
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

        // return $filename_img_barcode;
        return force_download('./application/third_party/uploads/barcode/'. $filename_img_barcode, NULL);
    }

}