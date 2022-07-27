<?php

namespace app\Controllers;

require_once 'app/Models/Empresas.php';

use app\Models\Empresas;

class EmpresasController {

	protected $empresa;

	public function __construct(){  

		 $this->empresa= new Empresas();
	}

	public function index(){
		return $this->empresa->index();
	}

	public function store($json){
		return $this->empresa->store($json);
	}

	public function show($id){
		return $this->empresa->show($id);
	}

	public function delete($id){
		return $this->empresa->delete($id);
	}
}

?>