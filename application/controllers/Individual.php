<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Individual extends CI_Controller
{

	public $becas_util;	
	protected $ip;
	private $_user;
	
	public function __construct(){
		parent::__construct ();

		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();

		$this->ip = getenv("REMOTE_ADDR"); //Sacar IP Local
	}

	public function index(){
		
		if ($_GET){
			$_SESSION['usuario'] = $_GET ['uid'];
		}else{
			if (true){
				$_SESSION['usuario'] = 'EXTERNO';
					
				// Let in 0 to block external access
				//$_SESSION['usuario'] = 0;
			}
		}

		$data['usuario'] = $_SESSION['usuario'];
		$this->load->view('header');		

		// Current period in text
		$data['periodo_actual'] = @$this->becas_util->utilerias->getPeriodoActual();

		// Current period ID
		$data['id_periodo_actual'] = @$this->becas_util->utilerias->getIdPeriodoActual();
		
		// Data to let choose a period
		$data['todos_los_periodos'] = @$this->becas_util->utilerias->todosLosPeriodos();
		$data['cuantos_periodos_hay'] = @$this->becas_util->utilerias->cuantosPeriodosHay();
		
		$data['carreras'] = @$this->becas_util->alumnos->getCarreras();
		$data['tipos_beca'] = @$this->becas_util->alumnos->getCategoriaBecaFull();

		
		// This line is to block external access to SITO
		//if($_SESSION['usuario'] != 'EXTERNO'){
		if($_SESSION['usuario']){
			$this->load->view('individualVw',$data);
		}else{
			$this->load->view('individual_errorVw',$data);
		}
		
		$this->load->view('footer');

	}
	
	
	public function asignarBeca(){
		$periodo = '';
		$matricula = '';
		$beca = '';
		
		if($_REQUEST){
			$periodo = $_REQUEST['periodo'];
			$matricula = $_REQUEST['matricula'];
			$beca = $_REQUEST['beca'];		
		}
		
		$ya_tiene_beca = $this->existeBeca($periodo, $matricula);		
		
		if($ya_tiene_beca){
			echo $this->modificarBeca($periodo, $matricula, $beca);
		}else{
			echo $this->altaBeca($periodo, $matricula, $beca);
		}
	}
	
	
	public function existeBeca($periodo, $matricula){
		return $this->becas_util->utilerias->este_alumno_esta_becado($periodo, $matricula);
	}
	
	public function modificarBeca($periodo, $matricula, $beca){
				
		$respuesta = $this->becas_util->utilerias->modificarBecaIndividual($periodo, $matricula, $beca);
		
		if ($respuesta){
			return 'Esta Beca esta <strong>CANCELADA</strong> y no se puede modificar';
		}else{
			echo 'Se ha <azul>modificado</azul> la Beca para: <strong>'.$this->becas_util->alumnos->getNombreAlumnoByMatricula($matricula).'</strong><br />';
		}
	}
	
	public function altaBeca($periodo, $matricula, $beca){
		
		$data['periodo'] = $periodo;
		$data['matricula'] = $matricula;
		$data['beca'] = $beca;
		$data['ip'] = $this->ip;
		
		$respuesta = $this->becas_util->utilerias->altaBecaIndividual($data);
		
		echo 'Se ha <azul>agregado</azul> la Beca para: <strong>'.$this->becas_util->alumnos->getNombreAlumnoByMatricula($matricula).'</strong><br />'.$respuesta;
		
	}	
	
}