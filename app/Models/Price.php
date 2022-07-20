<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Price extends Connection 
{
    public function store($tipo_iva, $precio_base, $new_product_id){
        if(empty($id)){
            $query =  "INSERT INTO precios (producto_id, iva_id, precio_base, vigente, activo, creado, actualizado) VALUES ($new_product_id, $tipo_iva, $precio_base, 1, 1, NOW(), NOW())";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();
        
            $query =  "SELECT * FROM precios WHERE id=".$this->pdo->lastInsertId();

        } else{
        }

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function delete($id){
    
        $query =  "UPDATE precios SET activo = 0, actualizado = NOW() WHERE producto_id = $id";
        
               
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return "ok";
    }
}

?>