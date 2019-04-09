<?php
include_once('FSK_MemImage.php');

function createPDF($text1 = "", $text2 = "") {
      $rand = rand(100000, 999999);

      $base_image = "/home/fskgrup/public_html/image.jpg"; // replace the your path file image
      $create_path = "/home/fskgrup/public_html/output");
      $font = "assets/arial_font/arialbd.ttf"; // font family file path.
      $filename = $rand;
      $text = "TEXT 1  : $text1\n\r                     TEXT 2  : $text2"; //your text


      $jpg_image = imagecreatefromjpeg($base_image);
      $white = imagecolorallocate( $jpg_image, 0, 0, 0);

      imagettftext($jpg_image, 25, 0, 300, 1450, $white, $font, $text);  //text properties 
      imagejpeg($jpg_image, $create_path."/".$filename.jpg, 90); //new file save as path 90=>resolution
      imagedestroy($jpg_image); //clear image cache
      $pdf = new PDF_MemImage(); //NEW PDF
      $pdf->AddPage(); //New PDF page
      $content = file_get_contents(UPLOAD_DIR . "teminatlar/$filename.jpg"); //Created image contents
      $pdf->MemImage($content, 2, 2, 206, 293);  //position and put in pdf page 
      unlink(UPLOAD_DIR . $create_path."/".$filename.jpg); //remove temporarly image

      /*
        FPDF documentation: http://www.fpdf.org/en/doc/output.htm
        I: send the file inline to the browser. The PDF viewer is used if available.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local file with the name given by name (may include a path).
        S: return the document as a string.

       */

      $pdf->Output("F", $create_path . "/".$filename.pdf);
      unset($pdf);
      return $create_path."/".$filename.pdf;
}
