<?php

namespace app\Controllers;

require_once 'app/Models/Product.php';

use app\Models\Product;

class ProductController {

	protected $producto;

	public function __construct(){  

		$this->producto = new Product();
	}

	public function indexbycategory($categoria){

		return $this->producto->index($categoria);
	}

	public function nombre($categoria){
		return $this->producto->nombre($categoria);
	}

	public function index(){
		return $this->producto->index();
	}

	public function store($id, $nombre, $categoria_id){
		return $this->producto->store($id, $nombre, $categoria_id);
	}

	public function show($id){
		return $this->producto->show($id);
	}

	public function delete($id){
		return $this->producto->delete($id);
	}
}

?>