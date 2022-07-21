<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class ProductCategory extends Connection 
{
	public function index()
	{

		$query =  "SELECT productos_categorias.id AS id, productos_categorias.nombre AS nombre, productos_categorias.imagen_url, productos_categorias.imagen_url AS imagen_url FROM productos INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id WHERE productos_categorias.activo = 1 GROUP BY productos_categorias.id";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function todaslascategorias()
	{

		$query =  "SELECT id, nombre, imagen_url, activo FROM productos_categorias WHERE activo = 1";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function filtro()
	{

		$query =  "SELECT id, nombre, imagen_url FROM  productos_categorias WHERE activo = 1";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function store($id, $nombre, $image_url){

        if(empty($id)){
            $query =  "INSERT INTO productos_categorias (nombre, imagen_url, activo, creado, actualizado) VALUES ('$nombre', '$image_url', 1, NOW(), NOW())";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query =  "SELECT * FROM productos_categorias WHERE id=".$this->pdo->lastInsertId();

        } else{
            $query =  "UPDATE productos_categorias SET nombre = '$nombre', imagen_url = '$image_url', actualizado = NOW() WHERE id = $id";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query =  "SELECT * FROM productos_categorias WHERE id = $id";
        }

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
	}


	public function show($id){

		$query =  "SELECT * FROM productos_categorias WHERE activo = 1 AND id = $id";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function delete($id){

		$query =  "UPDATE productos_categorias SET activo = 0, actualizado = NOW() WHERE id = $id";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return "ok";
	}

}

?>
