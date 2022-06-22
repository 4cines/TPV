<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Ticket extends Connection 
{
	public function index($mesa){
		
		$query = "SELECT precios.precio_base AS precio_base, productos.nombre AS nombre, productos.id AS id, productos.imagen_url AS imagen_url, productos_categorias.nombre AS categoria  FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id INNER JOIN productos ON precios.producto_id = productos.id INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id WHERE tickets.venta_id IS NULL AND tickets.activo = 1 AND mesa_id = $mesa";
		
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}

	public function index($preciobase){
		
		$query = "SELECT SUM(tickets.precio_id) FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id WHERE tickets.mesa_id = $mesa AND tickets.venta_id IS NULL AND tickets.activo = 1"
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}
}

?>