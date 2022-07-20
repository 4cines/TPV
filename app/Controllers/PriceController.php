<?php

namespace app\Controllers;

require_once 'app/Models/Price.php';

use app\Models\Price;

class PriceController {

	protected $price;

	public function __construct(){  
		$this->price= new Price();
	}

    public function store($tipo_iva, $precio_base, $new_product_id){
		return $this->price->store($tipo_iva, $precio_base, $new_product_id);
	}

	public function delete($id){
		return $this->price->delete($id);
	}
}

?>