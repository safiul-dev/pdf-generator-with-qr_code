<?php
require_once 'dompdf/autoload.inc.php'; 
use Dompdf\Dompdf; 
require 'qrCodeGenerator.php';

class GeneratePdf  {

    public function process ($file_name="hi", $storage_path = 'pdfs', $content) 
    {

        $dompdf = new Dompdf(['chroot' => __DIR__]);

        $html = "
        <html>
        <head>
        <link type='text/css' href='pdf.css' rel='stylesheet' />
        </head>
        <body>
        $content
        </body>
        </html>";
        $customSize = [0.0, 0.0, 595.28, 244.8];
        $dompdf->setBasePath(__DIR__ . '/');
        $dompdf->loadHtml($html);
        $dompdf->setPaper($customSize); 
        $dompdf->render(); 
        $output = $dompdf->output();
        $link = "$storage_path/$file_name.pdf";
        file_put_contents($link, $output);
        return $link;
    }
}


$qr_code = new QrCodeGenerator();
$pdf = new GeneratePdf();
$html = '';
for($i = 0; $i < 20; $i++) {
  $html .= "<div class='page'>
  <div class='image-div'>
    <img src=". $qr_code->generate("http://localhost:5000/$i") ."/>
  </div>
  <div class='content-div'>
    <p> supabase auth-helpers · last week</p>
    <p> Jhon nil</p>
    <p> Expire Date 01/05/2023 - 12:00 pm </p>
  </div>
  </div>";
}

echo $pdf->process(time() .'_'. uniqid() . $i, 'pdfs', $html);