<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');
/* ------------------------------------------------------------ */
/* --- ESTE CONTROLADOR ES PARA HACER PRUEBAS DESDE EL MENU --- */
/* --  CON ESTO SE EVITA TENER QUE ENTRAR A SITO #NO BORRAR# -- */
/* ------------------------------------------------------------ */
class Solitude extends CI_Controller {

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
		
		
			$this->_user = $_GET ['uid'];
			
			$_SESSION['uid'] = $_GET ['uid'];
			
			// Checa si es alumno (el parametro es una matrícula)
			$this->_es_alumno = $this->becas_util->alumnos->esAlumno($this->_user)==''?false:true;
			$this->_hacker = $this->becas_util->utilerias->checarSesion($this->_user, $this->_sid);
			
			/* TERMINAR TODO SI NO ES LA SESION ACTIVA */
			/*
			if ($this->_hacker){
				echo '<h1>Sesion terminada</h1>';
				exit('Ingresar con matricula y actualizar sesion');
			}
			*/
			
			// Deshabilitando la restricción de inscrito 
			//$this->_inscrito = $this->becas_util->alumnos->estaInscrito($this->_user)?true:false;
			$this->_inscrito = true;
			$this->_becado_externo = $this->becas_util->alumnos->tieneBecaExterna($this->_user);
			$this->becas_util->alumnos->setMatriculaAlumno($_GET ['uid']);
			$this->_baja = $this->becas_util->alumnos->tieneBaja($_GET ['uid']);
		
					
	}
	
	public function index(){
		
		$this->load->view('header');
		
		$matricula = $this->becas_util->alumnos->getMatriculaAlumno();
		
		$this->_becado_externo = $this->_becado_externo < $this->becas_util->utilerias->getIdPeriodoActual()?0:1;
		$data['matricula'] = $this->_es_alumno?($this->_inscrito?$matricula:'000'):'00';
		$data['externo'] = $this->_becado_externo?($this->_becado_externo>7?'EXTERNO':'RENOVANTE'):'NUEVO';		
		$nombre = $this->becas_util->alumnos->esAlumno($matricula);
		
		
		// CHECAR SI HIZO LA ENCUESTA !!!
		$this->_hizo_encuesta = $this->becas_util->alumnos->hizoEncuesta($matricula);
		
		
		$data['baja'] = $this->_baja;
		$realmente_inscrito = @$this->becas_util->alumnos->estaInscrito($this->_user);
		$data['real'] = $realmente_inscrito;
		
		// *** SE QUITÓ ESTE ESTATUS PORQUE NO ES REAL Y CONFUNDE AL USUARIO ***
		//$data['descripcion_status'] = (($this->_baja === 'BT')||($this->_baja === 'VD'))?'Baja':($realmente_inscrito?'Inscrito':'No Inscrito');
		$data['descripcion_status'] = '';
		
		$data['nombre'] = $this->becas_util->alumnos->getNombreAlumnoByMatricula($matricula);			
		
		// SI HIZO LA ENCUESTA MANDARLO A BECAS, SINO, AL MENSAJE
		if (true){
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
