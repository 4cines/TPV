<?php

namespace app\Controllers;

require_once 'app/Models/TiposIva.php';

use app\Models\TiposIva;

class TiposIvaController {

	protected $tipoiva;

	public function __construct(){  

		$this->tipoiva= new TiposIva();
	}

    public function index(){
        return $this->tipoiva->index();
    }

	public function store($id, $tipo, $vigente){
		return $this->tipoiva->store($id, $tipo, $vigente);
	}

	public function show($id){
		return $this->tipoiva->show($id);
	}

	public function delete($id){		
		return $this->tipoiva->delete($id);
	}
}

?>