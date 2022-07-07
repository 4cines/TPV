<?php

namespace app\Controllers;

require_once 'app/Models/MetodosPago.php';

use app\Models\MetodosPago;

class MetodosPago {

	protected $metodos_pago;

	public function __construct(){  

		// $this->metodos_pago= new ProductCategory();
	}

	public function index(){

		return $this->product_category->index();
	}
}

?>