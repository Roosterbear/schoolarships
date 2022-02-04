<?php
defined('BASEPATH') OR exit('No direct script access allowed');
session_start();

class Convocatoria extends CI_Controller {

	public $becas_util;			
	
	public function __construct(){
		parent::__construct ();
		
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();	
		
	}
	
	public function index(){		
		$this->load->view('header');
		$data['convocatorias'] = @$this->becas_util->convocatorias->getTiposBeca();
		$data['fecha_hoy'] = @$this->becas_util->utilerias->getFechaHoy();		
		$data['periodo_actual'] = @$this->becas_util->utilerias->getPeriodoActual();
		$data['periodo_siguiente'] = @$this->becas_util->utilerias->getPeriodoSiguiente();
		$data['next'] = @$this->becas_util->utilerias->thereIsNextPeriodo();
		$id = @$this->becas_util->utilerias->getIdPeriodoThisyear();
		$data['year'] = @$this->becas_util->utilerias->getYear($id);
		$data['las_convocatorias'] = @$this->becas_util->convocatorias->getConvocatorias();
			
		$this->load->view('convocatoriaVw',$data);		
		$this->load->view('footer');	
	}
	
	
	// ----------------------------
	// Crear una convocatoria nueva
	// ----------------------------	
	
	public function insertConvocatoria(){
		$tipo_beca = $_POST['tipo_beca'];	
		$periodo_publicacion = @$this->becas_util->utilerias->getIdPeriodoActual();
		$texto_periodo_publicacion = @$this->becas_util->utilerias->getPeriodoActual();
		$periodo_aplicacion = @$this->becas_util->utilerias->getIdPeriodoSiguiente();
		$texto_periodo_aplicacion = @$this->becas_util->utilerias->getPeriodoSiguiente();		
		
		$fecha_publicacion = $_POST['fecha_publicacion'].' 00:00:00';		
		$fecha_vencimiento = $_POST['fecha_vencimiento'].' 23:59:59';		
		$fecha_resultados = $_POST['fecha_resultados'];		
		$descripcion = $_POST['descripcion'];
		$fecha_limite_inscripcion = $_POST['fecha_limite_inscripcion'];
		 
		$this->becas_util->convocatorias->setTipoBeca($tipo_beca);
		$this->becas_util->convocatorias->setPeriodoPublicacion($periodo_publicacion);
		$this->becas_util->convocatorias->setPeriodoAplicacion($periodo_aplicacion);
		$this->becas_util->convocatorias->setFechaPublicacion($fecha_publicacion);
		$this->becas_util->convocatorias->setFechaVencimiento($fecha_vencimiento);
		$this->becas_util->convocatorias->setFechaResultados($fecha_resultados);
		$this->becas_util->convocatorias->setDescripcion($descripcion);
		$this->becas_util->convocatorias->setFechaLimiteInscripcion($fecha_limite_inscripcion);

		
		
		$maleta['ejecutado'] = $this->becas_util->convocatorias->insertConvocatoria();	
		$maleta['tipo_beca'] = $tipo_beca;
		$maleta['periodo_publicacion'] = $periodo_publicacion;
		$maleta['texto_periodo_publicacion'] = $texto_periodo_publicacion;
		$maleta['periodo_aplicacion'] = $periodo_aplicacion;
		$maleta['texto_periodo_aplicacion'] = $texto_periodo_aplicacion;
		$maleta['fecha_publicacion'] = $fecha_publicacion;
		$maleta['fecha_vencimiento'] = $fecha_vencimiento;
		$maleta['fecha_resultados'] = $fecha_resultados;
		$maleta['descripcion'] = $descripcion;
		$maleta['fecha_limite_inscripcion'] = $fecha_limite_inscripcion;
			
		$this->done($maleta);
	}		
	
	
	// ------------------------------------------------
	// Mensaje de respuesta de creacion de convocatoria
	// ------------------------------------------------	
	
	public function done($maleta){
		$data['tipo_beca'] = $maleta['tipo_beca'];
		$data['periodo_publicacion'] = $maleta['periodo_publicacion'];
		$data['texto_periodo_publicacion'] = $maleta['texto_periodo_publicacion'];
		$data['periodo_aplicacion'] = $maleta['periodo_aplicacion'];
		$data['texto_periodo_aplicacion'] = $maleta['texto_periodo_aplicacion'];
		$data['fecha_publicacion'] = $maleta['fecha_publicacion'];
		$data['fecha_vencimiento'] = $maleta['fecha_vencimiento'];
		$data['fecha_resultados'] = $maleta['fecha_resultados'];
		$data['descripcion'] = $maleta['descripcion'];
		$data['fecha_limite_inscripcion'] = $maleta['fecha_limite_inscripcion'];
		$data['ejecutado'] = $maleta['ejecutado'];
	
		$this->load->view('header');
		$this->load->view('resultado_convocatorias',$data);
		$this->load->view('footer');
	}
	
	
	// -----------------------------
	// Modificacion de convocatorias
	// -----------------------------
	
