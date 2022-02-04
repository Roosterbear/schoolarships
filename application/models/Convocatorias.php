<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/../libraries/db/db.php";
require_once __DIR__ . "/Utilerias.php";

class Convocatorias
{
	// NUEVA convocatoria
	private $_tipo_beca;
	private $_periodo_publicacion;
	private $_periodo_aplicacion;
	private $_fecha_publicacion;
	private $_fecha_vencimiento;	
	private $_fecha_resultados;
	private $_descripcion;
	private $_fecha_limite_inscripcion;
	
	// ACTUALIZAR un campo de convocatoria
	private $_id;	
	private $_campo;
	private $_dato;
	
	// CAMPOS actualizados de convocatoria seleccionada
	private $_id_to_display_data;
	private $_campo_to_display_data;
	
	public $utilerias;
	
	public function __construct(){
		$this->utilerias = new Utilerias();
	}
	
	/* --------------------------------------------*/
	/* Variables para crear una nueva convocatoria */
	/* --------------------------------------------*/
		
	public function setTipoBeca($tipo_beca){
		$this->_tipo_beca = $tipo_beca;
	}
	
	public function setPeriodoPublicacion($periodo_publicacion){
		$this->_periodo_publicacion = $periodo_publicacion;
	}
	
	public function setPeriodoAplicacion($periodo_aplicacion){
		$this->_periodo_aplicacion = $periodo_aplicacion;
	}
	
	public function setFechaPublicacion($fecha_publicacion){
		$this->_fecha_publicacion = $fecha_publicacion;
	}

	public function setFechaVencimiento($fecha_vencimiento){
		$this->_fecha_vencimiento = $fecha_vencimiento;
	}
	
	public function setFechaResultados($fecha_resultados){
		$this->_fecha_resultados = $fecha_resultados;
	}

	public function setDescripcion($descripcion){
		$this->_descripcion = $descripcion;
	}	
	
	public function setFechaLimiteInscripcion($fecha_limite_inscripcion){
		$this->_fecha_limite_inscripcion = $fecha_limite_inscripcion;
	}
	
	/* --------------------------------------------*/
	
	public function getDescripcion(){
		return $this->_descripcion_to_display_data;	
	}
	
