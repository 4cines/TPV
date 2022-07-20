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

	public function paneladmin(){
		return $this->producto->paneladmin();
	}

	public function store($id, $nombre, $categoria_id, $visible){
		return $this->productostore($id, $nombre, $categoria_id, $visible);
	}

	public function show($id){
		return $this->show($id);
	}

	public function delete($id){
		return $this->delete($id);
	}
}

?>