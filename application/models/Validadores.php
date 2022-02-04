<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/../libraries/db/db.php";

class Validadores
{
	public function getPersona($usuario){
		global $DBSito;
				
		$sql = "select p.cve_persona
		from persona p
		inner join empleado e on p.cve_persona = e.cve_persona
		where e.cve_empleado = {$usuario}";		
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['cve_persona'];
	}
	
	public function getNombreUsuario($usuario){
		global $DBSito;
	
		$sql = "select nombre+' '+apellido_paterno+' '+apellido_materno as nombre
		from persona
		where cve_persona = (select cve_persona from empleado where cve_empleado = '{$usuario}')";
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['nombre'];
	}	
	
	public function esValidador($usuario){
		global $DBSito;
	
		$sql = "select cve_persona from usuario_grupo_seguridad where cve_persona = (select top 1 p.cve_persona as id
				from persona p
				inner join empleado e on p.cve_persona = e.cve_persona
				inner join usuario u on u.cve_persona = p.cve_persona
				where e.cve_empleado = '{$usuario}')
				and cve_grupo_seguridad = 239
		";
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['cve_persona'];
	}
	
	public function agregarUsuario($usuario){
		global $DBSito;
			
		$empleado = $this->getPersona($usuario);
		$sql = "insert into usuario_grupo_seguridad 
		(cve_persona,cve_grupo_seguridad) 
		values 
		({$empleado},239)";
		$rs = $DBSito->Execute($sql);
	
		return $this->getPersona($usuario);
	}
	
	public function borrarUsuario($usuario){
		global $DBSito;
	
		$esValidador = ($this->esValidador($usuario)>0)?1:0;
		$sql = "delete from usuario_grupo_seguridad
		where cve_grupo_seguridad = 239
		and cve_persona =
		(select cve_persona	from empleado where cve_empleado = '{$usuario}')
		";
	
		$rs = $DBSito->Execute($sql);
		if ($esValidador == 1){$this->borrarFiltros($usuario);}
		return $esValidador;
	}
	
	public function borrarFiltros($usuario){
		global $DBSito;		
		
		// Borrar tipos de becas
		$sql = "delete from 
		usuario_validador_beca 
		where usuario = {$usuario}
		";
		$rs = $DBSito->Execute($sql);

		// Borrar carreras		
		$sql = "delete from
		beca_validacion_carrera_usuario
		where id_usuario = {$usuario}
		";
		$rs = $DBSito->Execute($sql);
		
		// Borrar restricciones		
		$sql = "delete from
		beca_validador_restriccion 
		where id_empleado = {$usuario}
		";
		$rs = $DBSito->Execute($sql);
		
		return true;
	}
	
	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	/* ----- MODIFICAR LO QUE PUEDE VER EL VALIDADOR ----- */
	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	
	public function administrarFiltros($data){
		global $DBSito;
			
		$DBSito->debug = true;
		$usuario = $data['usuario'];
		$validacion = $data['validacion'];
		$dato = $data['dato'];
		$borrar = $data['borrar'];
		
		$query1 = $borrar == 1?'delete from ':'insert into ';
		$tabla = $validacion == 1?'usuario_validador_beca ':($validacion == 2?'beca_validacion_carrera_usuario ':($validacion == 3?'beca_validador_restriccion ':''));
		
		if ($borrar == 1){
			$campo1 = $validacion == 1?'usuario':($validacion == 2?'id_usuario':($validacion == 3?'id_empleado':''));
			$campo2 = $validacion == 1?'beca':($validacion == 2?'id_carrera':($validacion == 3?'id_restriccion':''));
			
			if ($validacion == 2){
				$query2 = "where {$campo1} = {$usuario} and {$campo2} in {$this->carrerasPorCoordinacion($dato,1)}";
			}else{
				$query2 = "where {$campo1} = {$usuario} and {$campo2} = {$dato}";
			}
		// Agregar Filtros
		}else{
			$campos = $validacion == 1?'usuario,beca':($validacion == 2?'id_usuario,id_carrera':($validacion == 3?'id_empleado,id_restriccion':''));
			$query2 = "({$campos}) values ('{$usuario}','{$dato}')"	;
			
			if ($validacion == 2){
				$carreras = $this->carrerasPorCoordinacion($dato, 0);
				foreach ($carreras as $c){
					$query2 = "({$campos}) values ('{$usuario}','{$c}')";
					$sql = $query1.$tabla.$query2;					
					$rs = $DBSito->Execute($sql);
				}		
				return true;
			}// Fin Agregar carreras
		}// Fin Agregar
		
		$sql = $query1.$tabla.$query2;
		
		$rs = $DBSito->Execute($sql);
				
	}
	
	public function carrerasPorCoordinacion($coordinacion,$borrar){
				
			//	aarh
			if ($coordinacion == 1) return $borrar==1?"(1,11,2,25)":[1,11,2,25];
			//	dnam
			if ($coordinacion == 2) return $borrar==1?"(3,12,24)":[3,12,24];
			//	mai
			if ($coordinacion == 3) return $borrar==1?"(4,13,5)":[4,13,5];
			//	mt
			if ($coordinacion == 4) return $borrar==1?"(7,14,17)":[7,14,17];
			//	piam
			if ($coordinacion == 5) return $borrar==1?"(9,15,8,18)":[9,15,8,18];
			//	tics
			if ($coordinacion == 6) return $borrar==1?"(10,16)":[10,16];
	}
	
	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	/* ----- VERIFICAR SI EL VALIDADOR TIENE UN FILTRO ----- */
	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	
	public function getFiltros($data){
		$usuario = $data['usuario'];
		$filtro = $data['filtro'];
		
		
		if ($filtro == '1'){
			return $this->printFiltrosBecas($usuario);
		}
		
		if ($filtro == '2'){
			return $this->printFiltrosCarreras($usuario);	
		}
		
		if ($filtro == '3'){
			return $this->printFiltrosRestricciones($usuario);	
		}
	}
	
	public function printFiltrosBecas($usuario){
		$texto = '';
		$chequeo = 'checked = \"checked\"';
		
		$ids = ['','beca_academica_mod','beca_deportiva_mod','beca_transporte_mod'];
		$nombres = ['','Becas Acad&eacute;micas','Becas Deportivas / Culturales','Becas Transporte'];
		for ($i = 1; $i <= 3; $i++) {
			$switch = (($this->getFiltrosBecas($usuario, $i)) == 1?$chequeo:'');
			$texto .= "<input type=\"checkbox\" name=\"becas_mod\" id=\"{$ids[$i]}\" {$switch}> {$nombres[$i]}<br />";
		}
		
		return $texto;		
	}
	
	// Nos devuelve los IDs de carreras de una coordinacion dada 
	public function getCarrerasCoordinacion($coordinacion){
		if ($coordinacion == '1') return '(1,11,2,25)';
		if ($coordinacion == '2') return '(3,12,24)';
		if ($coordinacion == '3') return '(4,13,5)';
		if ($coordinacion == '4') return '(7,14,17)';
		if ($coordinacion == '5') return '(9,15,8,18)';
		if ($coordinacion == '6') return '(10,16)';
	}
	
	public function printFiltrosCarreras($usuario){		
		$texto = '';
		$chequeo = 'checked = \"checked\"';
		
		$ids = ['','aarh_mod','dnam_mod','mai_mod','mt_mod','piam_mod','tics_mod'];
		$nombres = ['','Administraci&oacute;n','Desarrollo de Negocios','Mantenimiento','Mecatr&oacute;nica','Param&eacute;dico / Procesos','Tecnolog&iacute;as de la Informaci&oacute;n'];
		for ($i = 1; $i <= 6; $i++) {
			
			$switch = (($this->getFiltrosCarreras($usuario, $this->getCarrerasCoordinacion($i))) == 1?$chequeo:'');
			$texto .= "<input type=\"checkbox\" name=\"carreras_mod\" id=\"{$ids[$i]}\" {$switch}> {$nombres[$i]}<br />";
		}
				
		return $texto;
	}
	
	public function printFiltrosRestricciones($usuario){
		$texto = '';
		$chequeo = 'checked = \"checked\"';
		
		$ids = ['','promedio_mod','servicio_mod','seleccion_mod','comprobante_mod','alumno_mod','inscrito_mod','zona_mod'];
		$nombres = ['','Promedio 8.5','Servicio Social','Formar parte de una selecci&oacute;n','Comprobante de domicilio','Ser un alumno regular','Estar inscrito','Vivir fuera de la zona urbana sin transporte'];
		for ($i = 1; $i <= 7; $i++) {
			$switch = (($this->getFiltrosRestricciones($usuario, $i)) == 1?$chequeo:'');
			$texto .= "<input type=\"checkbox\" name=\"restricciones_mod\" id=\"{$ids[$i]}\" {$switch}> {$nombres[$i]}<br />";
		}
				
		return $texto;
	}
	
	public function getFiltrosBecas($usuario,$beca){
		global $DBSito;

		$sql = "select * from usuario_validador_beca where usuario = {$usuario} and beca = {$beca}";
	
		$rs = $DBSito->Execute($sql);
	
		return ($rs && $rs->RecordCount() > 0)?1:0;
	}

	public function getFiltrosCarreras($usuario,$carrera){
		global $DBSito;
	
		// Este Query se debe llamar para cada carrera de la coordinacion
		$sql = "select * from beca_validacion_carrera_usuario where id_usuario = {$usuario} and id_carrera in {$carrera}";
	
		$rs = $DBSito->Execute($sql);
	
		return ($rs && $rs->RecordCount() > 0)?1:0;
	}
	
	public function getFiltrosRestricciones($usuario,$restriccion){
		global $DBSito;
	
		$sql = "select * from beca_validador_restriccion where id_empleado = {$usuario} and id_restriccion = {$restriccion}";
	
		$rs = $DBSito->Execute($sql);
	
		return ($rs && $rs->RecordCount() > 0)?1:0;
	}
	
	
	public function listarGrupoSeguridad(){
		global $DBSito;
		
		$sql = "select cve_empleado, nombre+' '+apellido_paterno+' '+apellido_materno as nombre from usuario_grupo_seguridad ugs
				inner join persona p on p.cve_persona = ugs.cve_persona
				inner join empleado e on e.cve_persona = p.cve_persona
				where cve_grupo_seguridad = 239 order by 2
				";
		$rs = $DBSito->Execute($sql);
		
		return $rs->getArray();
	}
	
	
	
}