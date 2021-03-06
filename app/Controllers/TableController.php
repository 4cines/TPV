<?php

namespace app\Controllers;

require_once 'app/Models/Table.php';

use app\Models\Table;

class TableController {

	protected $table;

	public function __construct(){  

		$this->table = new Table();
	}

	public function index(){
		return $this->table->index();
	}

	public function updateState($table_id, $state){
		return $this->table->updateState($table_id, $state);
	}

	public function store($id, $numero, $ubicacion, $pax){
		return $this->table->store($id, $numero, $ubicacion, $pax);
	}

	public function show($id){
		return $this->table->show($id);
	}

	public function delete($id){		
		return $this->table->delete($id);
	}
}

?>