<?php

	require_once 'app/Controllers/MetoodosPagoController.php';

	use app\Controllers\MetodosPagoController;

	$metodos_pago = new MetodosPagoController();
?>

<div class="modal-header">
    <h4>Metodo de pago</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row align-items-center flex-column">
        <?php foreach($metodospago as $metodopago):?>
            <div class="col-6 d-lg-flex m-2"><button class="btn btn-primary w-100" type="button"><? $metdopago["nombre"];?> </button></div>
        <?php endforeach;?>
    </div>
</div>
<div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button></div>