<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
  
    use app\Controllers\TicketController;
    use app\Controllers\TableController;

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
                $tableState = $table->updateState($json->table_id, 0);

                $response = array(
                    'status' => 'ok',
                    'newProduct' => $newProduct,
                    'total' => $totalPrice,
                );

                echo json_encode($response);

                break;

            case 'deleteProduct':
                
                $ticket = new TicketController();

                $deleteProduct = $ticket->deleteProduct($json->ticket_id);

                $response = array(
                    'status' => 'ok',
                    'deleteProduct' => $deleteProduct,
                );

                echo json_encode($response);

                break;
        }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    


?>