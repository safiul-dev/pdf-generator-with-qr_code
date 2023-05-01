<?php
require_once 'dompdf/autoload.inc.php'; 
use Dompdf\Dompdf; 
require 'qrCodeGenerator.php';

class GeneratePdf  {

    public function process ($file_name="hi", $storage_path = 'pdfs', $qr_code_scanner_text ="http://localhost:5000/") 
    {
        $qr_code = new QrCodeGenerator('qr_code_image/');
        $data = file_get_contents($qr_code->generate($qr_code_scanner_text));
        $base64 = 'data:image/' .'type'. ';base64,' . base64_encode($data);
        $dompdf = new Dompdf(['chroot' => __DIR__]);

        $html = "
        <html>
        <head>
        <link type='text/css' href='pdf.css' rel='stylesheet' />
        </head>
        <body>
        <table>
          <tr >
            <td class='color'>testing table</td>
            </tr>
          <tr>
           <td class='bold'>Testng header</td>
          </tr>
          <tr><img src=". $base64 ."/></tr>
        </table>
        </body>
        </html>";
        $dompdf->setBasePath(__DIR__ . '/');
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'latter'); 
        $dompdf->render(); 
        $output = $dompdf->output();
        file_put_contents("$storage_path/$file_name.pdf", $output);
    }
}

$pdf = new GeneratePdf();
$pdf->process(time() .'_'. uniqid(), 'pdfs', 'http://localhost:5000/');
