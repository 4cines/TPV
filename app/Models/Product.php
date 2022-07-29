<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Product extends Connection 
{
	public function indexbycategory($categoria){
        
        $query =  "SELECT productos.id AS id ,productos.nombre, productos.imagen_url, precios.id AS precio_id , productos_categorias.nombre AS categoria, iva.tipo AS tipo_iva, precios.precio_base AS precio_base, productos.visible AS visible
        FROM productos 
        INNER JOIN precios ON precios.producto_id = productos.id 
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE productos.activo= 1 AND categoria_id = $categoria AND precios.vigente = 1 ";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public function filtro($filtro_categoria, $visible){
        
        $query =  "SELECT productos.id AS id ,productos.nombre, productos.imagen_url, precios.id AS precio_id , productos_categorias.nombre AS categoria, iva.tipo AS tipo_iva, precios.precio_base AS precio_base, productos.visible AS visible
        FROM productos 
        INNER JOIN precios ON precios.producto_id = productos.id 
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE productos.activo= 1";

        if(!empty($filtro_categoria)){
            $query. "AND productos.categoria_id = $filtro_categoria";
        }if($visible == "false"){
            $query. "AND precios.vigente = 0";
        }else($visible == "true"){
            $query. "AND precios.vigente = 1"
        };

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public function nombre($categoria){
    
        $query =  "SELECT nombre FROM productos_categorias WHERE activo = 1 AND productos_categorias.id = $categoria";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function index(){
    
        $query =  "SELECT productos.id AS id, productos.nombre AS nombre, precios.id AS precio_id, productos.imagen_url, productos_categorias.nombre AS categoria, productos.visible AS visible, iva.tipo AS tipo_iva, precios.precio_base AS precio_base, productos_categorias.id AS idcat
        FROM productos 
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id 
        INNER JOIN precios ON precios.producto_id = productos.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE productos.activo = 1
        AND precios.vigente = 1";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($id, $nombre, $categoria_id, $image_url){

        if(empty($id)){
            
            $query =  "INSERT INTO productos (nombre, categoria_id, imagen_url, visible, activo, creado, actualizado) VALUES ('$nombre', $categoria_id, '$image_url', 1, 1, NOW(), NOW())";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
            $id = $this->pdo->lastInsertId();

        } else{
            $query =  "UPDATE productos SET nombre = '$nombre', categoria_id = $categoria_id, imagen_url = '$image_url', actualizado = NOW() WHERE id = $id";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
        }

        return $id;
	}

    public function show($id){

        $query =  "SELECT productos.id AS id, productos.nombre AS nombre, productos.imagen_url, productos_categorias.nombre AS categoria, productos_categorias.id AS categoria_id, productos.visible AS visible, iva.tipo AS tipo_iva, iva.id AS iva_id, precios.precio_base AS precio_base
        FROM productos 
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id 
        INNER JOIN precios ON precios.producto_id = productos.id
        INNER JOIN iva ON precios.iva_id = iva.id
        WHERE productos.activo = 1
        AND precios.vigente = 1
        AND productos.id = $id";
        
                
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