<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class MetodosPago extends Connection 
{
	public function index(){
		
                $query =  "SELECT nombre, id FROM metodos_pagos WHERE activo = 1";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>