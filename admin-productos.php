<?php

	require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/ProductCategoryController.php';
    require_once 'app/Controllers/TiposIvaController.php';

	use app\Controllers\ProductController;
    use app\Controllers\ProductCategoryController;
    use app\Controllers\TiposIvaController;

	$producto = new ProductController();
	$productos = $producto->index();

    $categoria = new ProductCategoryController();
	$categorias = $categoria->todaslascategorias();

    $tipoiva = new TiposIvaController();
	$tiposiva = $tipoiva->index();

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
                <h1 class="text-center mt-3 border titular"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small> </br> PRODUCTOS</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir producto</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Categoria </th>
                                    <th scope="col">Tipo IVA</th>
                                    <th scope="col">Precio Base </th>
                                    <th scope="col">Visible</th>
                                    <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($productos as $producto): ?>
                                        <tr class="table-element" data-element="<?= $producto['id'] ?>">
                                        <!-- class y [...] tienen el mismo nombre-->
                                            <th scope="row" class="nombre">
                                                <?= $producto['nombre'] ?>
                                            </th>
                                            <td class="categoria_id">
                                                <?= $producto['categoria_id'] ?>
                                            </td>
                                            <td class="tipo_iva">
                                                <?= $producto['tipo_iva'] ?> %
                                            </td>
                                            <td class="precio_base">
                                                <?= $producto['precio_base'] ?> € 
                                            </td>
                                            <td class="visible">
                                                <?= $producto['visible'] ?>
                                            </td>
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $producto['id'] ?>" data-route="showProduct" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $producto['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="create-layout table-element d-none" data-element=""> <!--- Lista para clonar, lo hace invisible d-non que s equita en js con remove--->
                                        <th scope="row" class="nombre"></th>
                                        <td class="categoria_id"></td>
                                        <td class="tipo_iva"></td>
                                        <td class="precio_base"></td>
                                        <td class="visible"></td>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showProduct" data-bs-target="#addArticle">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="delete-table-button btn btn-danger" data-id="" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
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
    <!-- Modal ADD ARTICLE-->
    <div>
        <div id="addArticle" class="modal fade" tabindex="-1" aria-labelledby="addArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArticleLabel">AÑADIR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="admin-form" data-route="storeProduct"> 
                         <!-- empieza el formulario, data, cuando se envia saber donde gestionar el formulario -> web.php-->
                        <input type="hidden" name="id" value=""> <!-- hidden es valor escondido, si quiero crear value="", si quiero editar: value "..."--> 
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre producto</label>
                            <input type="name" class="form-control" name="nombre" value="">
                        </div>
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría asociada</label>
                            <select class="form-select" aria-label="Default select example" name="categoria_id">
                                <option selected>Selecciona una opción</option>
                                <?php foreach($categorias as $categoria):?>
                                <option value="<?php echo $categoria['nombre']?>"><?php echo $categoria['nombre']?></option>
                                <?php endforeach ;?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_iva" class="form-label">Tipo IVA</label>
                            <select class="form-select" aria-label="Default select example" name="tipo_iva">
                                <option selected>Selecciona una opción</option>
                                <?php foreach($tiposiva as $tipoiva):?>
                                <option value="<?php echo $tipoiva['tipo']?>"><?php echo $tipoiva['tipo']?></option>
                                <?php endforeach ;?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="precio_base" class="form-label">Precio Base</label>
                            <input type="precio_base" class="form-control" name="precio_base" value="">
                        </div>
                        <div class="mb-3">
                            <label for="visible" class="form-label">Visible</label>
                            <select class="form-select" aria-label="Default select example" name="visible">
                                <option selected>Selecciona una opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="send-form-button btn btn-primary mt-3" data-bs-dismiss="modal">CONFIRMAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal DELETE ARTICLE-->
    <div>
        <div id="deleteArticle" class="modal fade" tabindex="-1" aria-labelledby="deleteArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleLabel">ELIMINAR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de borrar un producto. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteProductPrice">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>