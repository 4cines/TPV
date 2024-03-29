<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Ticket extends Connection 
{
	public function index($mesa){
		
		$query = "SELECT precios.precio_base AS precio_base, productos.nombre AS nombre, productos.id AS id, productos.imagen_url AS imagen_url, productos_categorias.nombre AS categoria, tickets.id AS ticket_id  FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id INNER JOIN productos ON precios.producto_id = productos.id INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id WHERE tickets.venta_id IS NULL AND tickets.activo = 1 AND mesa_id = $mesa";
		
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}

	
	public function total($mesa){
		
		$query = "SELECT ROUND(SUM(precios.precio_base), 2) AS base, ROUND(SUM(precios.precio_base * iva.multiplicador) ,2) AS total,  ROUND(SUM(precios.precio_base * iva.multiplicador) - SUM(precios.precio_base) ,2) AS total_iva, iva.tipo AS iva FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id INNER JOIN iva ON precios.iva_id = iva.id WHERE tickets.mesa_id = $mesa AND tickets.venta_id IS NULL AND tickets.activo = 1 GROUP BY iva.tipo";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
		
	}

	public function num_mesa($mesa){
		
		$query = "SELECT numero FROM mesas WHERE activo=1 AND id = $mesa";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
		
	}

	public function addProduct($price_id, $table_id)
    {

        $query =  "INSERT INTO tickets (mesa_id, precio_id, activo, creado, actualizado) VALUES (".$table_id.",".$price_id.", 1, NOW(), NOW())";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
        $id = $this->pdo->lastInsertId();

        $query =  "SELECT tickets.id AS id, productos.nombre AS nombre, precios.precio_base AS precio_base, productos.imagen_url
        AS imagen_url, productos_categorias.nombre AS categoria
        FROM tickets
        INNER JOIN precios ON tickets.precio_id = precios.id
        INNER JOIN productos ON precios.producto_id = productos.id
        INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
        WHERE tickets.id = ".$id;

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addFakeProduct($price_id, $table_id, $timestamp)
    {

        $query =  "INSERT INTO tickets (mesa_id, precio_id, activo, creado, actualizado) VALUES (".$table_id.",".$price_id.", 1, '$timestamp', '$timestamp')";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
        
    }


	public function deleteProduct($ticket_id)
    {

        $query =  "UPDATE tickets SET activo = 0, actualizado = NOW() WHERE tickets.id = $ticket_id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return 'ok';
    }

    public function deleteAllProducts($num_table)
    {

        $query =  "UPDATE tickets SET activo = 0, actualizado = NOW() WHERE mesa_id = $num_table AND venta_id IS NULL";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return 'ok';
    }

    public function updateTicket($table_id, $charge_ticket_id)
    {

        $query =  "UPDATE tickets SET venta_id = $charge_ticket_id WHERE mesa_id = $table_id AND venta_id IS NULL";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return 'ok';
    }
    
    public function firstproduct($charge_ticket_id){
        $query = "SELECT creado FROM tickets WHERE activo = 1 AND venta_id = $charge_ticket_id LIMIT 1";
        
        file_put_contents("fichero.txt", $query);

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getChartData($chart_data){

        switch($chart_data) {
            
            case 'best_dishes':
                $query = "SELECT COUNT(productos.nombre) AS producto, productos.nombre
                FROM tickets 
                INNER JOIN precios ON tickets.precio_id = precios.id
                INNER JOIN productos ON precios.producto_id = productos.id
                INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
                WHERE categoria_id = 1 OR categoria_id = 4
                GROUP BY productos.nombre ORDER BY COUNT(productos.nombre) DESC"; 

            case 'best_drinks':
                $query = " SELECT COUNT(productos.nombre) AS producto, productos.nombre
                FROM tickets 
                INNER JOIN precios ON tickets.precio_id = precios.id
                INNER JOIN productos ON precios.producto_id = productos.id
                INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
                WHERE categoria_id = 1 OR categoria_id = 4
                GROUP BY productos.nombre ORDER BY COUNT(productos.nombre) DESC";

            case 'best_categories':
                $query = "SELECT SUM(ventas.precio_total) AS data, productos_categorias.nombre AS labels
                FROM ventas
                INNER JOIN tickets ON ventas.id = tickets.venta_id
                INNER JOIN precios ON tickets.precio_id = precios.id
                INNER JOIN productos ON precios.producto_id = productos.id
                INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
                GROUP BY productos_categorias.nombre ORDER BY SUM(ventas.precio_total) DESC";
        }
    
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>