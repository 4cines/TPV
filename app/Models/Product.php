<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Product extends Connection 
{
	public function index($categoria){
        
        $query =  "SELECT * FROM productos WHERE productos.activo= 1 AND categoria_id= $categoria";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>