<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/VentasController.php';
    require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/MetodosPagoController.php';

    use app\Controllers\TicketController;
    use app\Controllers\VentasController;
    use app\Controllers\ProductController;
    use app\Controllers\TableController;
    use app\Controllers\MetodosPagoController;

    $ticket = new TicketController();
    $ventas = new VentasController();
    $product = new ProductController();
    $table = new TableController();
    $payment_method = new MetodosPagoController();

    $products = $product->index();
    $tables = $table->index();
    $payment_methods = $payment_method->index();

    $total_tables = count($tables);
    $total_products = count($products);
    $total_payment_methods = count($payment_methods);

    for($i = 0; $i <= 100; $i++){

        $table_id = mt_rand(1, $total_tables);

        $start_date = strtotime('2018-01-01');
        $end_date = time();
        $random_date = mt_rand($start_date, $end_date);
        $date = date('Y-m-d', $random_date);
        $time = mt_rand(12,23).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
        $timestamp = date('Y-m-d H:i:s', strtotime($date." ".$time));
        $plus_random_timestamp = date('Y-m-d H:i:s', strtotime($timestamp." +". mt_rand(0,200)." minutes"));

        $add_ticket_products = mt_rand(1, 10);

        for($j = 0; $j <= $add_ticket_products; $j++){

            $product_id = mt_rand(0, ($total_products -1));
            $price_id = $products[$product_id]['precio_id'];

            $ticket->addFakeProduct($price_id, $table_id, $timestamp);
        }

        $payment_method_id = mt_rand(1, $total_payment_methods);

        $totalPrice = $ticket->total($table_id);
        $last_ticket_number =  $ventas->lastTicketNumber();
        $new_ticket_number = $ventas->newTicketNumber($last_ticket_number);
        $charge_ticket_id = $ventas->chargeFakeTicket($table_id, $payment_method_id, $totalPrice, $new_ticket_number, $date, $time, $timestamp);
        $ticket->updateTicket($table_id, $charge_ticket_id);
        $first_product = $ticket->firstproduct($charge_ticket_id);
        $ventas->fakeTimeService($charge_ticket_id, $first_product['creado'], $plus_random_timestamp);
    }
?>