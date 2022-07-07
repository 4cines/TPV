<?php

	require_once 'app/Controllers/TicketController.php';

	use app\Controllers\TicketController;

	$ticket = new TicketController();

    if(isset($_GET['mesa'])){
        $tickets = $ticket->index($_GET['mesa']);
        $totales = $ticket->total($_GET['mesa']);
        $num_mesa = $ticket->num_mesa($_GET['mesa']);
    };
?>

<div class="col-12 col-lg-5 col-xl-4 mt-5">
    <aside>
        <?php if(isset($num_mesa)):?>
            <h2 class="text-center">TICKET MESA <?php  echo $num_mesa['numero'] ?></h2>
        <?php else:?>
            <h2 class="text-center">TICKET MESA</h2>
        <?php endif;?>

        <ul class="list-group shadow mt-4">
        <?php if (isset($tickets)):?>
            <?php foreach($tickets as $ticket):?>
                    <li class="list-group-item d-flex align-items-center"><button class="delete-product btn btn-light btn-sm me-2" data-table="<?php echo $_GET['mesa'];?>" data-ticket="<?= $ticket['ticket_id']; ?>" type="button"><i class="la la-close"></i></button><img class="img-ticket" src="<?= $ticket['imagen_url'];?>">
                        <div class="flex-grow-1"><span class="categoria-prod"><?= $ticket['categoria'];?></span>
                            <h4 class="nombre-prod mb-0"><?= $ticket['nombre'];?></h4>
                        </div>
                        <p class="precio-prod"><?= $ticket['precio_base']?>€</p>
                    </li>   
            <?php endforeach;?>
        <?php else:?>
            <h4 class="nombre-prod mb-0"><?php
                echo "No existen productos en esta mesa"?></h4>
        <?php endif;?>  
        </ul>
        <div class="row mt-3">
            <div class="col">
                <div class="bg-secondary">
                    <div class="row justify-content-between g-0">
                        <div class="col">
                            <h5 class="text-center text-white mb-0 pt-1">B. Imponible</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 border-start pt-1">IVA</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 bg-dark pt-1">TOTAL</h5>
                        </div>
                    </div>
                    <div class="row justify-content-between g-0">
                        <div class="col">
                            <?php if (isset($totales) && $totales != null):?>
                                <h5 class="text-center text-white mb-0 pb-1"><?=$totales['base'];?>€</h5>
                            <?php else:?>
                                <h5 class="text-center text-white mb-0 pb-1">0 €</h5>
                            <?php endif;?>    
                        </div>
                        <div class="col"> 
                            <?php if (isset($totales) && $totales != null):?>
                                <h5 class="text-center text-white mb-0 border-start pb-1"><?=$totales['iva'];?>%</h5>
                            <?php else:?>
                                    <h5 class="text-center text-white mb-0 pb-1">-</h5>
                            <?php endif;?> 
                        </div>
                        <div class="col">
                            <?php if (isset($totales) && $totales != null):?>
                                <h5 class="text-center text-white mb-0 bg-dark pb-1"><?=$totales['total'];?> €</h5>
                            <?php else: ?>
                                <h5 class="text-center text-white mb-0 bg-dark pb-1">0 €</h5>
                            <?php endif;?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-6">
                <div><a class="btn btn-danger btn-lg w-100" role="button" href="#myModal" data-bs-toggle="modal">ELIMINAR</a>
                    <div class="modal fade" role="dialog" tabindex="-1" id="myModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Eliminar ticket</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center text-muted">Está a punto de borrar el pedido sin ser cobrado. ¿Está completamente seguro de realizar esta acción?</p>
                                </div>
                                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button><button class="delete-all-products btn btn-success" data-table="<?php echo $_GET['mesa'];?>" type="button">ELIMINAR</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div><a class="charge-ticket btn btn-success btn-lg w-100" data-table="<?php echo $_GET['mesa'];?>"data-price="<?php echo $_GET['mesa'];?>" role="button" href="#myModal-2" data-bs-toggle="modal">COBRAR</a>
                    <div class="modal fade" role="dialog" tabindex="-1" id="myModal-2">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <?php include('metodospago.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>