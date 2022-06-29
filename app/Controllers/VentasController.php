<?php

namespace app\Controllers;

require_once 'app/Models/Ventas.php';

use app\Models\Ventas;

class VentasController {

	protected $ventas;

	public function __construct(){  

		$this->ventas = new Ventas();
	}

	public function index($fecha, $mesa){
		return $this->ventas->index($fecha, $mesa);
	}

    public function numero($venta){
		return $this->ventas->numero($venta);
	}

    public function productos($mesa){
		return $this->ventas->productos($mesa);
	}
}

?>
