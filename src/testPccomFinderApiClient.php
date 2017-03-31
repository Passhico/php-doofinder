<?php

//php.ini customize.
ini_set('date.timezone', 'Europe/Madrid');
ini_set('display_errors', 'on');
error_reporting(E_ALL);
set_time_limit(3600); 

$apiKeyJM = 'eu1-100811e0f54526963193683549b9682878a83d35';

define('APIKEY', $apiKeyJM);
define('SEARCH_ENGINE_NAME', "apitest");

//_includeReal
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/pccomDooFinderApiClient.php";

//arrancamos el cliente.
$fooFinder = new pccomDooFinderApiClient(APIKEY, SEARCH_ENGINE_NAME);

echo "<br>Seleccionado: " . $fooFinder->getCurrentSearchEngineName() . "<br>";


//Creamos un Array con 100 artículos.
$arr100Articulos = array();
for ($i = 600; $i <= 699; $i++)
{
	$articulo4Create = array(
		'title' => 'articuloBLOQUE100' . $i,
		'id_articulo' => $i,
		'price' => '000000',
		'rating' => (int) '4',
		'image_link' => "https://thumb.pccomponentes.com/w-530-530/articles/12/122395/f-2.jpg",
	);

	$arr100Articulos[] = $articulo4Create;

	//$idArticuloCreado = $fooFinder->CreateArticulo($articulo4Create);
}

echo "El array de articulos tiene " . count($arr100Articulos) . "<br>";

if ($fooFinder->Create100Articulos($arr100Articulos))
{
	echo "No se han insertado artículos";
} else
{
	echo "100 ariculos insertados..";
}
