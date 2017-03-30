<?php



//_includeReal
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/pccomDoofinderApiClient.php";

$apiKeyMIA = 'eu1-79cdbca29415f714e4bddb283397927e008065b4'; 
$apiKeyJM = 'eu1-100811e0f54526963193683549b9682878a83d35'; 

  //arrancamos el cliente.
$fooFinder = new pccomDooFinderApiClient($apiKeyJM) ; 

//setteamos el motor de busqueda . 
$fooFinder->setCurrentSearchEngineByName("Pc Componentes TEST2"); 
echo "Seleccionado: "  . $fooFinder->getCurrentSearchEngineName() . "<br>"; 


//Tipos solo ha de haber por el momento 1 , el 'product'
$fooFinder->showTypes(); 


$articulo = array (
	'title' => 'articuloTesteo' , 
	'id_articulo' => '1133465535', 
	'price' => '000000'
	); 
	var_export($articulo, TRUE);
	die();
$idArticuloCreado = $fooFinder->CreateArticulo($articulo); 

echo "<br>El artículo creado es :" . var_export($fooFinder->ReadArticulo($idArticuloCreado));
