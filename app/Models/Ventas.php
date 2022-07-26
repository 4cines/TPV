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
		
        $query =  "SELECT ventas.id, ventas.numero_ticket AS numero_ticket, ventas.precio_total_base AS precio_total_base, ventas.precio_total_iva AS precio_total_iva, ventas.precio_total AS precio_total, metodos_pagos.nombre AS metodo_pago, mesas.numero AS mesa, ventas.tiempo_servicio AS tiempo_servicio, ventas.fecha_emision AS fecha_emision, ventas.hora_emision AS hora_emision
        FROM ventas 
                INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id 
                INNER JOIN mesas ON ventas.mesa_id = mesas.id 
                WHERE ventas.activo = 1 AND ventas.id = $venta";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    public function allsales(){
		
        $query =  "SELECT ventas.id AS id, ventas.numero_ticket AS numero_ticket, ventas.precio_total AS precio_total, metodos_pagos.nombre AS metodo_pago, mesas.numero AS mesa FROM ventas
        INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id
        INNER JOIN mesas ON ventas.mesa_id = mesas.id WHERE ventas.activo = 1";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public function productos($venta){
		
        $query =  "SELECT productos.imagen_url AS imagen_url, COUNT(tickets.venta_id) AS cantidad, SUM(precios.precio_base) AS precio_base, productos.nombre AS nombre
        FROM tickets 
        INNER JOIN precios ON tickets.precio_id = precios.id 
        INNER JOIN productos ON precios.producto_id = productos.id 
        INNER JOIN mesas ON tickets.mesa_id = mesas.id 
		INNER JOIN ventas ON tickets.venta_id = ventas.id
        WHERE tickets.activo= 1 
		AND tickets.venta_id = $venta
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

    public function chargeTicket($table_id, $metodo_pago, $totalPrice, $new_ticket_number){
        
        $query =  "INSERT INTO ventas (numero_ticket, precio_total_base, precio_total_iva, precio_total, metodo_pago_id, mesa_id, fecha_emision, hora_emision, activo, creado, actualizado) 
        VALUES (".$new_ticket_number.",".$totalPrice['base'].",".$totalPrice['total_iva'].", ".$totalPrice['total'].",".$metodo_pago.",".$table_id.",CURDATE(), CURTIME(), 1, NOW(), NOW())";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
        $id = $this->pdo->lastInsertId();

        return $id;
    }

    public function chargeFakeTicket($table_id, $metodo_pago, $totalPrice, $new_ticket_number, $date, $time, $timestamp){
        
        $query =  "INSERT INTO ventas (numero_ticket, precio_total_base, precio_total_iva, precio_total, metodo_pago_id, mesa_id, fecha_emision, hora_emision, activo, creado, actualizado) 
        VALUES (".$new_ticket_number.",".$totalPrice['base'].",".$totalPrice['total_iva'].", ".$totalPrice['total'].",".$metodo_pago.",".$table_id.", '$date', '$time', 1, '$timestamp', '$timestamp')";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();
        $id = $this->pdo->lastInsertId();

        return $id;
    }

    public function lastTicketNumber(){
        $query = "SELECT numero_ticket FROM ventas ORDER BY id DESC LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function timeservice($charge_ticket_id, $first_product){
        $query =  "UPDATE ventas SET tiempo_servicio = TIMESTAMPDIFF(MINUTE, '" .$first_product ."', NOW()) WHERE ventas.id = $charge_ticket_id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return 'ok';
    }

    public function fakeTimeService($charge_ticket_id, $first_product, $timestamp){
        $query =  "UPDATE ventas SET tiempo_servicio = TIMESTAMPDIFF(MINUTE, '" .$first_product ."', '$timestamp') WHERE ventas.id = $charge_ticket_id";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return 'ok';
    }

    public function getChartData($chart_data){

        switch($chart_data) {
            
            case 'sales_by_hour':
                $query = "SELECT HOUR(hora_emision) AS labels , COUNT(*) AS quantity, SUM(precio_total) AS data
                FROM ventas
                GROUP BY HOUR(hora_emision) ORDER BY HOUR(hora_emision) ASC";

                break;

            case 'sales_by_day':
                $query = "SELECT DAYNAME(fecha_emision) AS labels, COUNT(*) AS quantity , SUM(precio_total) AS data
                FROM ventas GROUP BY DAYNAME(fecha_emision) 
                ORDER BY FIELD(labels, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')";

                break;

            case 'sales_by_month':
                $query = "SELECT MONTHNAME(fecha_emision) AS labels, COUNT(*) AS quantity, SUM(precio_total) AS data
                FROM ventas GROUP BY MONTHNAME(fecha_emision) 
                ORDER BY FIELD(labels, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre')";
       
                break;

            case 'sales_by_year':
                $query = "SELECT MONTHNAME(fecha_emision) AS labels, COUNT(*) AS quantity, SUM(precio_total) AS data
                FROM ventas GROUP BY  MONTHNAME(fecha_emision) ORDER BY  MONTHNAME(fecha_emision)";

                break;

            case 'popular_payment_methods':
                $query = "SELECT SUM(precio_total) AS data, metodos_pagos.nombre AS labels
                FROM ventas
                INNER JOIN metodos_pagos ON ventas.metodo_pago_id = metodos_pagos.id
                GROUP BY  metodos_pagos.nombre";

                break;

            case 'average_service_duration':
                 $query = "SELECT ROUND(AVG(ventas.tiempo_servicio),2) AS data, mesas.numero AS labels
                 FROM ventas 
                 INNER JOIN mesas ON ventas.mesa_id = mesas.id
                 GROUP BY mesas.numero";
     
                break;

            case 'sales_average_day':
                $query = "SELECT ROUND (AVG(precio_total), 2) AS data , DAYNAME(fecha_emision) AS labels 
                FROM ventas GROUP BY DAYNAME(fecha_emision) ORDER BY FIELD(labels, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')";
    
                break;

            case 'sales_average_month':
                $query = "SELECT ROUND (AVG(precio_total), 2) AS data , MONTHNAME(fecha_emision) AS labels 
                FROM ventas GROUP BY MONTHNAME(fecha_emision)ORDER BY FIELD(labels, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre')";
    
                break;

            case 'sales_average_year':
                $query = "SELECT ROUND (AVG(precio_total), 2) AS data , YEAR(fecha_emision) AS labels 
                FROM ventas GROUP BY YEAR(fecha_emision) ORDER BY YEAR(fecha_emision)";
    
                break;

        }
    
        
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>