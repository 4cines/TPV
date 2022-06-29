<?php

	require_once 'app/Controllers/VentasController.php';

	use app\Controllers\VentasController;

	$venta = new VentasController();
    $ventas = $venta->index($_GET['fecha'], $_GET['mesa']);


    if(isset($_GET['venta'])){
        $ticket = $venta->numero($_GET['venta']);
        $productos = $venta->productos($_GET['venta']);
    };

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Abel.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-3 border titular">TPV</h1>
            </div>
            <div class="col-12 col-lg-7 col-xl-8 order-lg-1 mt-5">
                <section>
                    <?php if(isset($ticket)):?>
                        <h2 class="text-center">VENTA <?php echo $ticket['numero_ticket'] ?></h2>
                    <?php else:?>
                        <h2 class="text-center"> VENTA </h2>
                    <?php endif;?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Datos de la venta</h5>
                                    <?php if(isset($ticket)):?>
                                        <p class="card-text">
                                            <strong>Mesa:</strong> <?php echo $ticket['mesa_id']?><br>
                                            <strong>Método de pago:</strong> <?php echo $ticket['metodo_pago_id']?><br>
                                            <strong>Total base:</strong> <?php echo $ticket['precio_total_base']?><br>
                                            <strong>Total IVA:</strong> <?php echo $ticket['precio_total_iva']?><br>
                                            <strong>Total:</strong> <?php echo $ticket['precio_total']?>
                                        </p>    
                                    <?php else:?>
                                        <?php echo 'No hay ningún ticket seleccionado'?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center"scope="col"></th>
                                <th class="text-center" scope="col">NOMBRE</th>
                                <th class="text-center" scope="col">PRECIO</th>
                                <th class="text-center" scope="col">CANTIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($_GET['venta'])):?>
                                <?php foreach($productos as $producto):?>
                                    <tr> 
                                        <td class="text-center"><img class="img-ticket" src="<?=$producto['imagen_url'];?>"></td>
                                        <td class="text-center"><?php echo $producto['nombre']?></td>
                                        <td class="text-center"><?php echo $producto['precio_base']?> €</td>
                                        <td class="text-center"><?php echo $producto['cantidad']?></td>
                                    </tr>
                                <?php endforeach;?> 
                            <?php endif;?>                           
                        </tbody>
                    </table>
                </section>
            </div>

            <div class="col-12 col-lg-5 col-xl-4 mt-5">
                <aside>
                    <h2 class="text-center">VENTAS</h2>
                    <form action="ventas.php" method="GET">

                        <div class="row mt-3 mb-3">
                            <div class="col-6">
                                <p>Filtrar por fecha:</p>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <input type="date" name="fecha" value="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-6">
                                <p>Filtrar por mesa:</p>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <select name="mesa" class="form-control">
                                        <option value="">Todas</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>

                    </form>
                    <div class="list-group">
                        <?php foreach($ventas as $venta):?>
                            <?php if((isset($_GET['fecha'],$_GET['mesa'])) && $_GET['fecha']== $venta['fecha'] && $_GET['mesa']==$venta['mesa']): ?>
                                <a class="sale-item list-group-item list-group-item-action active" href="ventas.php?venta=<?php echo $venta['id']?>" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Ticket:<?php echo $venta['numero_ticket']?></h5>
                                        <small>Hora: <?php echo $venta['hora_emision']?></small>
                                        <small>Mesa: <?php echo $venta['mesa_id']?></small>
                                    </div>
                                    <p class="mb-1"><?php echo $venta['precio_total']?>€</p>
                                    <small>Fecha Emision: <?php echo $venta['fecha_emision']?></small>
                                </a>  
                            <?php else:?>
                                <a class="sale-item list-group-item list-group-item-action" href="ventas.php?venta=<?php echo $venta['id']?>" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Ticket:<?php echo $venta['numero_ticket']?></h5>
                                        <small>Hora: <?php echo $venta['hora_emision']?></small>
                                        <small>Mesa: <?php echo $venta['mesa_id']?></small>
                                    </div>
                                    <p class="mb-1"><?php echo $venta['precio_total']?>€</p>
                                    <small>Fecha Emision: <?php echo $venta['fecha_emision']?></small>
                                </a>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                </aside>
            </div>

        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>