	public function getTiposBeca(){
		global $DBSito;
		
		$sql = "select * from beca_tipo where id < 4 or id = 8";
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->getArray();
	}
	
	
	/* ----------------------------- */
	/* Crear una NUEVA convocatoria  */
	/* ----------------------------- */
	public function insertConvocatoria(){
		global $DBSito;
		
		$sql = "insert into beca_convocatoria 
				(id_beca_tipo
				,fecha_publicacion
				,fecha_vencimiento
				,fecha_resultados
				,descripcion
				,periodo_publicacion
				,periodo_aplicacion
				,fecha_limite_inscrito)
				values(
				{$this->_tipo_beca}
				,'{$this->_fecha_publicacion}'
				,'{$this->_fecha_vencimiento}'
				,'{$this->_fecha_resultados}'
				,'{$this->_descripcion}'
				,{$this->_periodo_publicacion}
				,{$this->_periodo_aplicacion}
				,'{$this->_fecha_limite_inscripcion}'
				)";
		$rs = $DBSito->Execute($sql);
		return true;
	}
	
	
	/* --------------------------------------- */
	/* Actualizar un CAMPO de una convocatoria */
	/* --------------------------------------- */
	public function updateConvocatoria($data){
		global $DBSito;
			
		$this->_id = $data['id'];
		$this->_campo = $data['campo'];
		$this->_dato = trim($data['dato']);
			
		$sql = "update beca_convocatoria set {$this->_campo} = '{$this->_dato}' where id = {$this->_id}";
	
		$rs = $DBSito->Execute($sql);
	
		return true;	
	}
	
	
	/* ----------------------- */
	/* BORRAR Una Convocatoria */
	/* ----------------------- */
	public function deleteConvocatoria($id){
		global $DBSito;
			
		$this->_id = $id;	
			
		$sql = "delete beca_convocatoria where id = {$this->_id}";
		
		$rs = $DBSito->Execute($sql);
	
		return true;
	}
	
	
	/* ------------------------------------------------------- */
	/* Obtener la informacion de UNA convocatoria seleccionada */
	/* ------------------------------------------------------- */
	public function getDataToDisplay($id,$campo){
		global $DBSito;
				
		$this->_id_to_display_data = $id;
		$this->_campo_to_display_data = $campo;
		
		if (($this->_campo_to_display_data === 'fecha_publicacion') || ($this->_campo_to_display_data === 'fecha_vencimiento') || ($this->_campo_to_display_data === 'fecha_resultados')){
			$this->_campo_to_display_data = "convert(char(10),".$this->_campo_to_display_data.",126)";
		}
		
		$sql = "select {$this->_campo_to_display_data}				
				as dato				
				from beca_convocatoria				
				where id = {$this->_id_to_display_data}";
		
		$rs = $DBSito->Execute($sql);		
		return $rs->fields['dato'];		
	}
	
	
	/* ------------------------------------------------- */
	/* Obtener la informacion de TODAS las convocatorias */
	/* ------------------------------------------------- */
	public function getConvocatorias($id="0"){
		global $DBSito;
		
		$query_agregado = $id>0?" where id = {$id} ":"";
		// descripcion - id - id_tipo - publicacion - vencimiento - resultados - aplicacion - periodo
		$sql = "select descripcion
				,id
				,id_beca_tipo as id_tipo
				,
				case id_beca_tipo
					when 1 then 'ACADEMICA'
					when 2 then 'DEPORTIVA / CULTURAL'
					when 3 then 'TRANSPORTE'
					when 8 then 'VULNERABILIDAD'
				end as tipo
				,convert(char(10),fecha_publicacion,126) as publicacion
				,convert(char(10),fecha_vencimiento,126) as vencimiento
				,convert(char(10),fecha_resultados,126) as resultados
				,periodo_aplicacion as aplicacion
				,
				case periodo.numero_periodo
					when 1 then 'ENE - ABR '+convert(char(4),fecha_resultados,126)
					when 2 then 'MAY - AGO '+convert(char(4),fecha_resultados,126)
					when 3 then 'SEP - DIC '+convert(char(4),fecha_resultados,126)
				end as periodo
				,convert(char(4),fecha_resultados,126) as a
				,fecha_limite_inscrito as limite_inscrito
				from beca_convocatoria
				inner join periodo on cve_periodo = periodo_aplicacion
				{$query_agregado}
				order by id desc";
		
		$rs = $DBSito->Execute($sql);
		return $rs->getArray();
	}
	
