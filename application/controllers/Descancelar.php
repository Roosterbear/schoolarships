<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Descancelar extends CI_Controller
{
	
	public $becas_util;
	protected $periodo_actual;
	protected $ip;
	
	
	public function __construct(){
		parent::__construct ();
	
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();	
		$this->ip = getenv("REMOTE_ADDR"); //Get Local IP		
		
		$this->periodo_actual = $this->becas_util->utilerias->getIdPeriodoActual();		
	}
	
	public function index(){
		
		if ($_GET){
			$_SESSION['usuario'] = $_GET ['uid'];
		}else{
			if (true){				
				$_SESSION['usuario'] = 'EXTERNO';
					
				// Let 0 to block external access
				//$_SESSION['usuario'] = 0;
			}
		}
		
		$this->load->view('header');	
		$data['usuario'] = $_SESSION['usuario'];				
		
		// This line is to block external access to SITO
		//if($_SESSION['usuario'] != 'EXTERNO'){
		if($_SESSION['usuario']){
			$this->load->view('descancelacionVw',$data);
		}else{
			$this->load->view('descancelacion_errorVw',$data);
		}
		$this->load->view('footer');
	
	}
	
	
	// Get current period in text based on Utilerias functions
	public function datosPeriodo(){
		
		$id = $this->periodo_actual;	
		$year = $this->becas_util->utilerias->getYear($id);
		$np = $this->becas_util->utilerias->getIdNumeroPeriodo($id);
		$text = $this->becas_util->utilerias->getTextPeriodoNumber($np);
		$periodo = "".$text." ".$year;				
				
		echo $periodo;
		
	}
	
	
	public function obtenerNombreAlumno(){		
		$matricula = ($_REQUEST['matricula']>0)?$_REQUEST['matricula']:'0';
		$nombre = $this->becas_util->alumnos->getNombreAlumnoByMatricula($matricula);
		echo $nombre;
	}
	
	public function isCanceled_(){
		$matricula = ($_REQUEST['matricula']>0)?$_REQUEST['matricula']:'0';
		$periodo = $this->periodo_actual;
	
		echo $this->becas_util->utilerias->isCanceled_($matricula, $periodo);
	}
	
	public function descancelarBeca(){		
		$matricula = $_REQUEST['matricula'];
		$periodo = $this->periodo_actual;	
				
		// Saves Event Log
		$this->log($matricula);
		
		// We've been checked yet if it has been cancelled
		// This functions doesn't change Beca type (must be 0)
		echo $this->becas_util->utilerias->descancelarBeca($matricula, $periodo); // Sets status to 1 again
		
	}	
	
	// Looking for a guilty
	public function log($matricula){
		$texto = "DES-CANCELACION de beca para el alumno con matricula $matricula ";
		$texto .= " por usuario: ".$_SESSION['usuario'];
		$texto .= " con IP: $this->ip  para el periodo: $this->periodo_actual el ";
		$texto .= date("d/m/y");
		$texto .= " a las ";
		$texto .= date("H:i:s");
		
		$this->becas_util->utilerias->setLog($texto);
		
		return true;
	}
	
}

