<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/../libraries/db/db.php";

class Alumnos
{
	private $_matricula;

	public function setMatriculaAlumno($matricula){
		$this->_matricula = $matricula;		
	}
	
	public function getMatriculaAlumno(){
		return $this->_matricula;
	}
	
	
	
	public function getNombreAlumnoByMatricula($matricula){
		global $DBSito;
	
		$sql = "select p.nombre+' '+p.apellido_paterno+' '+p.apellido_materno as nombre from persona p
				inner join alumno a on p.cve_persona = a.cve_alumno
				where a.matricula = {$matricula}
				";
	
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['nombre'];
		
	}
	
	public function esAlumno($matricula){
		global $DBSito;
		
		$sql = "select [status] from alumno where matricula = {$matricula}
				";
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['status'];
	}
	
	public function estaBecado($matricula, $periodo){
		global $DBSito;
		
		$sql = "select 1 as becado from beca_asignada where matricula = $matricula and cve_periodo = $periodo
		";
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['becado'];
		
	}
	
	public function estaInscrito($matricula){
		global $DBSito;
	
		$sql = "select cve_periodo from inscripcion where cve_periodo = (select reinscripcion+1 as cve_periodo from periodo where activo = 1) and matricula = {$matricula}
		";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['cve_periodo']?true:false;
	}
	
	public function tieneBaja($matricula){
		global $DBSito;
	
		$sql = "select [status] from alumno where matricula = {$matricula}
		";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['status'];
	}
	
	public function tieneBecaExterna($matricula){
		global $DBSito;
	
		$sql = "select top 1 cve_beca_cat as beca, fecha_fin, getdate() as hoy from beca_asignada where matricula = {$matricula} order by cve_periodo desc";
		
		$rs = $DBSito->Execute($sql);
		if (($rs->fields['fecha_fin'] < $rs->fields['hoy'])){
			return $rs->fields['beca'];
		}elseif ($rs->fields['beca'] == ''){
			return 0;
		}else{
			return 0;
		}
		
	}
			
	public function getNombreStatusAlumno($nombre){
		global $DBSito;
		
		$sql = "select descripcion from	status_alumno where nombre = '$nombre'";
		
		$rs = $DBSito->Execute ( $sql );
		
		if ($rs && $rs->RecordCount () > 0) {
			return $rs->fields['descripcion'];
		} else {
			return false;
		}
	}
	
	public function getCarreras(){
		global $DBSito;
		
		$sql = "select cve_carrera as id,nombre as descripcion 
				from carrera
				where activo = 1
				order by nivel,nombre";
		
		$rs = $DBSito->Execute($sql);
		
		if ($rs && $rs->RecordCount () > 0) {
			return $rs->getArray();
		} else {
			return false;
		}
	}
	
	public function getTiposBeca(){
		global $DBSito;
		
		$sql = "select id,descripcion from beca_tipo where id in (1,2,3)";
		
		$rs = $DBSito->Execute($sql);
		
		if ($rs && $rs->RecordCount () > 0) {
			return $rs->getArray();
		} else {
			return false;
		}
	}
	
	public function getTiposBecaFull(){
		global $DBSito;
	
		$sql = "select id, nombre from beca_tipo";
	
		$rs = $DBSito->Execute($sql);
	
		if ($rs && $rs->RecordCount () > 0) {
			return $rs->getArray();
		} else {
			return false;
		}
	}
	
	
	public function getCategoriaBecaFull(){
		global $DBSito;
	
		$sql = "select cve_beca_cat as id, nombre as descripcion from beca_cat";
	
		$rs = $DBSito->Execute($sql);
	
		if ($rs && $rs->RecordCount () > 0) {
			return $rs->getArray();
		} else {
			return false;
		}
	}
		
	public function printCarrerasHTML(){
		$carreras = $this->getCarreras();
		$myHtml = '<select id="elegir_carrera" name="elegir_carrera" class="form-control">';
		$myHtml .= '<option value="0">Selecciona una carrera</option>';
		foreach ($carreras as $c){
			$myHtml .= "<option value=\"{$c['id']}\">{$c['descripcion']}</option>";
		}
		
		$myHtml .= '</select>';
		return $myHtml;
	}
	
	public function printTiposBecaHTML(){
		$tipos_beca = $this->getTiposBeca();
		$myHtml = '<select id="elegir_tipo_beca" name="elegir_tipo_beca" class="form-control">';
		$myHtml .= '<option value="0">Selecciona un tipo de Beca</option>';
		foreach ($tipos_beca as $b){
			$myHtml .= "<option value=\"{$b['id']}\">{$b['descripcion']}</option>";
		}
		
		$myHtml .= '</select>';
		return $myHtml;
	}
	
	
	/* ----------------------------------------------------------------------- */
	/*                                                                         */
	/* ---------------- En espera a las ENCUESTAS    ------------------------- */
	/*                                                                         */
	/* ----------------------------------------------------------------------- */
	
	
	public function hizoEncuesta($matricula){
	global $DBSito;
		
		$sql = "select cve_encuestado from encuestado e
				inner join alumno a on a.cve_alumno = e.cve_persona
				where matricula = '{$matricula}' and cve_encuesta = 95
				and fecha_registro > 
				(select fecha_publicacion from beca_convocatoria
				where id = (select max(id) from beca_convocatoria))";
		
		$rs = $DBSito->Execute($sql);
		
		if ($rs && $rs->RecordCount () > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}