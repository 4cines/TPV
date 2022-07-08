<?php

namespace app\Controllers;

require_once 'app/Models/MetodosPago.php';

use app\Models\MetodosPago;

class MetodosPagoController {

	protected $metodos_pago;

	public function __construct(){  

		 $this->metodos_pago= new MetodosPago();
	}

	public function index(){

		return $this->metodos_pago->index();
	}
}

?>