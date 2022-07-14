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

        public function store($id, $numero, $ubicacion, $pax){

            if(!empty){
                $query =  "INSERT mesas SET id = $id, numero = $numero, ubicacion = $ubicacion, pax = $pax";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
                $id = $this->pdo->lastInsertId();

            } else{
                $query =  "UPDATE mesas SET id = $id, numero = $numero, ubicacion = $ubicacion, pax = $pax";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
                $id = $this->pdo->lastInsertId();

            }
		
                

                return "ok";
	}
        

}
?>