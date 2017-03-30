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

//se deja en define por si algún día le cambian el nombre. 
define('TYPE_PRODUCT', 'product');

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
	 * Por defecto siempre 'product' , se inicializa 
	 * en el __construct confirmado con JM . 
	 * si algún día se cambia poner getters y setters.
	 * @var type 
	 */
	private $currentType;

	/**
	 * 
	 * @param string $hashId El hash del motor. 
	 * @param string $apiKey La Management Apikey
	 */
	public function __construct($apiKey, $searchEngineName = null)
	{
		parent::__construct($apiKey);
		$this->currentType = TYPE_PRODUCT;
		$this->setCurrentSearchEngineByName($searchEngineName);
	}

	/**
	 * Muestra los Engines disponibles y todos los datos asociados. 
	 * Normalmente solo se usará para depuración, así podremos 
	 * ver los nombres que tienen . 
	 */
	function showAvailiableSearchEngines()
	{

		$n_motor = 1;
		foreach ($this->getSearchEngines() as $motor)
		{
			echo "<br>{$n_motor}: '" . $motor->name . "'<br>";
			$n_motor++;
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
			if ((string) $motor->name == (string) $name)
			{
				//asignamos motor
				$this->currentSearchEngine = $motor;
			}
		}
		//Si no se ha podido seleccionar petamos y avisamos. 
		if (!$this->currentSearchEngine)
		{
			$this->showAvailiableSearchEngines();
			die("Nombre de momtor: {$name} no existe!");
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

	/*	 * todo: CRUD * */

	function CreateArticulo($articulo)
	{
		$articulo_añadido = NULL;
		try
		{
			$articulo_añadido = $this->currentSearchEngine->addItem(TYPE_PRODUCT, $articulo);
		} catch (Exception $ex)
		{
			echo " Error en CreateArticulo():" . $ex->getMessage();
		}
		return $articulo_añadido;
	}

	/**
	 * Crea hasta 100 artículos de una vez. 
	 * 
	 * @return bool TRUE si ocurrión algún Error , FALSE si todo fue bien .
	 * @param array[] $arr100articulos Array de Array de artículos.
	 */
	function Create100Articulos($arr100articulos)
	{
		if (!$arr100articulos)
		{
			echo "<BR>Error: Llamando a Create100Articulos(NULL)";
			return 1;
		}

		try
		{
			$this->currentSearchEngine->addItems(TYPE_PRODUCT, $arr100articulos);
		} catch (Exception $ex)
		{
			echo " Error en Create100Articulos():" . $ex->getMessage();
			return 1; 
		}
		return 0 ; 
	}

	function ReadArticulo($itemId)
	{

		return $this->currentSearchEngine->getItem(TYPE_PRODUCT, $itemId);
	}

	function UpdateArticulo($articuloId, $articulo)
	{
		$this->currentSearchEngine->updateItem(TYPE_PRODUCT, $articuloId, $articulo);
	}

	function DeleteArticulo($articuloId)
	{
		$this->currentSearchEngine->deleteItem(TYPE_PRODUCT, $itemId);
	}

	/**
	 * Devuelve un ScrollIterator de todos los artículos.
	 * 
	 * @return Doofinder\Api\Management\ScrollIterator[] | NULL
	 */
	function getAllArticulos()
	{
		/* @var $todosLosArticulos Doofinder\Api\Management\ScrollIterator */
		$todosLosArticulos; 
			
		try
		{
			$todosLosArticulos =  $this->currentSearchEngine->items(TYPE_PRODUCT);
		} catch (Exception $ex)
		{
			echo "getAllArticulos() Error : " . $ex->getMessage(); 
			return NULL; 
		}
		return $todosLosArticulos; 
	}
}
