<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Restriccion extends CI_Controller {

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
		$data['usuario'] = $this->_user;
		$nombre = $this->becas_util->validadores->getNombreUsuario($this->_user);		
		$data['empleado'] = $nombre==''?'':$nombre;
		$data['es_validador'] = $this->becas_util->validadores->esValidador($this->_user)==''?false:true;
		
		$this->load->view('restriccionesVw',$data);
		$this->load->view('footer');
		
	}
	
	public function printSolicitantes(){
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
		$tipo_sql = $tipo == 1?'and ba.cve_beca_cat in (1,2,3)':($tipo == 2?'and ba.cve_beca_cat in (4,5,6)':($tipo == 3?'and ba.cve_beca_cat = 7':''));
		
		// matricula - nombre - tipo - servicio
		$sql = "select distinct ba.matricula as matricula
		,(p.apellido_paterno+' '+ p.apellido_materno +' '+ p.nombre) as nombre
		,c.nombre as carrera
		,ba.cve_periodo as periodo
		,(
		select case
		when ba.cve_beca_cat in (1,2,3)	then 1
		when ba.cve_beca_cat in (4,5,6)	then 2
		when ba.cve_beca_cat in (7)	then 3
		end
		) as 'tipo'
		,(
		select
		case when
		ba.matricula in (select matricula from beca_servicio_social where periodo = {$periodo})		
		then 1 else 0
		end
		) as 'servicio'
		
		from beca_asignada ba
		inner join alumno a on ba.matricula = a.matricula
		inner join persona p on p.cve_persona = a.cve_alumno
		inner join alumno_grupo ag on a.matricula = ag.matricula
		inner join grupo g on ag.cve_grupo = g.cve_grupo and g.cve_periodo = {$periodo}
		inner join carrera c on g.cve_carrera = c.cve_carrera
		
		where
		ba.cve_periodo = {$periodo}
		and ba.cve_beca_cat < 8
		{$carrera_sql}
		{$tipo_sql}
		";
		
		echo $this->becas_util->restricciones->getSolicitantes($sql);		
	}
	
	public function setServicioSocial(){
		$matricula = '';
		$periodo = '';
		$change = '';
		
		if ($_REQUEST){
			$matricula = $_REQUEST['matricula'];
			$periodo = $_REQUEST['periodo'];
			$change = $_REQUEST['change'];			
		}else{
			$matricula = '';
			$periodo = '';
			$change = '';
		}
		
		$sqlInsert = "insert into beca_servicio_social (matricula,periodo) values ('{$matricula}','{$periodo}')";
		$sqlDelete = "delete from beca_servicio_social where matricula = {$matricula} and periodo = {$periodo}";
		
		$change == '1'?$this->becas_util->restricciones->changeServicioSocial($sqlInsert):$this->becas_util->restricciones->changeServicioSocial($sqlDelete);
	}
	
}
