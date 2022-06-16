<?php

namespace app\Controllers;

class ProductCategoryController {

	public function index(){

        $categorias = [
            "1" => [
                "nombre" => "Tapas",
            ],
            "2" => [
                "nombre" => "Refrescos",
            ],
            "3" => [
                "nombre" => "Bebidas calientes",
            ]
        ];

        return $categorias;
	}
}

?>