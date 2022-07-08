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

    public function productos($mesa){
		return $this->ventas->productos($mesa);
	}

	public function ingresosmediatotales($fecha){
		return $this->ventas->ingresosmediatotales($fecha);
	}

	public function chargeTicket($table_id, $metodo_pago, $totalPrice){
		return $this->ventas->chargeTicket($table_id, $metodo_pago, $totalPrice);

	}

}
?>
