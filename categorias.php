<?php

	require_once 'app/Controllers/ProductCategoryController.php';

	use app\Controllers\ProductCategoryController;

	$categoria = new ProductCategoryController();
	$categorias = $categoria->index();

?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
</head>

<body>
    <ul>
         
        <?php foreach($categorias as $categoria):?>
            <h5><?= $categoria["nombre"] ?></h5>
        <?php endforeach;?>
        

    </ul>
</body>

</html>