	public function getConvocatoriasByTipo($tipo){
		global $DBSito;
	
		// id - descripcion
		$sql = "select id,descripcion from beca_convocatoria
		where id_beca_tipo = {$tipo} 	
		and fecha_publicacion < getdate()
		and fecha_vencimiento > getdate()		
		order by id desc
		";
	
		$rs = $DBSito->Execute($sql);
		return $rs->getArray();
	}
	
	
	public function printConvocatoriasByTipo($tipo){		
		$convocatorias = $this->getConvocatoriasByTipo($tipo);
		$myHtml = '<select id="elegir_convocatoria" name="elegir_convocatoria" class="form-control">';
		$myHtml .= '<option value="0">Selecciona una convocatoria</option>';
		
		foreach ($convocatorias as $c){
			$myHtml.= "<option value=\"{$c['id']}\">{$c['descripcion']}</option>";
		}
		
		$myHtml .= '</select>';
		return $myHtml;
	}
		
	
	public function printDatosConvocatoria($id){
		if ($id == 0){return '';}
		$data = $this->getConvocatorias($id);
		
		$publicacion = '';
		$vencimiento = '';
		$resultados = '';
		$periodo = '';
		$aplicacion = '';
		$limite_inscrito = ''; 
		
		foreach ($data as $d){
			$publicacion = $d['publicacion'];
			$vencimiento = $d['vencimiento'];
			$resultados = $d['resultados'];
			$periodo = $d['periodo'];
			$aplicacion = $d['aplicacion'];
			$limite_inscrito = $d['limite_inscrito'];
		}
		
		$html_code = "<div class=\"row\">";
		$html_code .= "<div class=\"col-lg-12\">";
		$html_code .= "<div class=\"col-lg-4\">Fecha Inicio:<br />";
		$html_code .= "<input type=\"text\" id=\"data_fecha_inicio\" name=\"data_fecha_inicio\" value=\"{$publicacion}\" disabled=\"disabled\">";
		$html_code .= "</div>";
		$html_code .= "<div class=\"col-lg-4\">Fecha Vencimiento:<br />";
		$html_code .= "<input type=\"text\" id=\"data_fecha_vencimiento\" name=\"data_fecha_vencimiento\" value=\"{$vencimiento}\" disabled=\"disabled\">";
		$html_code .= "</div>";
		$html_code .= "<div class=\"col-lg-4\">Fecha Resultados:<br />";
		$html_code .= "<input type=\"text\" id=\"data_fecha_resultados\" name=\"data_fecha_resultados\" value=\"{$resultados}\" disabled=\"disabled\">";
		$html_code .= "</div>";
		$html_code .= "<div class=\"col-lg-4\">Periodo de Aplicaci&oacute;n:<br />";
		$html_code .= "<input type=\"text\" id=\"data_periodo_aplicacion\" name=\"data_periodo_aplicacion\" value=\"{$periodo}\" disabled=\"disabled\">";
		$html_code .= "</div>";
		$html_code .= "<div class=\"col-lg-4\">No. Periodo de Aplicaci&oacute;n:<br />";
		$html_code .= "<input type=\"text\" id=\"data_num_periodo_aplicacion\" name=\"data_num_periodo_aplicacion\" value=\"{$aplicacion}\" disabled=\"disabled\">";
		$html_code .= "</div></div>";
				
		$html_code .= "<div class=\"row\">";
		$html_code .= "<div class=\"col-lg-12\">";
		$html_code .= "<br><div><strong>REQUISITOS:</strong></div>";
		$html_code .= "</div></div>";
		
		$html_code .= "<div class=\"row\">";
		$html_code .= "<div class=\"col-lg-12\">";		
		$html_code .= "<br><div><u><strong>Renovantes:</u></strong></div>";
		$html_code .= "<div class=\"col-lg-6 requisitos\"><ul>";
		$html_code .= "<li>Tener promedio m&iacute;nimo de 8.5 (periodo previo de estudios)</li>";
		$html_code .= "<li>Tener Liberado su <strong class=\"verde\">Servicio Social</strong></li>";
		$html_code .= "<li>Ser alumno regular</li>";
		$html_code .= "<li id=\"liga\"><a href=\"http://sito-misc.app.utags.edu.mx/alumno/index.php/EstudioSocioeconomico/Panel?uid=".$_SESSION['uid']."&sid=".$_SESSION['sid']."\" target=\"_self\">Realizar estudio socioeconomico al momento de hacer su solicitud en SITO <strong class=\"rojo\"><i class=\"fa fa-arrow-left\"></i>Da click</strong></a></li>";
						
		$html_code .= "<li>Estar inscritos antes del d&iacute;a ".$limite_inscrito."</li>";
		$html_code .= "<li>No tener adeudo en talleres, biblioteca y cajas.</li>";
		$html_code .= "<li>No tener amonestaciones en expediente, no haber reprobado materias, ni tener intercuatrimestrales.</li>";
		$html_code .= "<li>Los estudiantes que soliciten beca de transporte (esta beca les aplica <strong class=\"rojo\"> &uacute;nicamente </strong>a los alumnos que viven fuera de la zona urbana) 
				deber&aacute;n enviar copia de comprobante de domicilio (ejemplo recibo de luz, agua o tel&eacute;fono) m&aacute;ximo tres meses de antig&uuml;edad en formato PDF, con sus datos (nombre, matr&iacute;cula y carrera), 
				al correo becas@utags.edu.mx</li>";				
		$html_code .= "</ul></div>";

		$html_code .= "<div><u><strong>Nuevos solicitantes:</u></strong></div>";
		$html_code .= "<div class=\"col-lg-6 requisitos\"><ul>";
		$html_code .= "<li>Tener promedio m&iacute;nimo de 8.5 en el periodo previo de estudios (promedio de bachillerato para nuevo ingreso)</li>";
		$html_code .= "<li>Ser alumno regular</li>";
		$html_code .= "<li>Realizar estudio socioecon&oacute;mico al momento de hacer su solicitud en SITO</li>";
		$html_code .= "<li>Estar inscritos antes del d&iacute;a ".$limite_inscrito.".</li>";
		$html_code .= "<li>Los estudiantes que soliciten beca de transporte (esta beca les aplica <strong class=\"rojo\"> &uacute;nicamente </strong>a los alumnos que viven fuera de la zona urbana)
				deber&aacute;n enviar copia de comprobante de domicilio (ejemplo recibo de luz, agua o tel&eacute;fono) m&aacute;ximo tres meses de antig&uuml;edad en formato PDF, con sus datos (nombre, matr&iacute;cula y carrera),
				al correo becas@utags.edu.mx</li>";
		$html_code .= "</ul></div>";
		$html_code .= "</div></div>";
		
		$html_code .= "<strong>* Alumnos ingreso a partir de septiembre 2017: </strong>Cumplir con 33 horas de servicio social  <i>(revisar opciones en el depto. de Vida Universitaria)</i>";
		$html_code .= "<br><strong>* Alumnos reinscritos: </strong>Cumplir con 20 horas de servicio social <i>(revisar opciones en el depto. de Vida Universitaria)</i>";
		
		
	
		return $html_code;
	}
	
	
	public function yaSolicitoBecaEnElPeriodo($matricula,$periodo){
		global $DBSito;
		
		
		$sql = "select fecha_solicitud
				from beca_solicitud
				inner join beca_convocatoria on id_convocatoria_beca = id
				where matricula = {$matricula}
				and id_periodo_aplicacion = {$periodo}
				";
	
		$rs = $DBSito->Execute($sql);
		$fecha = '';
		$mensaje = '';
		
		if ($rs){
			while (!$rs->EOF){			
				$fecha = $rs->fields['fecha_solicitud'];
				$mensaje = "Ya solicitaste una convocatoria para dicho periodo el {$fecha}";
				$rs->MoveNext();
			}
		}
		
		return $mensaje;
	}
	
