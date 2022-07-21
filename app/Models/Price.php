<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Price extends Connection 
{
    public function compararPrecio($new_product_id, $iva_id, $precio_base){

        $query = "SELECT precio_base FROM precios WHERE precio_base = $precio_base AND producto_id = $new_product_id AND iva_id = $iva_id";
        
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($new_product_id, $iva_id, $precio_base){

        $query =  "UPDATE precios SET vigente = 0 WHERE producto_id = $new_product_id AND vigente = 1";
        
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        $query =  "INSERT INTO precios (producto_id, iva_id, precio_base, vigente, activo, creado, actualizado) VALUES ($new_product_id, $iva_id, $precio_base, 1, 1, NOW(), NOW())";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return 'ok';
    }
  
    public function delete($id){
    
        $query =  "UPDATE precios SET activo = 0, actualizado = NOW() WHERE producto_id = $id";
               
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return "ok";
    }
}

?>