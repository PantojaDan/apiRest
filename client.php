<?php

//Manejar los diferentes errores
$ch = curl_init( $argv[1] );

curl_setopt(
    $ch,
    CURLOPT_RETURNTRANSFER,
    true
);

$response = curl_exec($ch);//Obtener la respuesta

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);//Obtener el codigo de error o que paso con esta peticion


switch ($httpCode) {
    case 200:
        echo "Todo bien";
        break;
    
    case 400: 
        echo "Pedido incorrecto";
        break;

    case 404: 
        echo "Recurso no encontrado";
        break;
    
    case 500: 
        echo "El servidor fallo";
        break;
}

?>