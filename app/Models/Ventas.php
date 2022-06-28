<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Ventas extends Connection 
{
	public function index(){
		
        $query =  "SELECT * FROM ventas WHERE activo = 1 ";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public function numero($venta){
		
        $query =  "SELECT * FROM ventas INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id INNER JOIN mesas ON ventas.mesa_id = mesas.id WHERE ventas.activo = 1 AND ventas.id = $venta";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    public function productos($mesa){
		
        $query =  "SELECT productos.imagen_url AS imagen_url, tickets.cantidad AS cantidad, precios.precio_base AS precio_base, productos.nombre AS nombre, tickets.mesa_id as mesa FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id INNER JOIN productos ON precios.producto_id = productos.id INNER JOIN mesas ON tickets.mesa_id = mesas.id WHERE tickets.activo=1 AND tickets.mesa_id = $mesa";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>