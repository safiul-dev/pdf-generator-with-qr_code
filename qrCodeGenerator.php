<?php
include 'qrcode/qrlib.php';
class QrCodeGenerator {

    public $path;
    public $file;

    public function __construct(string $saveDir)
    {
        $this->path = $saveDir;
    }

    public function generate (
    string $link = "http://localhost:5000/", 
    $mode = 'P', 
    $pixel_Size = 8, 
    $frame_Size = 8
    ) {

        $this->file = $this->path.uniqid().".png";
        QRcode::png($link, $this->file, $mode, $pixel_Size, $frame_Size);
        return $this->file;
    }
}