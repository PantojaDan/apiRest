<?php

require 'client.php';

$matches=[];

// Excepcion para las  url principal sea index.html
/*if (in_array( $_SERVER["REQUEST_URI"], [ '/index.html', '/', '' ] )) {
    echo file_get_contents( '/curso-php/APIBiblioteca/index.html' );
    die;
}*/
//'/\/([^\/]+)\/([^\/]+)\/([^\/]+)\/([^\/]+)\/([^\/]+)/'
if(preg_match('/\/([^\/]+)\/([^\/]+)\/([^\/]+)/',$_SERVER["REQUEST_URI"],$matches))
{
    $_GET['resource_type']=$matches[2];    
    $_GET['resource_id']=$matches[3];
   
    error_log(print_r($matches,1));
    require 'server.php';
}else if(preg_match('/\/([^\/]+)\/([^\/]+)/',$_SERVER["REQUEST_URI"],$matches))
{
    $_GET['resource_type']=$matches[2];        
    error_log(print_r($matches,1));
    require 'server.php';
}else
{
    error_log('No matches');
    http_response_code(404);
}

?>