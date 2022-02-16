<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud extends CI_Controller {

	public $becas_util;
	private $_user = '';
	private $_sid = '';
	private $_hacker = '';
	private $_es_alumno = false;
	private $_inscrito = false;
	private $_es_validador = false;	
	private $_becado_externo = false;
	private $_baja = false;
	private $_hizo_encuesta = false;
	
	public function __construct(){
		parent::__construct ();
		
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();					
		
		if (($_GET)&&(isset($_GET ['uid']))&&(isset($_GET ['sid']))) {
			$this->_user = $_GET ['uid'];
			$this->_sid = $_GET ['sid'];
			$_SESSION['uid'] = $_GET ['uid'];
			$_SESSION['sid'] = $_GET ['sid'];
			// Checks if it is a student (the parameter is matrícula)
			$this->_es_alumno = $this->becas_util->alumnos->esAlumno($this->_user)==''?false:true;
			$this->_hacker = $this->becas_util->utilerias->checarSesion($this->_user, $this->_sid);
			
			/* FINISH IF IS NOT AN ACTIVE SESSION */
			if ($this->_hacker){
				echo '<h1>Sesion terminada</h1>';
				exit('Ingresar con matricula y actualizar sesion');
			}
			
			// Disable Inscrito restriction 
			//$this->_inscrito = $this->becas_util->alumnos->estaInscrito($this->_user)?true:false;
			$this->_inscrito = true;
			$this->_becado_externo = $this->becas_util->alumnos->tieneBecaExterna($this->_user);
			$this->becas_util->alumnos->setMatriculaAlumno($_GET ['uid']);
			$this->_baja = $this->becas_util->alumnos->tieneBaja($_GET ['uid']);
		}else{
			// In case we don't get a parameter
			$this->becas_util->alumnos->setMatriculaAlumno('00');
		}			
	}
	
	public function index(){
		
		$this->load->view('header');
		
		$matricula = $this->becas_util->alumnos->getMatriculaAlumno();
		
		$this->_becado_externo = $this->_becado_externo < $this->becas_util->utilerias->getIdPeriodoActual()?0:1;
		$data['matricula'] = $this->_es_alumno?($this->_inscrito?$matricula:'000'):'00';
		$data['externo'] = $this->_becado_externo?($this->_becado_externo>7?'EXTERNO':'RENOVANTE'):'NUEVO';		
		$nombre = $this->becas_util->alumnos->esAlumno($matricula);
		
		
		// Check the poll
		
		// Temporaly disabled
		$this->_hizo_encuesta = true;
		//$this->_hizo_encuesta = $this->becas_util->alumnos->hizoEncuesta($matricula);
		
		
		$data['baja'] = $this->_baja;
		$realmente_inscrito = @$this->becas_util->alumnos->estaInscrito($this->_user);
		$data['real'] = $realmente_inscrito;
		
		// *** SE QUITÓ ESTE ESTATUS PORQUE NO ES REAL Y CONFUNDE AL USUARIO ***
		//$data['descripcion_status'] = (($this->_baja === 'BT')||($this->_baja === 'VD'))?'Baja':($realmente_inscrito?'Inscrito':'No Inscrito');
		$data['descripcion_status'] = '';
		
		$data['nombre'] = $this->becas_util->alumnos->getNombreAlumnoByMatricula($matricula);			
		
		if ($this->_hizo_encuesta){
			$this->load->view('solicitudesVw',$data);
		}else{
			$this->load->view('mensajeEncuestavW',$data);
		}
		
		$this->load->view('footer');
		
	}
	
	public function imprimirFolio($matricula,$folio,$resultados,$tipo){
		$data['matricula'] = $matricula;
		$data['folio'] = $folio;
		$data['resultados'] = $resultados;		
		$data['tipo'] = $tipo;
		
		
		$this->load->view('folioMd',$data);
	}
	
}
