<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Ticket extends Connection 
{
	public function index(){
		
        $query =  "SELECT SUM(tickets.precio_id) FROM tickets INNER JOIN precios ON tickets.precio_id = precios.id WHERE tickets.mesa_id = 7 AND tickets.venta_id IS NULL AND tickets.activo = 1";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>