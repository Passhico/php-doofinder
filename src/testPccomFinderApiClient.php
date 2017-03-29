<?php


require_once './pccomDooFinderApiClient.php';

$apiKeyMIA = 'eu1-79cdbca29415f714e4bddb283397927e008065b4'; 
$apiKeyJM = 'eu1-100811e0f54526963193683549b9682878a83d35'; 


$fooFinder = new pccomDooFinderApiClient($apiKeyJM) ; 
//$fooFinder->showAvailiableSearchEngines(); 
$fooFinder->setCurrentSearchEngineByName("Pc Componentes TEST2"); 

echo "Seleccionado: "  . $fooFinder->getCurrentSearchEngine() . "<br>"; 