	public function estaEnFechaParaSolicitar($id){
		global $DBSito;
		
		$sql = "select periodo_aplicacion
				from beca_convocatoria		
				where id = {$id}
				and(fecha_vencimiento < getdate() 
				or fecha_publicacion >= getdate())
				";
		
		$rs = $DBSito->Execute($sql);
		$mensaje = '';
		if ($rs && $rs->RecordCount() > 0){			
			$mensaje = "Esta solicitud no esta en fecha";
			$rs->MoveNext();
		}
		
		return $mensaje;		
	}
	
	public function getPeriodoAplicacionDeConvocatoria($id){
		global $DBSito;
		
		$sql = "select top 1 periodo_aplicacion 
				from beca_convocatoria 
				where id = {$id}
		";
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['periodo_aplicacion'];
	}
	
	public function insertarSolicitudDeBeca($data){
		global $DBSito;
		
		$periodo = $this->getPeriodoAplicacionDeConvocatoria($data['id']);
		$sql = "insert into beca_solicitud 
				(id_periodo_aplicacion, matricula, id_convocatoria_beca, id_status_solicitud_beca, motivos, fecha_solicitud)
				values
				({$periodo}, '{$data['matricula']}', {$data['id']}, '1', '{$data['motivos']}', getdate())				
				";
		
		$rs = $DBSito->Execute($sql);
		
		return true;
	}
	
	public function getFechaText($periodo){
		$year = $this->utilerias->getYear($periodo);
		$numero_de_periodo = $this->utilerias->getIdNumeroPeriodo($periodo);
		$texto_periodo = $this->utilerias->getTextPeriodoNumber($numero_de_periodo);
		return "{$texto_periodo} {$year} ";
	}
	
