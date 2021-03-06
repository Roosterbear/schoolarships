<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Cancelacion extends CI_Controller
{
	
	public $becas_util;
	protected $periodo_actual;
	protected $ip;
	
	
	public function __construct(){
		parent::__construct ();
	
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();	
		$this->ip = getenv("REMOTE_ADDR"); //Sacar IP Local				
		
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
			$this->load->view('cancelacionVw',$data);
		}else{
			$this->load->view('cancelacion_errorVw',$data);
		}
		$this->load->view('footer');
	
	}
	
	
	// Gets current period in text based on Utilerias functions
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
	
	public function verificarBeca(){				
		$matricula = ($_REQUEST['matricula']>0)?$_REQUEST['matricula']:'0';
		$periodo = $this->periodo_actual;	
		
		echo $this->becas_util->utilerias->verificarBeca($matricula, $periodo);
	}
	
	public function cancelarBeca(){		
		$matricula = $_REQUEST['matricula'];
		$periodo = $this->periodo_actual;	
				
		// Saves event log
		$this->log($matricula);
		
		// Sets status in 5 and changes Clave Beca to 0
		echo $this->becas_util->utilerias->cancelarBeca($matricula, $periodo);
		
	}	
	
	public function log($matricula){
		$texto = "CANCELACION de beca para el alumno con matricula $matricula ";
		$texto .= " por usuario: ".$_SESSION['usuario'];
		$texto .= " con IP: $this->ip  para el periodo: $this->periodo_actual el ";
		$texto .= date("d/m/y");
		$texto .= " a las ";
		$texto .= date("H:i:s");
		
		$this->becas_util->utilerias->setLog($texto);
		
		return true;
	}
	
}


