<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/VentasController.php';
    require_once 'app/Controllers/TiposIvaController.php';
    require_once 'app/Controllers/MetodosPagoController.php';
    require_once 'app/Controllers/ProductCategoryController.php';
    require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/PriceController.php';
  
    use app\Controllers\TicketController;
    use app\Controllers\TableController;
    use app\Controllers\VentasController;
    use app\Controllers\TiposIvaController;
    use app\Controllers\MetodosPagoController;
    use app\Controllers\ProductCategoryController;
    use app\Controllers\ProductController;
    use app\Controllers\PriceController;
    


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
                $first_product = $ticket->firstproduct($charge_ticket_id);
                $ventas->timeservice($charge_ticket_id, $first_product['creado']);

                $response = array(
                    'status' => 'ok',
                );

                echo json_encode($response);

                break;

             // MESAS

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

         //// TIPOS IVA

            case 'storeTax':

                $tipoiva = new TiposIvaController();
                $new_iva = $tipoiva->store($json->id, $json->tipo, $json->vigente); //datos del data (input en el .php)
                
                $response = array(
                    'status' => 'ok',
                    'id' => $json->id, //la id no vale nada, value de .php es ""
                    'newElement' => $new_iva // newElement no se modifica, se modifica la variable asociada (new_producto, new_categoria)
                );

                echo json_encode($response);

                break;
            
            case 'showTax':

                $tipoiva = new TiposIvaController();
                $tipoiva = $tipoiva->show($json->id);

                $response = array(
                    'status' => 'ok',
                    'element' => $tipoiva,
                );

                echo json_encode($response);

                break;
            
            case 'deleteTax':

                $tipoiva = new TiposIvaController();
                $tipoiva->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;

         // METODOS DE PAGO

            case 'storePay':

                $metodo_pago = new MetodosPagoController();
                $new_pay = $metodo_pago->store($json->id, $json->nombre); //datos del data (input en el .php)
           
                $response = array(
                'status' => 'ok',
                'id' => $json->id, //la id no vale nada, value de .php es ""
                'newElement' => $new_pay // newElement no se modifica, se modifica la variable asociada (new_producto, new_categoria)
                );

                echo json_encode($response);

                break;
        
            case 'showPay':

                $metodo_pago = new MetodosPagoController();
                $metodo_pago = $metodo_pago->show($json->id);

                $response = array(
                    'status' => 'ok',
                    'element' => $metodo_pago,
                );

                echo json_encode($response);

                break;
        
            case 'deletePay':

                $metodo_pago = new MetodosPagoController();
                $metodo_pago->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;  


            //categorias
        
            case 'storeProductCategory':

                $product_category = new ProductCategoryController();

                if(isset($json->imagen_url->name)){
                    $image_url = "/upload/category/".$json->imagen_url->name;               
                }else{
                    $image_url = null;
                }

                $new_category = $product_category->store($json->id, $json->nombre, $image_url); //datos del data (input en el .php)
           
                $response = array(
                'status' => 'ok',
                'id' => $json->id, //la id no vale nada, value de .php es ""
                'newElement' => $new_category // newElement no se modifica, se modifica la variable asociada (new_producto, new_categoria)
                );

                echo json_encode($response);

                break;
        
            case 'showProductCategory':

                $product_category = new ProductCategoryController();
                $category = $product_category->show($json->id);

                $response = array(
                    'status' => 'ok',
                    'element' => $category,
                );

                echo json_encode($response);

                break;
        
            case 'deleteProductCategory':

            $product_category = new ProductCategoryController();
            $product_category->delete($json->id);
            

            $response = array(
                'status' => 'ok',
                'id' => $json->id
            );

            echo json_encode($response);

                break;  

            // PRODUCTOS

            case 'storeProduct':

                $product = new ProductController();
                $price = new PriceController();

                if(isset($json->imagen_url->name)){
                    $imagen_url = "/upload/product/".$json->imagen_url->name;               
                }else{
                    $image_url = null;
                }

                $new_product_id = $product->store($json->id, $json->nombre, $json->categoria_id, $imagen_url);
                $new_price = $price->store($new_product_id, $json->iva_id, $json->precio_base);
                $new_product = $product->show($new_product_id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id, //la id no vale nada, value de .php es ""
                    'newElement' => $new_product, // newElement no se modifica, se modifica la variable asociada (new_producto, new_categoria)
                );

                echo json_encode($response);

                break;
            
            case 'showProduct':

                $product = new ProductController();
                $products = $product->show($json->id);

                $response = array(
                    'status' => 'ok',
                    'element' => $products, 
                );

                echo json_encode($response);

                break;
            
            case 'deleteProductPrice':

                $product = new ProductController();
                $price = new PriceController();
                $product->delete($json->id);
                $price->delete($json->id);         

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;

                // ESTADISITCAS

            case 'getSaleChartData':
                
                $sale = new VentasController();
                $data = $sale->getChartData($json->chart_data);
                
                foreach($data as $value){
                    $response['labels'][] = isset($value['labels']) ? $value['labels'] : null;
                    $response['data'][] = isset($value['data']) ? $value['data'] : null;
                    $response['quantity'][] = isset($value['quantity']) ? $value['quantity'] : null;
                }

                echo json_encode($response);
                
                break;

            case 'getTicketChartData':

                $ticket = new TicketController();
                $data = $ticket->getChartData($json->chart_data);
                
                foreach($data as $value){
                    $response['labels'][] = isset($value['labels']) ? $value['labels'] : null;
                    $response['data'][] = isset($value['data']) ? $value['data'] : null;
                    $response['quantity'][] = isset($value['quantity']) ? $value['quantity'] : null;
                }

                echo json_encode($response);
                
                break;

            case 'exportSaleToExcel':

                $sale = new VentasController();
                $excel = $sale->exportSaleToExcel($json->sale_id);
                
                $response = array(
                    'status' => 'ok',   
                );

                echo json_encode($response);
                
                break;    

            case 'exportAllProductsToExcel':

                $products = new ProductController();
                $excel = $products->exportAllProductsToExcel();
                
                $response = array(
                    'status' => 'ok',   
                );

                echo json_encode($response);
                
                break; 
                
            case 'exportAllSalesToExcel':
    
                $venta = new VentasController();
                $excel = $venta->exportAllSalesToExcel();
                
                $response = array(
                    'status' => 'ok',   
                );

                echo json_encode($response);
                
                break; 

            case 'showSale':

                $sales = new VentasController();

                $sale = $sales->numero($json->id);
                $products = $sales->productos($json->id);
                $html = "";
    
                foreach($products as $product){
    
                    $html .= '<tr>
                        <td class="text-center"><img class="img-ticket" src="'.$product['imagen_url'].'"></td>
                        <td class="text-center">'.$product['nombre'].'</td>
                        <td class="text-center">'.$product['precio_base'] .'</td>
                        <td class="text-center">'.$product['cantidad'] .'</td>
                    </tr>';
                }
    
                $sale['products'] = $html;
    
                $response = array(
                    'status' => 'ok',
                    'element' => $sale,
                );
    
                echo json_encode($response);            
    
            break;

            case 'exportSaleToPdf':

                $sale = new VentasController();
                $sale->exportSaleToPdf($json->sale_id);
                
                $response = array(
                    'status' => 'ok',   
                );

                echo json_encode($response);
                
                break;
        }
    }

?>