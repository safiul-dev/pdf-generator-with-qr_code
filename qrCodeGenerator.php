<?php
include 'qrcode/qrlib.php';
class QrCodeGenerator {

    public $path;
    public $file;

    public function __construct(string $saveDir = 'images/')
    {
        $this->path = $saveDir;
    }

    public function generate (
    string $link = "http://localhost:5000/", 
    $mode = 'P', 
    $pixel_Size = 6, 
    $frame_Size = 6
    ) {

        $this->file = $this->path. time() .uniqid().".png";
        QRcode::png($link, $this->file, $mode, $pixel_Size, $frame_Size);
        $data = file_get_contents($this->file);
        return 'data:image/' .'type'. ';base64,' . base64_encode($data);
    }
}