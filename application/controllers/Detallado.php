<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detallado extends CI_Controller
{
	
	public $becas_util;
	
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
		$data['periodo_siguiente'] = @$this->becas_util->utilerias->getPeriodoSiguiente();
		
		$data['id_periodo_anterior'] = @$this->becas_util->utilerias->getIdPeriodoAnterior();
		$data['id_periodo_actual'] = @$this->becas_util->utilerias->getIdPeriodoActual();
		$data['id_periodo_siguiente'] = @$this->becas_util->utilerias->getIdPeriodoSiguiente();
		
		$data['carreras'] = @$this->becas_util->alumnos->getCarreras();
		$data['tipos_beca'] = @$this->becas_util->alumnos->getTiposBeca();
		
		$this->load->view('asignacionVw',$data);
		$this->load->view('footer');
	
	}
	
	public function printSolicitantes(){
		
		$periodo = '';
		$carrera = '';
		$tipo = '';
		$excel = 0;
		
		if($_REQUEST){
			$periodo = $_REQUEST['periodo'];
			$carrera = $_REQUEST['carrera'];
			$tipo = $_REQUEST['tipo'];
			if (isset($_REQUEST['excel'])){
				$excel = $_REQUEST['excel'];
			}else{
				$excel = 0;
			}
		}
		
		$carrera_sql = $carrera == 0?'':'and gpo.cve_carrera = '.$carrera;
		$tipo_sql = $tipo == 0?'':'and bc.id_beca_tipo = '.$tipo;
		$periodo_servicio = (($periodo)-1);
		// matricula - nombre - sexo - beca_solicitada - cuatrimestre - carrera - promedio - inscripcion - debe
		// intercuatrimestrales - adeudos - renovante - reinscrito - servicio_social - porcentaje		
		// materias - tipo - id_beca_convocatoria - estado_beca - estatus_beca - beca_asignada
		$sql = "		
		declare @periodo_servicio int;
		set @periodo_servicio = {$periodo_servicio};
				
		SELECT distinct top 10000 bs.matricula as matricula				
		,p.apellido_paterno+' '+p.apellido_materno+' '+p.nombre as nombre
		,p.sexo as sexo
		,bt.descripcion as beca_solicitada
		,gpo.numero_cuatrimestre as cuatrimestre				
		,gpo.carrera as carrera
		,gpo.nivel as nivel
		,promedio = (case when gpo.numero_cuatrimestre=1 and gpo.cve_carrera<=10 then dg.promedioBachillerato else isnull(pc.promedio,0) end)
		,CONVERT(VARCHAR(10), ins.fecha_pago, 103) as inscripcion
		,au.adeudos as debe
		,case when ec.estatus>=1 then 'Si' else 'No' end as intercuatrimestrales
		,case when au.adeudos > 0 then 1 else 0 end as adeudos
		,case when ba.cve_beca_cat>=1 and gpo.nivel<>2 and gpo.numero_cuatrimestre<>7 then 'Si' else 'No' end as renovante
		,case when ins.matricula is null then 'NO' else 'Si' end as reinscrito
		,case when ss.matricula <> '' then 'Si' else 'No' end as servicio_social
		,case when promedio BETWEEN 8.50 AND 8.99 then '50' when promedio BETWEEN 9.00 AND 9.59 then '75' when promedio >= 9.60  then '100' else 'N/A' end as porcentaje		
		,(case when isnull(re.no_materias,0)=0 then 'Todas' else 'Algunas' end ) as materias
		,case when re.matricula is null then 'NO' else 'Si' end as reingreso
		,bc.id_beca_tipo as tipo
		,bc.id as id_beca_convocatoria
		,bss.descripcion as estado_beca
		,bs.id_status_solicitud_beca as estatus_beca
		,bcat.nombre as beca_asignada
		,bs.motivos
		from beca_solicitud bs
		inner join beca_convocatoria bc on bs.id_convocatoria_beca=bc.id
		inner join beca_tipo bt on bc.id_beca_tipo=bt.id
		inner join alumno as al on al.matricula=bs.matricula
		inner join persona as p on p.cve_persona=al.cve_alumno
		inner join beca_status_solicitud bss on bss.id=bs.id_status_solicitud_beca
		left outer join inscripcion as ins on al.matricula = ins.matricula and ins.cve_periodo = bc.periodo_aplicacion
		
		left outer join beca_asignada bag on bag.matricula=bs.matricula and bag.cve_periodo= @periodo_servicio + 1
		left outer join beca_cat bcat on bcat.cve_beca_cat=bag.cve_beca_cat
		left outer join beca_servicio_social ss on ss.matricula=al.matricula and ss.periodo = @periodo_servicio
		left outer join reingreso re on re.matricula=bs.matricula and re.cve_periodo= @periodo_servicio + 1
		
		left outer join ( 
		select ag.matricula,g.numero_cuatrimestre,c.nombre as carrera,g.cve_carrera,c.nivel
		from  grupo g
		inner join (select matricula,max(cve_grupo) as cve_grupo from alumno_grupo  group by matricula ) ag on ag.cve_grupo=g.cve_grupo
		inner join  carrera as c on c.cve_carrera=g.cve_carrera
		)gpo on gpo.matricula=bs.matricula	
		
		left outer join (select ac.matricula,round (sum(calificacion_final)/count(calificacion_final),2) as Promedio from alumno_clase ac
		inner join clase c on c.cve_clase=ac.cve_clase 
		where c.cve_periodo=@periodo_servicio
		group by ac.matricula) pc on pc.matricula=al.matricula
		
		left outer join admision.dbo.datosGenerales as dg on dg.idAdmision=al.cve_alumno
		
		left outer join (select distinct ac.matricula,count (cve_status) as estatus from alumno_clase ac
		inner join clase c on c.cve_clase=ac.cve_clase 
		where c.cve_periodo=@periodo_servicio
				and ac.cve_status in (3,4,5,6,7,10,11,12,13,14,16)
		group by ac.matricula) as ec on ec.matricula=al.matricula
		
		left outer join (select x.cve_cliente,sum(x.monto_adeudo+isnull (monto_cargo,0)) as adeudos from cxc x
		where x.[status]=1
		group by x.cve_cliente) au on au.cve_cliente=al.cve_alumno
		
		left outer join beca_asignada as ba on ba.matricula=al.matricula 
			and bs.matricula=ba.matricula 
			and ba.cve_beca_cat in (1,2,3,4,5,6,7)
			and ba.cve_periodo=bs.id_periodo_aplicacion-1
		
		where bs.id_periodo_aplicacion={$periodo} 		
		{$carrera_sql}
		{$tipo_sql}
		";
		
		//print_r($sql);
		//echo $sql; //<-CHECAR QUERY
		$this->becas_util->utilerias->setPeriodo($periodo);
		
		if ($excel){
			echo $this->becas_util->utilerias->getSolicitantesDeBecaExcel($sql);						
		}else{
			echo $this->becas_util->utilerias->getSolicitantesDeBeca($sql);			
		}
				
	}
	
	public function imprimirMotivos($matricula){		
		$periodo  = $this->becas_util->utilerias->getIdPeriodoActual();
		$motivos = $this->becas_util->utilerias->getMotivos($matricula, $periodo);	
		$encuesta = $this->becas_util->utilerias->getEncuesta($matricula);
		
		$data['periodo'] = $periodo;
		$data['motivos'] = $motivos;
		$data['encuesta'] = $encuesta;
		$data['matricula'] = $matricula;
		
		$this->load->view('motivosMd',$data);
	}
	
	
}