	public function mostrarHistorial($matricula){
		global $DBSito;
		    
		$sql = "select id_periodo_aplicacion as periodo
				,id_convocatoria_beca as id
				,id_beca_tipo as tipo
				,bs.matricula
				,fecha_solicitud as fecha
				,convert(char(10),fecha_resultados,105) as resultados
				,descripcion
				,(cast(id_periodo_aplicacion as varchar))+'B'+(cast(id_convocatoria_beca as varchar))+'-'+(cast(p.cve_persona as varchar))+(right((select convert(char(25),fecha_solicitud,126)),3)) as folio
				,p.nombre+' '+p.apellido_paterno+' '+apellido_materno as nombre
				,isnull(bcr.nombre,'No capturada') as rechazo
				,bcr.id as id_rechazo
				from beca_solicitud as bs
				inner join beca_convocatoria on id_convocatoria_beca = id
				inner join alumno a on bs.matricula = a.matricula 				
				inner join persona p on a.cve_alumno = p.cve_persona
				left outer join beca_causa_rechazo bcr on bcr.id = bs.id_causa_rechazo
				where bs.matricula = {$matricula}
				order by 1 desc
		";
		
		$rs = $DBSito->Execute($sql);
		
		$data = $rs->getArray();
		$html_code = $this->printHistorial($data);
		
		return $html_code;	
	}
		
	
	public function printHistorial($data){
		$periodo = '';		
		$id = '';	
		$matricula = '';
		$fecha = '';
		$resultados = '';
		$descripcion = '';
		$folio = '';
		$nombre = '';
		$tipo = '';
		$rechazo = '';
		
		
		$html_code = "<div class=\"col-lg-12 text-center\">";
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">No. Periodo</th>";
		$html_code .= "<th class=\"text-center\">Descripci&oacute;n Convocatoria</th><th class=\"text-center\">Fecha Solicitud</th>";
		$html_code .= "<th class=\"text-center\">Causa de rechazo</th><th class=\"text-center\">Folio </th>";
		$html_code .= "<th class=\"text-center\">Imprimir</th></tr>";
		
		foreach ($data as $d){
			
			$periodo = $this->getFechaText($d['periodo']);
			
			$id = $d['id'];		
			$matricula = $d['matricula'];
			$fecha = $d['fecha'];
			$resultados = $d['resultados'];
			$descripcion = $d['descripcion'];			
			$folio = $d['folio'];
			$nombre = $d['nombre'];
			$tipo = $d['tipo'];
			$rechazo = $d['rechazo'];
			$rechazado = $d['id_rechazo']>0?'mystrong':'myitalic gris';
			
			$html_code .= "<tr>";
			$html_code .= "<td>{$periodo}</td>";			
			$html_code .= "<td>{$descripcion}</td>";
			$html_code .= "<td>{$fecha}</td>";
			$html_code .= "<td class=\"{$rechazado}\"}>{$rechazo}</td>";
			$html_code .= "<td>{$folio}</td>";
			$html_code .= "<td><a href=\"Solicitud/imprimirFolio/{$matricula}/{$folio}/{$resultados}/{$tipo}/\" data-toggle=\"modal\" data-target=\"#modal_folio\">";
			$html_code .= "<span class=\"text-info\"><i class=\"fa fa-print fa-2x\" aria-hidden=\"true\"></i></span></a></td>";
			$html_code .= "</tr>";
		}
		
		$html_code .= "</table>";
		$html_code .= "</div>";
		
		
		return $html_code;
	}
	
	public function mostrarAsignadas($matricula){
		// Se utiliza en Solicitud de Becas
		global $DBSito;
	
		$sql = "select ba.cve_periodo as periodo, ba.fecha as fecha, bc.nombre as descripcion from beca_asignada ba
				inner join beca_cat bc on ba.cve_beca_cat = bc.cve_beca_cat
				where matricula = {$matricula}
				order by 1 desc
		";
	
		$rs = $DBSito->Execute($sql);
	
		$data = $rs->getArray();
		$html_code = $this->printAsignadas($data);
	
		return $html_code;
	}
	
	public function printAsignadas($data){
		$periodo = '';		
		$fecha = '';
		$descripcion = '';
	
		$html_code = "<div class=\"col-lg-12 text-center\">";
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">No. Periodo</th>";
		$html_code .= "<th class=\"text-center\">Descripci&oacute;n de Beca</th><th class=\"text-center\">Fecha de Asignaci&oacute;n</th></tr>";
	
		foreach ($data as $d){
			$periodo = $this->getFechaText($d['periodo']);		
			$descripcion = $d['descripcion'];
			$fecha = $d['fecha'];
				
			$html_code .= "<tr>";
			$html_code .= "<td>{$periodo}</td>";			
			$html_code .= "<td>{$descripcion}</td>";
			$html_code .= "<td>{$fecha}</td>";
			$html_code .= "</tr>";
		}
	
		$html_code .= "</table>";
		$html_code .= "</div>";
	
	
		return $html_code;
	}
}