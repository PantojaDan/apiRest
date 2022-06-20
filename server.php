<?php

require 'client.php';


//Mecanismo Comunicacion Via Acess Tokens
/*if( !array_key_exists('HTTP_X_TOKEN',$_SERVER)){//Si No Existe el token o no se pasa el token
    die;
}

$url = 'http://localhost:81';//Url donde estara escuchando el servidor de autenticacion

//Ejecutar una llamada por medio del curl hacia el servidor de autenticacion
//para validar el token
$ch = curl_init( $url );//Se inicializa la llamada
curl_setopt(//Informar el encabezado o token a validar
    $ch,
    CURLOPT_HTTPHEADER,
    [//Lista de encabezados
        "X-Token: {$_SERVER['HTTP_X_TOKEN']}"
    ]
);
curl_setopt(//Obtener lo que el servidor nos esta devolviendo
    $ch,
    CURLOPT_RETURNTRANSFER,
    true
);


$ret = curl_exec($ch);

if($ret !== 'true'){//Si no es verdadero lo que nos devuellve el servidor de autenticacion...
    die;
}*/

//Definir los recursos a compartir o permitidos
$allowedResources = [
    'books',
    'authors',
    'genres'
];


//Verificar si lo que se esta solicitando esta en los recursos disponibles
$resourcesType = $_GET["resource_type"];
if( !in_array($resourcesType, $allowedResources) ){//Si lo que esta en la url, no existe en el arreglo de recursos disponibles... entonces
    http_response_code(400);//Codigo de error ya que no existe ese recurso
    die();
}

//Definir los recursos, esto puede ser una db
$books = [
    1 => [
        'titulo' => 'Inteligencia Emocional',
        'id_autor' => 2,
        'id_genero' => 2,
    ],
    2 => [
        'titulo' => 'El Principito',
        'id_autor' => 3,
        'id_genero' => 3,
    ],
    3 => [
        'titulo' => 'La Odisea',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
];

header('Content-Type: application/json');

//PEDIR UN RECURSO DETERMINADO
$resourceId = array_key_exists("resource_id",$_GET) ? $_GET["resource_id"] : "";//Si en el GET existe esta llave... entonces..

switch ( strtoupper($_SERVER['REQUEST_METHOD'])) {//Evaluar el tipo de metodo ya sea GET POST PUT O DELETE
    case 'GET':
        if(empty($resourceId)){//Si no se busca un determinado recurso entonces esta vacio y entonces...
            echo json_encode($books);//Convertimos a json el arreglo de los libros
        }else{//Se solicita un determinado recurso
            if(array_key_exists($resourceId, $books)){//Si existe ese id o libro en el arreglo de nuestros libros entonces...
                echo json_encode($books[$resourceId]);
            }else{//Si no existe, entonces
                http_response_code(404);//Recurso no encontrado
                echo  "chale";
            }
        }
        break;
    case 'POST': 
        $json = file_get_contents('php://input');//Leer un contenido (lo que mande el usuario) y obtener su json
        
        /*$titulo = $_POST["titulo"];
        $id_autor = $_POST["id_autor"];
        $id_genero = $_POST["id_genero"];

        $sent_data = [
            "titulo" => $titulo,
            "id_autor" => $id_autor,
            "id_genero" => $id_genero
        ];

        $json = json_encode($sent_data);*/

        $books[] = json_decode($json,true);//Convertir el string a json y true para que al devolverse sea un array
        
        //echo array_keys($books)[count($books)-1]."\n";//Mostramos el id del recursos añadido
        echo(json_encode($books));//Mostramos los datos o libros 
        break;
    case 'PUT':
        if(!empty($resourceId)&&(array_key_exists($resourceId,$books))){//Si existe el id y ese id existe en el arreglo de books...entonces...
            //Tomamos los datos
            $json = file_get_contents("php://input");

            $books[$resourceId] = json_decode($json,true);//Actualizamos en el id correspondiente
            
            //Mostramsos la coleccion modificada
            echo json_encode($books);
        }
        break;
    case 'DELETE': 
        //Validar que el recurso exista
        if(!empty($resourceId)&&(array_key_exists($resourceId,$books))){
            //Eliminando ese recurso
            unset($books[$resourceId]);

            echo json_encode($books);
        }
        break;
}

?>