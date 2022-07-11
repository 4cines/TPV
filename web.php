<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/VentasController.php';
  
    use app\Controllers\TicketController;
    use app\Controllers\TableController;
    use app\Controllers\VentasController;

    header("Content-Type: application/json"); // lo que va a recibir es un JSON

    if(isset($_GET['data'])){
        $json = json_decode($_GET['data']);
    }else{
        $json = json_decode(file_get_contents('php://input')); // llamada de tipo fetch por POST ('php://... solo las llamadas fetch de Js pueden ser capturadas por el archivo)
    }
   
    if(isset($json->route)) {

        switch($json->route) {

            case 'addProduct':

                $ticket = new TicketController();
                $table = new TableController();

                $newProduct = $ticket->addProduct($json->price_id, $json->table_id);
                $totalPrice = $ticket->total($json->table_id);
                $table->updateState($json->table_id, 0);

                $response = array(
                    'status' => 'ok',
                    'newProduct' => $newProduct,
                    'total' => $totalPrice,
                );

                echo json_encode($response);

                break;

            case 'deleteProduct':
                
                $ticket = new TicketController();
                $table = new TableController();

                $ticket->deleteProduct($json->ticket_id);
                $totalPrice = $ticket->total($json->table_id);
                
                if($totalPrice['total'] == 0){
                    $table->updateState($json->table_id, 1);
                }
                
                $response = array(
                    'status' => 'ok',
                    'total' => $totalPrice,
                );

                echo json_encode($response);

                break;

            case 'deleteAllProducts':
            
                $ticket = new TicketController();
                $table = new TableController();

                $ticket->deleteAllProducts($json->table_id);
                $table->updateState($json->table_id, 1);

                $response = array(
                    'status' => 'ok',
                );

                echo json_encode($response);

                break;

            case 'chargeTicket':

                $table = new TableController();
                $ticket = new TicketController();
                $ventas = new VentasController();

                $totalPrice = $ticket->total($json->table_id);
                $last_ticket_number =  $ventas->lastTicketNumber();
                $new_ticket_number = $ventas->newTicketNumber($last_ticket_number);
                $charge_ticket_id = $ventas->chargeTicket($json->table_id, $json->metodo_pago, $totalPrice, $new_ticket_number);
                $ticket->updateTicket($json->table_id, $charge_ticket_id);
                $table->updateState($json->table_id, 1);     

                $response = array(
                    'status' => 'ok',
                );

                echo json_encode($response);

                break;
        }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    


?>