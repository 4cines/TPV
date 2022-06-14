<?php

// generar un nuevo ticket consecutivo 
// 1º No hay ningún ticket creado hoy, por lo que se crea uno nuevo con fecha de hoy y empieza por el 001
// 2º Si hay ticket creado hoy, por lo que tengo que añadir uno nuevo con fecha de hoy empieza por el último ticket creado +1 
// Crear una funcion en la que se cree un ticket del mismo dia y de otro día. Generar 1 ticket 

$tickets = ['2205290001', '2205290002', '2205290003']


    if($tickets == "2205290003"){
        echo $tickets++1
    }elseif($tickets == ""){
        echo "El color es azul";    
    } else {
        echo "El color no es rojo";
    }

    foreach($tickets as $ticket) {
      echo "El nuevo ticket de hoy es".$ticket
  }
?>