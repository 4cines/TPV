<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Sucursales extends Connection 
{
	public function index(){
		
        $query =  "SELECT * FROM sucursales WHERE activo = 1";
                        
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

        public function store($json){

                if(empty($json->id)){
                    $query =  "INSERT INTO sucursales (nombre_comercial, domicilio, codigo_postal, telefono, correo_electronico, web, activo, creado, actualizado) VALUES ('$json->nombre_comercial', '$json->domicilio', '$json->codigo_postal', $json->telefono, '$json->correo_electronico', '$json->web', 1, NOW(), NOW())";
                            
                    $stmt = $this->pdo->prepare($query);
                    $result = $stmt->execute();
        
                    $query =  "SELECT * FROM sucursales WHERE id=".$this->pdo->lastInsertId();
        
                } else{
                    $query =  "UPDATE sucursales SET nombre_comercial = '$json->nombre_comercial', domicilio = '$json->domicilio', codigo_postal = '$json->codigo_postal', telefono = $json->telefono, correo_electronico = '$json->correo_electronico', web = '$json->web', actualizado = NOW() WHERE id = $json->id";
                            
                    $stmt = $this->pdo->prepare($query);
                    $result = $stmt->execute();
        
                    $query =  "SELECT * FROM sucursales WHERE id = $json->id";
                }
        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
        
                return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function show($id){
    
                $query =  "SELECT * FROM sucursales WHERE activo = 1 AND id = $id";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
        
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
                
            public function delete($id){
            
                $query =  "UPDATE sucursales SET activo = 0, actualizado = NOW() WHERE id = $id";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
        
                return "ok";
            }
}
?>