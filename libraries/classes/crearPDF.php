<?php


require_once('..\classes\pdf\mpdf.php');

class M_pdf
{
    public $param;
    public $pdf;
    
    public function _construct($param = '"c","A4"')
    {
        $this->param = $param;
        $this->pdf = new mPDF($this->param);
    }
}
?>
