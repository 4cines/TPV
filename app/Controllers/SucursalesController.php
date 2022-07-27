<?php

namespace app\Controllers;

require_once 'app/Models/Sucursales.php';

use app\Models\Sucursales;

class SucursalesController {

	protected $sucursal;

	public function __construct(){  

		 $this->sucursal= new Sucursales();
	}

	public function index(){
		return $this->sucursal->index();
	}

	public function store($json){
		return $this->sucursal->store($json);
	}

	public function show($id){
		return $this->sucursal->show($id);
	}

	public function delete($id){
		return $this->sucursal->delete($id);
	}
}

?>