<?php

namespace app\Controllers;

require_once 'app/Models/ProductCategory.php';

use app\Models\ProductCategory;

class ProductCategoryController {

	protected $product_category;

	public function __construct(){  
		$this->product_category= new ProductCategory();
	}

	public function index(){
		return $this->product_category->index();
	}

	public function todaslascategorias(){
		return $this->product_category->todaslascategorias();
	}

	public function filtro(){
		return $this->product_category->filtro();
	}

	public function store($id, $nombre, $image_url){
		return $this->product_category->store($id, $nombre, $image_url);
	}

	public function show($id){
		return $this->product_category->show($id);
	}

	public function delete($id){
		return $this->product_category->delete($id);
	}
}

?>