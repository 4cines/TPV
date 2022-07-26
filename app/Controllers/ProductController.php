<?php

namespace app\Controllers;

require_once 'app/Models/Product.php';
require_once 'app/Services/ExcelService.php';

use app\Models\Product;
use app\Services\ExcelService;

class ProductController {

	protected $producto;

	public function __construct(){  

		$this->producto = new Product();
	}

	public function indexbycategory($categoria){

		return $this->producto->indexbycategory($categoria);
	}

	public function nombre($categoria){
		return $this->producto->nombre($categoria);
	}

	public function index(){
		return $this->producto->index();
	}

	public function store($id, $nombre, $categoria_id, $imagen_url){
		return $this->producto->store($id, $nombre, $categoria_id, $imagen_url);
	}

	public function lastproduct(){
		return $this->producto->lastproduct();
	}

	public function show($id){
		return $this->producto->show($id);
	}

	public function delete($id){
		return $this->producto->delete($id);
	}

	public function exportAllProductsToExcel(){

		$excel_service = new ExcelService();

		$products = $this->producto->index();
		
		$excel_service->exportTableToExcel('productos', $products);
	}
}

?>