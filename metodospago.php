<?php

	require_once 'app/Controllers/MetodosPagoController.php';

	use app\Controllers\MetodosPagoController;

	$metodos_pago = new MetodosPagoController();

    $tipos_cobro = $metodos_pago->index();
?>

<div class="modal-header">
    <h4>Metodo de pago</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="row align-items-center flex-column">
        <?php foreach($tipos_cobro as $tipo_cobro):?>
            <div class="col-6 d-lg-flex m-2"><button class="charge-ticket btn btn-primary w-100" data-bs-dismiss="modal" data-table= <?php echo $_GET['mesa'];?> data-metodopago="<?= $tipo_cobro['id'];?>" type="button"><?= $tipo_cobro["nombre"];?></button></div>
        <?php endforeach;?>
    </div>
</div>
<div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button></div>