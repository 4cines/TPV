<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Table extends Connection 
{
	public function index(){
		
                $query =  "SELECT * FROM mesas WHERE activo = 1";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


        public function updateState($table_id, $state){
		
                $query =  "UPDATE mesas SET estado = $state WHERE id = $table_id";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();

                return "ok";
	}
        
}
?>