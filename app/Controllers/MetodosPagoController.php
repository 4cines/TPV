<?php

namespace app\Controllers;

require_once 'app/Models/MetodosPago.php';

use app\Models\MetodosPago;

class MetodosPagoController {

	protected $metodo_pago;

	public function __construct(){  

		 $this->metodo_pago= new MetodosPago();
	}

	public function index(){
		return $this->metodo_pago->index();
	}

	public function store($id, $nombre){
		return $this->metodo_pago->store($id, $nombre);
	}

	public function show($id){
		return $this->metodo_pago->show($id);
	}

	public function delete($id){	
		return $this->metodo_pago->delete($id);
	}
}

?>