<?php

namespace app\Services;

require 'vendor/autoload.php';

use Dompdf\Dompdf;

class PdfService {

	public function exportToPdf($html)
    {
        
        $dompdf = new DOMPDF();
        $dompdf->setPaper('A7', 'portrait');
        $dompdf->set_option('defaultFont', 'Courier');
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();

        return $output;
	}
}

?>