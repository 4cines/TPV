<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Product extends Connection 
{
	public function index($categoria){
        
        $query =  "SELECT productos.nombre, productos.imagen_url, precios.id AS precio_id FROM productos INNER JOIN precios ON precios.producto_id = productos.id WHERE productos.activo= 1 AND categoria_id = $categoria AND precios.vigente = 1 ";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public function nombre($categoria){
    
        $query =  "SELECT nombre FROM productos_categorias WHERE activo=1 AND productos_categorias.id = $categoria";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function paneladmin(){
    
        $query =  "SELECT productos.nombre AS nombre, productos_categorias.nombre AS categoria_id, productos.visible AS visible FROM productos 
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id WHERE productos.activo = 1 ";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
                
                

    public function store($id, $nombre, $categoria_id, $visible){
        if(empty($id)){
            $query =  "INSERT INTO productos (nombre, categoria_id, visible, activo, creado, actualizado) VALUES ('$nombre', $categoria_id, 1, 1, NOW(), NOW())";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query =  "SELECT productos.nombre AS nombre, productos_categorias.nombre AS categoria_id, productos.visible AS visible FROM productos 
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id 
            WHERE productos.activo = 1 AND productos.id = ".$this->pdo->lastInsertId();

        } else{
            $query =  "UPDATE productos SET nombre = '$nombre', categoria_id = $categoria_id, visible = $visible, actualizado = NOW() WHERE id = $id";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query =  "SELECT productos.nombre AS nombre, productos_categorias.nombre AS categoria_id, productos.visible AS visible FROM productos 
            INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id 
            WHERE productos.activo = 1 AND productos.id = $id";
        }

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function show($id){

        $query =  "SELECT productos.nombre AS nombre, productos_categorias.nombre AS categoria_id, productos.visible AS visible FROM productos 
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id 
        WHERE productos.activo = 1 AND productos.id = $id";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id){
    
        $query =  "UPDATE productos SET activo = 0, actualizado = NOW() WHERE id = $id";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return "ok";
    }
}

?>