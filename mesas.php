<?php

    $mesas = [
        "1" => [
            "numero" => "1",
            "estado" => "1"
        ],
        "2" => [
            "numero" => "2",
            "estado" => "0"
        ],
        "3" => [
            "numero" => "3",
            "estado" => "1"
        ]
    ];
?>
<?php 
    foreach($mesas as $mesa):?>
        <li><?= $mesa['numero']; ?></<li>
<?php 
    endforeach; 
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
        <?php if( $mesas == $mesa->id): ?>
           <li></li>
        <?php elseif($mesa): ?>
          <li></li>
        <?php else: ?>
          <li></li>
        <?php endif; ?>
    </ul>

</body>

</html>