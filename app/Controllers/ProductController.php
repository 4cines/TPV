<?php

namespace app\Controllers;

require_once 'app/Models/Product.php';

use app\Models\Product;

class ProductController {

	protected $producto;

	public function __construct(){  

		$this->producto = new Product();
	}

	public function index($categoria){

		return $this->producto->index($categoria);
	}

	public function nombre($categoria){
		return $this->producto->nombre($categoria);
	}
}

?>