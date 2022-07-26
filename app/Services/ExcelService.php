<?php

namespace app\Services;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;

class ExcelService {

	public function exportSaleToExcel($sale, $products){

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/ticket.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $spreedsheet->getActiveSheet()->setCellValue('A3', $sale['numero_ticket']);
        $spreedsheet->getActiveSheet()->setCellValue('D2', $sale['fecha_emision']);
        $spreedsheet->getActiveSheet()->setCellValue('D3', $sale['hora_emision']);
        $spreedsheet->getActiveSheet()->setCellValue('D6', $sale['precio_total_base']);
        $spreedsheet->getActiveSheet()->setCellValue('D8', $sale['precio_total_iva']);
        $spreedsheet->getActiveSheet()->setCellValue('D9', $sale['precio_total']);

        for($i = 0; $i < count($products); $i++){
            $spreedsheet->getActiveSheet()->insertNewRowBefore(6 + $i, 1); 
            $spreedsheet->getActiveSheet()->setCellValue('A' . ($i + 6), $products[$i]['nombre']);
            $spreedsheet->getActiveSheet()->setCellValue('B' . ($i + 6), $products[$i]['cantidad']);
            $spreedsheet->getActiveSheet()->setCellValue('C' . ($i + 6), $products[$i]['precio_base']);
            $spreedsheet->getActiveSheet()->setCellValue('D' . ($i + 6), '=B'.($i + 6).'*C'.($i + 6));
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tickets/ticket-'.$sale['numero_ticket'].'.xls');

        return $excel_file;
	}

    public function exportExcelToPdf($excel_file, $filename){
        $pdf = new Dompdf($excel_file);
        $pdf_file = $pdf->save($filename.".pdf");

        return $pdf_file;
    }

    public function exportTableToExcel($table, $products){

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/table.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $letter = 'A';

        foreach($products[0] as $key => $value){
            $spreedsheet->getActiveSheet()->setCellValue(strtoupper($letter) . '1', $key);
            ++$letter;
        }

        for($i = 0; $i < count($products); $i++){
           
            $spreedsheet->getActiveSheet()->insertNewRowBefore(2 + $i, 1);
            $letter = 'A';

            foreach ($products[$i] as $key => $value) {
                $spreedsheet->getActiveSheet()->setCellValue($letter . ($i + 2), $products[$i][$key]);
                ++$letter;
            }
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tables/table-'.$table.'.xls');
    }

    public function exportSalesTableToExcel($table, $sale){

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/table.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $letter = 'A';

        foreach($sale[0] as $key => $value){
            $spreedsheet->getActiveSheet()->setCellValue(strtoupper($letter) . '1', $key);
            ++$letter;
        }

        for($i = 0; $i < count($sale); $i++){
           
            $spreedsheet->getActiveSheet()->insertNewRowBefore(2 + $i, 1);
            $letter = 'A';

            foreach ($sale[$i] as $key => $value) {
                $spreedsheet->getActiveSheet()->setCellValue($letter . ($i + 2), $sale[$i][$key]);
                ++$letter;
            }
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tables/table-'.$table.'.xls');
    }

}

?>