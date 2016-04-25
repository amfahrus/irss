<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE) 
{
    require_once("./application/libraries/dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    //$dompdf->set_base_path('./assets/frontend/twbs/css/bootstrap.css');
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
?>