	public function setDataToUpdate(){
		if ($_REQUEST){
			$id = $_REQUEST['id'];
			$dato = utf8_decode($_REQUEST['dato']);
			$campo = $_REQUEST['campo'];
		}else{
			$id = '';
			$dato = '';
			$campo = '';
		}
		
		$data['id'] = $id;
		$data['dato'] = $dato;
		$data['campo'] = $campo;
		
		$this->becas_util->convocatorias->updateConvocatoria($data);
		return true;
	}	
	
	
	// -----------------------------
	// Eliminacion de convocatorias
	// -----------------------------
	
	public function setDataToDelete(){
		if ($_REQUEST){
			$id = $_REQUEST['id'];
		}else{
			$id = '';
		}
		
		$this->becas_util->convocatorias->deleteConvocatoria($id);
		return true;
	}
	
	
	// ---------------------------------------------
	// Obtener datos de UNA convocatoria seleccionada
	// ---------------------------------------------
	
	public function setDataToDisplay(){
		if($_REQUEST){
			$id = $_REQUEST['id'];
			$campo = $_REQUEST['campo'];
		}else{
			$id = '';	
			$campo = '';
		}		
		echo $this->becas_util->convocatorias->getDataToDisplay($id, $campo);		
	}
	
	
	// ---------------------------------------------
	// Funcion llamada desde SOLICITUD de Becas
	// ---------------------------------------------
	public function getConvocatorias(){
		if($_REQUEST){			
			$tipo = $_REQUEST['tipo'];
		}else{			
			$tipo = '';
		}
		
		echo $this->becas_util->convocatorias->printConvocatoriasByTipo($tipo);
	}
		
	
	public function getDatosConvocatoriaById(){
		
		if($_REQUEST){
			$id = $_REQUEST['id'];
		}else{
			$id = '';
		}
		
		echo $this->becas_util->convocatorias->printDatosConvocatoria($id);
	}
	
	public function validaDuplicacionConvocatoriaSolicitada(){
		if($_REQUEST){
			$id = $_REQUEST['id'];
			$matricula = $_REQUEST['matricula'];
		}else{
			$id = '';
			$matricula = '';
		}
		
		$periodo = $this->becas_util->convocatorias->getPeriodoAplicacionDeConvocatoria($id);
		
		echo $this->becas_util->convocatorias->yaSolicitoBecaEnElPeriodo($matricula, $periodo);
	}
	
	
	public function validaFechaConvocatoriaSolicitada(){
		if($_REQUEST){
			$id = $_REQUEST['id'];			
		}else{
			$id = '';			
		}
		
		echo $this->becas_util->convocatorias->estaEnFechaParaSolicitar($id);
	}
	
	public function insertarSolicitud(){
		if($_REQUEST){			
			$data['matricula'] = $_REQUEST['matricula'];
			$data['id'] = $_REQUEST['id'];
			$data['motivos'] = utf8_decode($_REQUEST['motivos']);
		}else{			
			$data['matricula'] = '';
			$data['id'] = '';
			$data['motivos'] = '';
		}
		
		echo $this->becas_util->convocatorias->insertarSolicitudDeBeca($data);
	}
	
	public function listarHistorialSolicitudes(){
		if($_REQUEST){
			$matricula = $_REQUEST['matricula'];		
		}else{
			$matricula = '';			
		}	
		
		echo $this->becas_util->convocatorias->mostrarHistorial($matricula);
	}
	
	// Se utiliza en SOLICITUD DE BECAS para mostrar becas ya asignadas
	public function listarAsignadas(){
		if($_REQUEST){
			$matricula = $_REQUEST['matricula'];
		}else{
			$matricula = '';
		}
	
		echo $this->becas_util->convocatorias->mostrarAsignadas($matricula);
	}
	
	public function printCarreras(){
		echo $this->becas_util->alumnos->printCarrerasHTML();
	}
	
	public function printTiposBeca(){
		echo $this->becas_util->alumnos->printTiposBecaHTML();
	}
		
}