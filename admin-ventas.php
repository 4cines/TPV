<?php

	require_once 'app/Controllers/VentasController.php';

	use app\Controllers\VentasController;

	$venta = new VentasController();
	$ventas = $venta->allsales();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

    <?php include('menu.php') ?>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-3 border titular"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small> </br> VENTAS </h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <div class="card-header">
                                <div class="excel_button export-allsales-to-excel" data-route="exportAllSalesToExcel">
                                    <svg viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M21.17 3.25Q21.5 3.25 21.76 3.5 22 3.74 22 
                                        4.08V19.92Q22 20.26 21.76 20.5 21.5 20.75 21.17 20.75H7.83Q7.5 20.75 7.24 
                                        20.5 7 20.26 7 19.92V17H2.83Q2.5 17 2.24 16.76 2 16.5 2 16.17V7.83Q2 7.5 
                                        2.24 7.24 2.5 7 2.83 7H7V4.08Q7 3.74 7.24 3.5 7.5 3.25 7.83 3.25M7 13.06L8.18 
                                        15.28H9.97L8 12.06L9.93 8.89H8.22L7.13 10.9L7.09 10.96L7.06 11.03Q6.8 10.5 6.5 
                                        9.96 6.25 9.43 5.97 8.89H4.16L6.05 12.08L4 15.28H5.78M13.88 19.5V17H8.25V19.5M13.88 
                                        15.75V12.63H12V15.75M13.88 11.38V8.25H12V11.38M13.88 7V4.5H8.25V7M20.75 19.5V17H15.
                                        13V19.5M20.75 15.75V12.63H15.13V15.75M20.75 11.38V8.25H15.13V11.38M20.75 7V4.5H15.
                                        13V7Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Nº Ticket</th>
                                    <th scope="col">Precio total</th>
                                    <th scope="col">Metodo de pago</th>
                                    <th scope="col">Mesa</th>
                                    <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ventas as $venta): ?>
                                        <tr class="table-element" data-element="<?= $venta['id'] ?>">
                                        <!-- class y [...] tienen el mismo nombre-->
                                            <th scope="row" class="numero_ticket">
                                                <?= $venta['numero_ticket']?>
                                            </th>
                                            <td class="precio_total">
                                                <?= $venta['precio_total']?>
                                            </td>
                                            <td class="metodo_pago">
                                                <?= $venta['metodo_pago']?>
                                            </td>
                                            <td class="mesa">
                                                <?= $venta['mesa']?>
                                            </td>
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-primary" data-bs-toggle="modal" data-id="<?= $venta['id'] ?>" data-route="showSale" data-bs-target="#addArticle">
                                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M17 22V20H20V17H22V20.5C22 20.89 21.84 21.24 21.54 21.54C21.24 21.84 20.89 22 20.5 22H17M7 22H3.5C3.11 22 2.76 21.84 
                                                2.46 21.54C2.16 21.24 2 20.89 2 20.5V17H4V20H7V22M17 2H20.5C20.89 2 21.24 2.16 21.54 2.46C21.84 2.76 22 3.11 22 3.5V7H20V4H17V2M7 2V4H4V7H2V3.5C2 
                                                3.11 2.16 2.76 2.46 2.46C2.76 2.16 3.11 2 3.5 2H7M10.5 6C13 6 15 8 15 10.5C15 11.38 14.75 12.2 14.31 12.9L17.57 16.16L16.16 17.57L12.9 14.31C12.2 
                                                14.75 11.38 15 10.5 15C8 15 6 13 6 10.5C6 8 8 6 10.5 6M10.5 8C9.12 8 8 9.12 8 10.5C8 11.88 9.12 13 10.5 13C11.88 13 13 11.88 13 10.5C13 9.12 11.88 8 10.5 8Z" />
                                            </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
    <!-- Modal VIEW ARTICLE-->
    <div>
        <div id="addArticle" class="modal fade" tabindex="-1" aria-labelledby="addArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArticleLabel">VENTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="modal-body">
                    <h2 class="text-center">VENTA</h2>

                    <div class="row">
                        <div class="col-12">
                            <div class="card"> 
                                <div class="card-body">
                                    <h5 class="card-title">Datos de la venta</h5>
                                    <p class="card-text">
                                        <strong>Mesa: </strong><span id="mesa_id"></span><br>
                                        <strong>Método de pago: </strong> <span id="metodo_pago_id"></span><br>
                                        <strong>Total base: </strong> <span id="precio_total_base"></span> €<br>
                                        <strong>Total IVA: </strong> <span id="precio_total_iva"></span> €<br>
                                        <strong>Total: </strong> <span id="precio_total"></span> €
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center"scope="col"></th>
                                <th class="text-center" scope="col">Nombre</th>
                                <th class="text-center" scope="col">Precio Base</th>
                                <th class="text-center" scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="products">
                            
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>



    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>