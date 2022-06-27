<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class ProductCategory extends Connection 
{
	public function index()
	{

		$query =  "SELECT productos_categorias.id AS id, productos_categorias.nombre AS nombre, productos_categorias.imagen_url AS imagen_url FROM productos INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id WHERE productos_categorias.activo = 1 GROUP BY productos_categorias.id";
				
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>
