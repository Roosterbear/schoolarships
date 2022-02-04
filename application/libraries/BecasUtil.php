<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . "/../models/Restricciones.php";
require_once __DIR__ . "/../models/Convocatorias.php";
require_once __DIR__ . "/../models/Validadores.php";
require_once __DIR__ . "/../models/Utilerias.php";
require_once __DIR__ . "/../models/Alumnos.php";

class BecasUtil
{
	public $restricciones;
	public $convocatorias;
	public $validadores;
	public $utilerias;
	public $alumnos;
	
	function __construct(){
		$this->restricciones = new Restricciones();
		$this->convocatorias = new Convocatorias();
		$this->validadores = new Validadores();
		$this->utilerias = new Utilerias();
		$this->alumnos = new Alumnos();
	}		
}