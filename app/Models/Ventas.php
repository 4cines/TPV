<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Ventas extends Connection 
{
	public function index($mesa, $fecha){

        if($mesa == null){
            $query =  "SELECT ventas.numero_ticket, ventas.id, ventas.hora_emision, mesas.id AS mesa, ventas.precio_total, ventas.fecha_emision FROM ventas INNER JOIN mesas ON ventas.mesa_id = mesas.id WHERE ventas.activo = 1 AND ventas.fecha_emision = '$fecha'";
        }else{
            $query =  "SELECT ventas.numero_ticket, ventas.id, ventas.hora_emision, mesas.id AS mesa, ventas.precio_total, ventas.fecha_emision FROM ventas INNER JOIN mesas ON ventas.mesa_id = mesas.id WHERE ventas.activo = 1 AND mesas.id = $mesa";
        }
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}    

    public function numero($venta){
		
        $query =  "SELECT * FROM ventas 
        INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id 
        INNER JOIN mesas ON ventas.mesa_id = mesas.id 
        WHERE ventas.activo = 1 AND ventas.id = $venta";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    public function productos($mesa){
		
        $query =  "SELECT productos.imagen_url AS imagen_url, COUNT(tickets.venta_id) AS cantidad, SUM(precios.precio_base) AS precio_base, productos.nombre AS nombre, mesas.numero AS mesa
        FROM tickets 
                INNER JOIN precios ON tickets.precio_id = precios.id 
                INNER JOIN productos ON precios.producto_id = productos.id 
                INNER JOIN mesas ON tickets.mesa_id = mesas.id 
                WHERE tickets.activo=1 
                AND tickets.mesa_id = $mesa
                GROUP BY productos.id";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function  ingresosmediatotales($fecha){
		
        $query =  "SELECT SUM(precio_total) AS total, (SELECT 
        ROUND(AVG(total),2) AS media
    FROM (SELECT
        SUM(precio_total) AS total, DAYNAME(fecha_emision) AS dia
    FROM
        ventas 
    WHERE activo =1
    GROUP BY fecha_emision) subconsulta
    
    WHERE dia = DAYNAME('2022-06-29')
    GROUP BY dia
    ) AS media FROM ventas WHERE activo = 1 AND fecha_emision = '$fecha'";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>