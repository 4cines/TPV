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
                file_put_contents('error.txt', $totalPrice);
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
                $first_product = $ticket->firstproduct($charge_ticket_id);
                $ventas->timeservice($charge_ticket_id, $first_product['creado']);

                $response = array(
                    'status' => 'ok',
                );

                echo json_encode($response);

                break;

            case 'storeTable':

                $table = new TableController();
                $new_table = $table->store($json->id, $json->numero, $json->ubicacion, $json->pax); //datos del data (input en el .php)

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id, //la id no vale nada, value de .php es ""
                    'newElement' => $new_table // newElement no se modifica, se modifica la variable asociada (new_producto, new_categoria)
                );

                echo json_encode($response);

                break;
            
            case 'showTable':

                $table = new TableController();
                $table = $table->show($json->id);

                $response = array(
                    'status' => 'ok',
                    'element' => $table,
                );

                echo json_encode($response);

                break;
            
            case 'deleteTable':

                $table = new TableController();
                $table->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;

        }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    


?>