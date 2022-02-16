<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Reportes extends CI_Controller {

	public $becas_util;
	private $_user;
	
	public function __construct(){
		parent::__construct ();
		
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();	
		
		if ($_GET) {
			$this->_user = $_GET ['uid'];				
		}else{
			$this->_user = 0;
		}
	}
	
	public function index(){
		$this->load->view('header');
		
		$data['periodo_anterior'] = @$this->becas_util->utilerias->getPeriodoAnterior();
		$data['periodo_actual'] = @$this->becas_util->utilerias->getPeriodoActual();
		$data['periodo_siguiente'] = (@$this->becas_util->utilerias->getPeriodoActual() == @$this->becas_util->utilerias->getPeriodoSiguiente())?'':@$this->becas_util->utilerias->getPeriodoSiguiente();
		$data['id_periodo_anterior'] = @$this->becas_util->utilerias->getIdPeriodoAnterior();
		$data['id_periodo_actual'] = @$this->becas_util->utilerias->getIdPeriodoActual();
		$data['id_periodo_siguiente'] = (@$this->becas_util->utilerias->getIdPeriodoActual() == @$this->becas_util->utilerias->getIdPeriodoSiguiente())?'':@$this->becas_util->utilerias->getIdPeriodoSiguiente();
		
		$this->load->view('reportesVw',$data);
		$this->load->view('footer');
		
	}
	
	public function printSolicitantes(){
		//$DBSito->debug=true;
		
		if($_REQUEST){
			$periodo = $_REQUEST['periodo'];
			$carrera = $_REQUEST['carrera'];
			$tipo = $_REQUEST['tipo'];
		}else{
			$periodo = '';
			$carrera = '';
			$tipo = '';
		}
	
		$carrera_sql = $carrera == 0?'':'and g.cve_carrera = '.$carrera;
		$tipo_sql = $tipo == 0?'':'and id_beca_tipo = '.$tipo;
	
		// matricula - nombre - tipo - carrera - folio - fs (fecha solicitud)
		$sql = "select distinct bs.matricula as matricula
				,(p.apellido_paterno+' '+ p.apellido_materno +' '+ p.nombre) as nombre
				,c.nombre as carrera
				,bs.id_periodo_aplicacion as periodo
				,id_beca_tipo as tipo
				,(cast(bs.id_periodo_aplicacion as varchar))+'B'+(cast(bs.id_convocatoria_beca as varchar))+'-'+(cast(a.cve_alumno as varchar))+(right((select convert(char(25),bs.fecha_solicitud,126)),3)) as folio
				,bs.fecha_solicitud as fs
				,bs.motivos
				from beca_solicitud bs
				inner join beca_convocatoria bc on  bc.id = bs.id_convocatoria_beca
				inner join alumno a on bs.matricula = a.matricula
				inner join persona p on p.cve_persona = a.cve_alumno
				inner join alumno_grupo ag on a.matricula = ag.matricula
				inner join grupo g on ag.cve_grupo = g.cve_grupo and g.cve_periodo = {$periodo}
				inner join carrera c on g.cve_carrera = c.cve_carrera
				where
				bs.id_periodo_aplicacion = {$periodo}	
				{$carrera_sql}
				{$tipo_sql}
				";
		// Line 200	
		//echo $sql;
		echo $this->becas_util->utilerias->getSolicitantes($sql);		
	}
}
