<?php

// generar un nuevo ticket consecutivo 
// 1º No hay ningún ticket creado hoy, por lo que se crea uno nuevo con fecha de hoy y empieza por el 001
// 2º Si hay ticket creado hoy, por lo que tengo que añadir uno nuevo con fecha de hoy empieza por el último ticket creado +1 
// Crear una funcion en la que se cree un ticket del mismo dia y de otro día. Generar 1 ticket 


$tickets = ['2205290001', '2205290002', '2205290003', '2205290004'];

function numero_ventas($tickets){;

    if(strpos(end($tickets), date('ymd')) !== false){
        return end($tickets) + 1;
    } else {
        return date('ymd').'0001';
    }
};

echo numero_ventas($tickets);

