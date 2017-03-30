<?php

/**
 * Clase Crud de Artículos usando la API de DooFinder
 * 
 * @see https://github.com/Passhico/php-doofinder
 * @see https://jira.pccomponentes.com/browse/DES-114
 * 
 * Esto usa composer , so composer update & composer install . 
 * 
 * CREDENCIALES PARA EL ENTORNO DE PRUEBAS CUENTA JM : 
 * Management API:eu1-100811e0f54526963193683549b9682878a83d35
 * 
 * CREDENCIALES PARA EL ENTORNO DE PRUEBAS CUENTA PASCUAL: 
 * 
 * 	Management API: eu1-79cdbca29415f714e4bddb283397927e008065b4
 *  Search API:     f05af2c30ce3af68bf27577892d2ada4
 * 
 * 
 */


require_once realpath($_SERVER["DOCUMENT_ROOT"] . '/t00lz/t00lz.php');
require_once realpath($_SERVER["DOCUMENT_ROOT"] . '/../vendor/autoload.php');

use Doofinder\Api\Management\Client as ManagementClient;

/**
 * Cliente para CRUD de los items del feeder usando Api de Doofinder.
 */
class pccomDooFinderApiClient extends ManagementClient
{

	/**
	 * El Motor que vamos a usar .
	 * @var \Doofinder\Api\Management\SearchEngine;  
	 */
	private $currentSearchEngine;
	
	

	/**
	 * 
	 * @param string $hashId El hash del motor. 
	 * @param string $apiKey La Management Apikey
	 */
	public function __construct($apiKey, $searchEngineName = null)
	{
		parent::__construct($apiKey);
	}

	function seleccionaMotor($motor)
	{
		foreach ($this->getSearchEngines() as $motor)
		{
			//var_dump($motor); 
			t00lz::console_log($motor);
		}
	}

	/**
	 * Muestra los Engines disponibles y todos los datos asociados. 
	 * Normalmente solo se usará para depuración, así podremos 
	 * ver los nombres que tienen . 
	 */
	function showAvailiableSearchEngines()
	{

		foreach ($this->getSearchEngines() as $motor)
		{
			var_dump($motor); 
			
		}
	}

	/**
	 * Selecciona el motor según el nombre exacto (case sensitive)
	 * que tenga. 
	 * 
	 * @param string $name Nombre del motor . 
	 */
	function setCurrentSearchEngineByName($name)
	{
		//x cada Engine disponible 
		foreach ($this->getSearchEngines() as $motor)
		{
			//si el nombre del engine es = a name
			if((string)$motor->name == (string)$name)
			{
				//asignamos motor
				$this->currentSearchEngine = $motor; 
			}
		}
		//Si no se ha podido seleccionar petamos y avisamos. 
		if (!$this->currentSearchEngine)
		{
			die('Selecciona un nombre de motor correcto'); 
			//$this->showAvailiableSearchEngines(); 
		}
	}

	function getCurrentSearchEngineName()
	{
		return $this->currentSearchEngine->name; 
	}
	
	function showTypes()
	{
		foreach ($this->currentSearchEngine->getTypes() as $tipo)
			echo $tipo; 
	}
	
	
	/**todo: CRUD **/
	function CreateArticulo($json)
	{
		$articulo_añadido = NULL; 
		$articulo_añadido = $this->currentSearchEngine->addItem('product', $json);

		return $articulo_añadido; 
	}
	function ReadArticulo($itemId)
	{
		
		return $this->currentSearchEngine->getItem($datatype, $itemId);
		
	}
	function UpdateArticulo($articulo)
	{
		
	}
	function DeleteArticulo($articulo)
	{
		
	}

}
