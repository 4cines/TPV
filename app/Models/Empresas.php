<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Empresas extends Connection 
{
	public function index(){
		
        $query =  "SELECT * FROM empresas WHERE activo = 1";
                        
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

        public function store($json){

                if(empty($json->id)){
                    $query =  "INSERT INTO empresas (razon_social, nombre_comercial, cif, domicilio, telefono, correo_electronico, web, activo, creado, actualizado) VALUES ('$json->razon_social','$json->nombre_comercial', '$json->cif', '$json->domicilio', $json->telefono, '$json->correo_electronico', '$json->web', 1, NOW(), NOW())";
                            
                    $stmt = $this->pdo->prepare($query);
                    $result = $stmt->execute();
        
                    $query =  "SELECT * FROM empresas WHERE id=".$this->pdo->lastInsertId();
        
                } else{
                    $query =  "UPDATE empresas SET razon_social = '$json->razon_social', nombre_comercial = '$json->nombre_comercial', cif = '$json->cif', domicilio = '$json->domicilio', telefono = $json->telefono, correo_electronico = '$json->correo_electronico', web = '$json->web', actualizado = NOW() WHERE id = $json->id";
                            
                    $stmt = $this->pdo->prepare($query);
                    $result = $stmt->execute();
        
                    $query =  "SELECT * FROM empresas WHERE id = $json->id";
                }
        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
        
                return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function show($id){
    
                $query =  "SELECT * FROM empresas WHERE activo = 1 AND id = $id";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
        
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
                
            public function delete($id){
            
                $query =  "UPDATE empresas SET activo = 0, actualizado = NOW() WHERE id = $id";
                        
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute();
        
                return "ok";
            }
}
?>