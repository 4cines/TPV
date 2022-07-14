<?php

namespace app\Controllers;

require_once 'app/Models/Ventas.php';

use app\Models\Ventas;

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

	public function newTicketNumber($last_ticket_number){
		if(strpos(end($last_ticket_number), date('ymd')) !== false){
				return end($last_ticket_number) + 1;
			} else {
				return date('ymd').'0001';
			}
		return $this->ventas-> newTicketNumber($last_ticket_number);
	}	

	public function timeservice($charge_ticket_id, $first_product){
		return $this->ventas->timeservice($charge_ticket_id, $first_product);
	}	
}	

?>
