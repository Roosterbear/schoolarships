<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Becados extends CI_Controller{
	
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
		
		// Text Current Period
		$data['periodo_actual'] = @$this->becas_util->utilerias->getPeriodoActual();
		
		// Current period ID
		$data['id_periodo_actual'] = @$this->becas_util->utilerias->getIdPeriodoActual();		
		
		// Filters		
		$data['carreras'] = @$this->becas_util->alumnos->getCarreras();
		$data['tipos_beca'] = @$this->becas_util->alumnos->getTiposBecaFull();
		
		$this->load->view('becadosVw',$data);
		$this->load->view('footer');
		
	}
	
	public function printBecados(){
	
		$periodo = '';
		$carrera = '';
		$tipo = '';
		$orden = '';
		$orden_ad = '';
	
		if($_REQUEST){
			$periodo = $_REQUEST['periodo'];
			$carrera = $_REQUEST['carrera'];
			$tipo = $_REQUEST['tipo'];
			$orden = $_REQUEST['orden'];
			$orden_ad = $_REQUEST['orden_ad'];
		}
	
		$carrera_sql = $carrera == 0?'':' and gpo.cve_carrera = '.$carrera;
		$tipo_sql = $tipo == 0?'':($tipo == 99?' and id_beca_tipo < 4 ':($tipo == 999?' and id_beca_tipo > 3 ':' and id_beca_tipo = '.$tipo));
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
				,cve_carrera as cve_carrera
				,carrera as carrera
				,ba.cve_periodo as cve_periodo
				,bt.id as id_beca_tipo
				,bt.descripcion as descripcion_beca_tipo
				,bc.cve_beca_cat as id_beca_cat
				,bc.nombre as descripcion_beca_cat
				from beca_asignada ba
				inner join beca_cat bc on bc.cve_beca_cat = ba.cve_beca_cat
				inner join beca_tipo bt on bt.id = bc.id_beca_tipo
				inner join alumno a on ba.matricula = a.matricula
				inner join persona p on p.cve_persona = a.cve_alumno
				left outer join ( 
					select ag.matricula,g.numero_cuatrimestre,c.nombre as carrera,g.cve_carrera,c.nivel
					from  grupo g
					inner join (select matricula,max(cve_grupo) as cve_grupo from alumno_grupo  group by matricula ) ag on ag.cve_grupo=g.cve_grupo
					inner join  carrera as c on c.cve_carrera=g.cve_carrera
					)gpo on gpo.matricula=ba.matricula	
				where ba.cve_periodo = {$periodo}
				{$carrera_sql}
				{$tipo_sql}
				{$orden_sql}
				";
	
		
		$this->becas_util->utilerias->setPeriodo($periodo);
	
		echo $this->becas_util->utilerias->getBecados($sql);
		// Testing
		//echo $sql;
		
	}
}