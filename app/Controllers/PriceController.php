<?php

namespace app\Controllers;

require_once 'app/Models/Price.php';

use app\Models\Price;

class PriceController {

	protected $price;

	public function __construct(){  
		$this->price= new Price();
	}

    public function store($new_product_id, $iva_id, $precio_base){

		$isValid = $this->price->compararPrecio($new_product_id, $iva_id, $precio_base);

		if(empty($isValid)){
			return $this->price->store($new_product_id, $iva_id, $precio_base);
		}
	}

	public function delete($id){
		return $this->price->delete($id);
	}
}

?>
