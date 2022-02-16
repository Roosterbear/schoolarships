<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class NoBecados extends CI_Controller{
	
	private $user;
	
	public function __construct(){
		parent::__construct ();
		
		$this->load->helper('utilidades');
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();
		
		if ($_GET) {
			$this->_user = $_GET ['uid'];
		}else{
			$this->_user = 'EXTERNO';
		}
		
	}
	
	
	public function index(){
		
		$this->load->view('header');
		$data['usuario'] = $this->_user;	
		
		// Current period in text
		$data['periodo_actual'] = @$this->becas_util->utilerias->getPeriodoActual();
		
		// Current period ID
		$data['id_periodo_actual'] = @$this->becas_util->utilerias->getIdPeriodoActual();	
		
		// Data to let choose a period
		$data['todos_los_periodos'] = @$this->becas_util->utilerias->todosLosPeriodos();		
		$data['cuantos_periodos_hay'] = @$this->becas_util->utilerias->cuantosPeriodosHay();
		
		// FILTERS
		
		$data['carreras'] = @$this->becas_util->alumnos->getCarreras();		
		
		$this->load->view('nobecadosVw',$data);
		$this->load->view('footer');
		
	}
	
	public function printNoBecados(){
	
		$periodo = '';
		$carrera = '';	
		$orden = '';
		$orden_ad = '';
	
		if($_REQUEST){
			$periodo = $_REQUEST['periodo'];
			$carrera = $_REQUEST['carrera'];
			$orden = $_REQUEST['orden'];
			$orden_ad = $_REQUEST['orden_ad'];			
		}
	
		$carrera_sql = $carrera == 0?'':' and gpo.cve_carrera = '.$carrera;
		$orden_sql = ' order by '.$orden;
		$orden_sql .= $orden_ad == 0?' ASC':' DESC';
		
		// matricula_alumno
		// nombre
		// sexo
		// cve_periodo
		// numero_cuatrimestre
		// cve_carrera
		// carrera
		// id_beca_tipo
		// descripcion_beca_tipo
		// id_beca_cat
		// descripcion_beca_cat
		$sql = "select ba.matricula as matricula_alumno
				,p.apellido_paterno+' '+p.apellido_materno+' '+p.nombre as nombre
				,p.sexo as sexo								
				,numero_cuatrimestre				
				,carrera as carrera
				,bcr.nombre as causa_rechazo
				,bc.descripcion as convocatoria
				from beca_asignada ba
				inner join beca_solicitud bs on ba.matricula = bs.matricula
				left outer join beca_causa_rechazo bcr on bcr.id = bs.id_causa_rechazo
				inner join beca_convocatoria bc on bc.id = bs.id_convocatoria_beca
				inner join alumno a on ba.matricula = a.matricula
				inner join persona p on p.cve_persona = a.cve_alumno
				left outer join ( 
					select ag.matricula,g.numero_cuatrimestre,c.nombre as carrera,g.cve_carrera,c.nivel
					from  grupo g
					inner join (select matricula,max(cve_grupo) as cve_grupo from alumno_grupo  group by matricula ) ag on ag.cve_grupo=g.cve_grupo
					inner join  carrera as c on c.cve_carrera=g.cve_carrera
					)gpo on gpo.matricula=ba.matricula	
				where ba.cve_periodo = {$periodo}
				and bs.id_periodo_aplicacion = {$periodo}
				and cve_beca_cat = 0
				{$carrera_sql}
				{$orden_sql}
				";
	
		
		$this->becas_util->utilerias->setPeriodo($periodo);
	
		echo $this->becas_util->utilerias->getNoBecados($sql);
		// Testing
		//echo $sql;
		
	}
}
