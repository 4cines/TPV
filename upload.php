<?php

require_once 'app/Services/ImageService.php';

use app\Services\ImageService;

$image_service = new ImageService();

if(isset($_POST['route'])) {

    switch($_POST['route']) {

        case 'storeProductCategory':
            $image_service->storeFile($_FILES['imagen_url'], 'category');
        break;

        case 'storeProduct':
            $image_service->storeFile($_FILES['imagen_url'], 'product');
        break;
    }
}

?>