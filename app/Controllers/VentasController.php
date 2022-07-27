<?php

namespace app\Controllers;

require_once 'app/Models/Ventas.php';
require_once 'app/Services/ExcelService.php';
require_once 'app/Services/PdfService.php';

use app\Models\Ventas;
use app\Services\ExcelService;
use app\Services\PdfService;


class VentasController {

	protected $ventas;

	public function __construct(){  

		$this->ventas = new Ventas();
	}

	public function index($mesa,$fecha){
		return $this->ventas->index($mesa,$fecha);
	}

    public function numero($venta){
		return $this->ventas->numero($venta);
	}

	public function allsales(){
		return $this->ventas->allsales();
	}

    public function productos($venta){
		return $this->ventas->productos($venta);
	}

	public function ingresosmediatotales($fecha){
		return $this->ventas->ingresosmediatotales($fecha);
	}

	public function lastTicketNumber(){
		return $this->ventas->lastTicketNumber();
	}

	public function chargeTicket($table_id, $metodo_pago, $totalPrice, $new_ticket_number){
		return $this->ventas->chargeTicket($table_id, $metodo_pago, $totalPrice, $new_ticket_number);
	}

	public function chargeFakeTicket($table_id, $metodo_pago, $totalPrice, $new_ticket_number, $date, $time, $timestamp){
		return $this->ventas->chargeFakeTicket($table_id, $metodo_pago, $totalPrice, $new_ticket_number, $date, $time, $timestamp);
	}

	public function newTicketNumber($last_ticket_number){
		
		if(!empty($last_ticket_number) && strpos(end($last_ticket_number), date('ymd')) !== false){
			return end($last_ticket_number) + 1;
		} else {
			return date('ymd').'0001';
		}
	}	

	public function timeservice($charge_ticket_id, $first_product){
		return $this->ventas->timeservice($charge_ticket_id, $first_product);
	}	

	public function fakeTimeService($charge_ticket_id, $first_product, $timestamp){
		return $this->ventas->fakeTimeService($charge_ticket_id, $first_product, $timestamp);
	}

	public function getChartData($chart_data){
		return $this->ventas->getChartData($chart_data);
	}	

	public function exportSaleToExcel($sale_id){

		$excel_service = new ExcelService();

		$sale = $this->ventas->numero($sale_id);

		$products = $this->ventas->productos($sale_id);
		
		$excel_service->exportSaleToExcel($sale, $products);
	}

	public function exportAllSalesToExcel(){

		$excel_service = new ExcelService();

		$sale = $this->ventas->allsales();
		
		$excel_service->exportSalesTableToExcel('ventas', $sale);
	}

	public function exportSaleToPdf($sale_id){

		$sale = $this->ventas->numero($sale_id);
		$products = $this->ventas->productos($sale_id);

		$html =
            '<html>
				<head>
					<link rel="stylesheet" href="'.$_SERVER["DOCUMENT_ROOT"].'/assets/css/ticket.css">
				</head>
                <body>'.
				'<p style="font-size: 20px;" align="center"; "line-height:50%">Restaurantes Paquita</p>'.
				'<p style="font-size: 10px;" align="center";>Adress: Lorem Ipsum, 23-10</p>'.
				'<p style="font-size: 10px;" line-height:"20%" align="center">Tel: 666 000 555</p>'.
				'<p align="center">*************************</p>'.
                '<h1 style="font-size: 20px;" align="center">TICKET VENTA</h1>'.
                '<p style="font-size: 10px;">Numero de ticket: '.$sale['numero_ticket'].'</p>'.
                '<p style="font-size: 10px;">Fecha: '.$sale['fecha_emision'].'</p>'.
                '<p style="font-size: 10px;">Mesa: '.$sale['mesa'].'</p>'.

        $html .= 
            '<table>
                <tr>
                    <th>Cant</th>
                    <th>Descripción</th>
                    <th>Total</th>
                </tr>';

        foreach($products as $product){
            $html .=
            '<tr>
              <td style="font-size: 15px;">'.$product['cantidad'].'</td>
              <td style="font-size: 15px;">'.$product['nombre'].'</td>
              <td style="font-size: 15px;">'.$product['precio_base'].'</td>
            </tr>';
        }

        $html .=
			'</table>'.
			'<p style="font-size: 10px;" align="right">Base: '.$sale['precio_total_base'].' €</p>'.
			'<p style="font-size: 10px;" align="right">IVA: '.$sale['precio_total_iva'].' €</p>'.
			'<p style="font-size: 18px;" align="right">Total: '.$sale['precio_total'].' €</p>'.
			'</body></html>';
		
		$pdf_service = new PdfService();
		$pdf = $pdf_service->exportToPdf($html);

		file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/pdf/tickets/ticket-'.$sale['numero_ticket'].'.pdf', $pdf);
	}
}	

?>
