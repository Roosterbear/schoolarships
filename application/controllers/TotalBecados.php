<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TotalBecados extends CI_Controller{
	
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
		$data['html'] = $this->printBecados();
		
		$this->load->view('totalBecadosVw',$data);
		$this->load->view('footer');
		
	}
	
	public function printBecados(){
		$sql = "select a.matricula
		,p.apellido_paterno+' '+p.apellido_materno+' '+p.nombre as nombre
		,bc.nombre as beca
		,ba.cve_beca_cat 
		,c.nivel
		,c.nombre carrera
		,CAST(YEAR(per.fecha_inicio) as int) as ssyear
		,per.numero_periodo as np
		,periodo=(case
		when per.numero_periodo=1 then 'ENERO - ABRIL'
		when per.numero_periodo=2 then 'MAYO - AGOSTO'
		when per.numero_periodo=3 then 'SEPTIEMBRE - DICIEMBRE' end )
		
		from beca_asignada ba
		inner join beca_cat bc on bc.cve_beca_cat = ba.cve_beca_cat
		inner join alumno a on a.matricula = ba.matricula
		inner join persona p on p.cve_persona = a.cve_alumno
		inner join periodo per on per.cve_periodo=ba.cve_periodo
		inner join alumno_grupo ag on a.matricula = ag.matricula
		inner join grupo g on ag.cve_grupo = g.cve_grupo and g.cve_periodo = ba.cve_periodo
		inner join carrera c on g.cve_carrera = c.cve_carrera
		where ba.cve_beca_cat in (1,2,3,4,5,6,7)	
		order by 1,7,8
		";
	
		return $this->becas_util->utilerias->getAllBecados($sql);
		// Testing
		//echo $sql;
		
	}
}