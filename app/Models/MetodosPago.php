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

    public function store($id, $nombre){

        if(empty($id)){
            $query =  "INSERT INTO metodos_pagos (nombre, activo, creado, actualizado) VALUES ('$nombre', 1, NOW(), NOW())";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query =  "SELECT * FROM metodos_pagos WHERE id=".$this->pdo->lastInsertId();

        } else{
            $query =  "UPDATE metodos_pagos SET nombre = '$nombre', actualizado = NOW() WHERE id = $id";
                    
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute();

            $query =  "SELECT * FROM metodos_pagos WHERE id = $id";
        }

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function show($id){
    
        $query =  "SELECT * FROM metodos_pagos WHERE activo = 1 AND id = $id";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
        
    public function delete($id){
    
        $query =  "UPDATE metodos_pagos SET activo = 0, actualizado = NOW() WHERE id = $id";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return "ok";
    }
}
?>