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
}

?>