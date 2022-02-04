<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/../libraries/db/db.php";
require_once __DIR__."/../libraries/PHPExcel.php";

class Utilerias
{
	

	private $_periodo;
		
	public $periodo_servicio;
	public $excel;
	
	public function __construct(){
		$this->periodo_servicio = '';
		$this->excel = new PHPExcel();
	}
	
	/* -------------------------- */
	
	
	public function setPeriodo($periodo){
		$this->_periodo = $periodo;
		return true;
	}
	
	public function getPeriodo(){
		return $this->_periodo;
	}
	
	
	
	/* --------------------------- */
	
	public function getFechaHoy(){
		global $DBSito;
	
		$sql = "select convert(char(10),getdate(),126) as fecha";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['fecha'];
	}
		
	
	// ID PERIODO DEL AÑO MAS ACTUAL
	// Para que se muestre el año mas nuevo aunque no se haya cambiado el PERIODO ACTUAL
	public function getIdPeriodoThisyear(){
		global $DBSito;
	
		$sql = "select max(cve_periodo) as periodo from periodo";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['periodo'];
	}
	
	// ID PERIODO ACTUAL
	public function getIdPeriodoActual(){
		global $DBSito;
		
		$sql = "select top 1 cve_periodo as periodo from periodo where activo = 1";
		
		$rs = $DBSito->Execute($sql);				
		
		return $rs->fields['periodo'];	
		
	}
	
	// ID PERIODO ANTERIOR
	public function getIdPeriodoAnterior(){
		return $this->getIdPeriodoActual()-1;
	}
	
	// ID PERIODO SIGUIENTE
	public function getIdPeriodoSiguiente(){
		global $DBSito;
		
		if ($this->thereIsNextPeriodo()){
			return $this->getIdPeriodoActual()+1;
		}else{
			return $this->getIdPeriodoActual();
		}
	}
	
	public function thereIsNextPeriodo(){
		global $DBSito;
		
		$idPeriodoActual = @$this->getIdPeriodoActual();
		$idPeriodoSiguiente = $idPeriodoActual + 1;
		$sql = "select top 1 cve_periodo as periodo from periodo where cve_periodo = {$idPeriodoSiguiente}";
		
		$rs = $DBSito->Execute($sql);
		
		if ($rs && $rs->RecordCount()>0){
			return true;
		}else{
			return false;
		}
	}
	
	// -----------------------------------------------------------------------------------------------------
	// -----------------------------------------------------------------------------------------------------
	// Regresa TODOS los periodos (Usado para asignar un periodo diferente en Asignación INDIVIDUAL de Beca)
	// -----------------------------------------------------------------------------------------------------
	// -----------------------------------------------------------------------------------------------------
	
	public function textoPeriodo($id){		
		$year = @$this->getYear($id);
		$np = @$this->getIdNumeroPeriodo($id);
		$text = @$this->getTextPeriodoNumber($np);
		$periodo = "".$text." ".$year;
	
		return $periodo;
	}
	
	public function cuantosPeriodosHay(){
		global $DBSito;
		
		$sql = "select max(cve_periodo) as periodos from periodo";
		
		$rs =  $DBSito->Execute($sql);
		
		return $rs->fields['periodos'];
	}
	
	public function todosLosPeriodos(){
		$cuantos_periodos_hay = $this->cuantosPeriodosHay();
				
		$periodos_con_nombre = '';
		
		for($i=$cuantos_periodos_hay;$i>=1;$i--){
			$periodos_con_nombre[$i] = $this->textoPeriodo($i);						
		}
				
		return $periodos_con_nombre;
	}
	
	// ------------------------------------------------------------------------------------------
	// Se utiliza en varias secciones del SISTEMA DE BECAS para extraer solo el año de un PERIODO
	// ------------------------------------------------------------------------------------------
	public function getYear($id){
		global $DBSito;
		
		$sql = "select convert(char(4),(select top 1 fecha_inicio from periodo where cve_periodo = {$id}),126) as year";
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['year'];
	}
	
	public function getIdNumeroPeriodo($id){
		global $DBSito;
	
		$sql = "select top 1 numero_periodo as np from periodo where cve_periodo = {$id}";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['np'];
	}
	

	public function getTextPeriodoNumber($np){
		if ($np == 1){
			return 'ENE - ABR';
		}
		
		if ($np == 2){
			return 'MAY - AGO';
		}
		
		if ($np == 3){
			return 'SEP - DIC';
		}
	}
	
	public function getPeriodoTexto($id){
		$id = $this->id;
		$year = @$this->getYear($id);
		$np = @$this->getIdNumeroPeriodo($id);
		$text = @$this->getTextPeriodoNumber($np);
		$periodo = "".$text." ".$year;
		
		return $periodo;
	}
	
	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	/* ESTOS 3 PERIODOS SE UTILIZAN PARA CREAR CONVOCATORIAS */
	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	
	// Current period
	public function getPeriodoActual(){
		$id = @$this->getIdPeriodoActual();
		$year = @$this->getYear($id);
		$np = @$this->getIdNumeroPeriodo($id);
		$text = @$this->getTextPeriodoNumber($np);
		$periodo = "".$text." ".$year;
		
		return $periodo;
	}
	
	// Next period
	public function getPeriodoSiguiente(){
		$id = @$this->getIdPeriodoSiguiente();
		$year = @$this->getYear($id);
		$np = @$this->getIdNumeroPeriodo($id);
		$text = @$this->getTextPeriodoNumber($np);
		$periodo = "".$text." ".$year;
		
		return $periodo;
	}
	
	// Last period
	public function getPeriodoAnterior(){
		$id = @$this->getIdPeriodoAnterior();
		$year = @$this->getYear($id);
		$np = @$this->getIdNumeroPeriodo($id);
		$text = @$this->getTextPeriodoNumber($np);
		$periodo = "".$text." ".$year;
		
		return $periodo;
	}
	
	// Run the Schoolarship Apply Query
	public function getSolicitantes($sql){
		global $DBSito;
	
		$rs = $DBSito->Execute($sql);
	
		$data = $rs->getArray();
	
		$html_code = $this->printSolicitantes($data);
		return $html_code;
	}
	
	
	//It Sets the format to the Schoolarship Applies Report
	public function printSolicitantes($data){
	
		$num = 0;
		$matricula = '';
		$nombre = '';
		$tipo = '';
		$carrera = '';
		$periodo = '';
		$servicio = '';
	
		// matricula - nombre - tipo - carrera 
		$html_code = '';
		$html_code = "<div class=\"col-lg-12 \">";
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover reporte\">";
		$html_code .= "<tr><th class=\"text-center\">#</th><th class=\"text-center\">Matr&iacute;cula</th><th class=\"text-center\">Nombre del Solicitante</th>";
		$html_code .= "<th class=\"text-center\">Folio</th><th class=\"text-center\">Fecha Solicitud</th><th class=\"text-center\">Tipo de Beca</th><th class=\"text-center\">Carrera</th></tr>";
	
		foreach ($data as $d){
			$num = $num + 1;
			$matricula = $d['matricula'];
			$nombre = $d['nombre'];
			$tipo = $d['tipo'];
			$carrera = $d['carrera'];
			$periodo = $d['periodo'];
			$folio = $d['folio'];
			$fs = $d['fs'];
			
			
			$tipo_beca = $tipo==1?'ACADEMICA':($tipo==2?'DEPORTIVA / CULTURAL':($tipo==3?'TRANSPORTE':'VULNERABILIDAD'));
			$mostrar_tipo = $tipo==1?'success':($tipo==2?'warning':($tipo==3?'info':'primary'));
			$html_code .= "<tr>";
			$html_code .= "<td class=\"text-center\">{$num}</td>";
			$html_code .= "<td class=\"text-center\">{$matricula}</td>";
			$html_code .= "<td>{$nombre}</td>";
			$html_code .= "<td class=\"text-center\">{$folio}</td>";
			$html_code .= "<td class=\"text-center\">{$fs}</td>";
			$html_code .= "<td class=\"text-center {$mostrar_tipo}\">{$tipo_beca}</td>";
			$html_code .= "<td class=\"text-left\">{$carrera}</td>";
			
			$html_code .= "</tr>";
		}
	
		$html_code .= "</table>";
		$html_code .= "</div>";
	
		return $html_code;
	}
	
	public function getSolicitantesDeBeca($sql){
		global $DBSito;
		$this->periodo_servicio = ($this->_periodo)-1;
		$rs = $DBSito->Execute($sql);
		$data = $rs->getArray();
		$html_code = $this->getHTMLSolicitantesDeBeca($data);
		return $html_code;		
	}
	
	public function getHTMLSolicitantesDeBeca($data){
		// matricula - nombre - sexo - beca_solicitada - cuatrimestre - carrera - promedio 
		// intercuatrimestrales - adeudos - renovante - reinscrito - servicio_social - porcentaje
				
		$consecutivo = 0;
		$matricula = '';
		$nombre = '';
		$sexo = '';
		$beca_solicitada = '';
		$cuatrimestre = '';
		$carrera = '';
		$promedio = '';
		/* ---------------- */
		$intercuatrimestrales = '';
		$adeudos = '';
		$renovante = '';
		$reinscrito = '';
		$servicio_social = '';
		$porcentaje = '';
		
		
		$html_code = '';
		$html_code = "<div class=\"col-lg-12 text-center\">";
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">No.</th>";
		$html_code .= "<th class=\"text-center\">Matr&iacute;cula </th>";
		$html_code .= "<th class=\"text-center\">Nombre</th>";
		$html_code .= "<th class=\"text-center\">Sexo</th>";
		$html_code .= "<th class=\"text-center\">Beca Solicitada</th>";
		$html_code .= "<th class=\"text-center\">Cuatrimestre</th>";
		$html_code .= "<th class=\"text-center\">Carrera</th>";
		$html_code .= "<th class=\"text-center\">Promedio</th>";
		$html_code .= "<th class=\"text-center\">Inter</th>";		
		$html_code .= "<th class=\"text-center\">Es Renovante</th>";
		$html_code .= "<th class=\"text-center\">Reinscrito</th>";
		$html_code .= "<th class=\"text-center\">Servicio Social</th>";
		$html_code .= "<th class=\"text-center\">Porcentaje</th>";
		$html_code .= "<th class=\"text-center\">Materias</th>";
		$html_code .= "<th class=\"text-center\">Es Reingreso</th>";
		$html_code .= "<th class=\"text-center\">Inscripcion</th>";		
		$html_code .= "<th class=\"text-center\">Adeudos</th>";
		$html_code .= "</tr>";
		
		foreach ($data as $d){
			$consecutivo++;
			$matricula = $d['matricula'];
			$nombre = $d['nombre'];
			$sexo = $d['sexo'];
			$beca_solicitada = $d['beca_solicitada'];
			$cuatrimestre = $d['cuatrimestre'];
			$carrera = $d['carrera'];
			$promedio = round($d['promedio'],2);
			$intercuatrimestrales = $d['intercuatrimestrales'];			
			$renovante = $d['renovante'];
			$reinscrito = $d['reinscrito'];
			$servicio_social = $d['servicio_social'];
			$porcentaje = $d['porcentaje'];
			$materias = $d['materias'];
			$inscripcion = $d['inscripcion'];
			$reingreso=$d["reingreso"];			
			$debe = '$ '.number_format($d['debe']);
			$html_code .= "<tr>";
						
			
			// Guardar Servicio Social realizado por RESPONSABILIDAD SOCIAL
			$tiene_responsabilidad_social = $this->setServicioSocial($matricula);			
			
			if ($servicio_social === 'No'){
				$marcar_responsabilidad = 'gris myitalic';
				if ($tiene_responsabilidad_social){$marcar_responsabilidad = 'verde mystrong';}
			}else{
				$marcar_responsabilidad = 'azul mystrong';
				if ($tiene_responsabilidad_social){$marcar_responsabilidad = 'verde mystrong';}
			}
			
			
			if (($tiene_responsabilidad_social)&&($servicio_social === 'No')){
				$this->activarServicioSocialPorResponsabilidadSocial($matricula, $this->periodo_servicio);	
				$servicio_social = 'Si';
			}			
			
			$marcar_promedio = $promedio > 9?'mystrong':'gris';
			$marcar_sexo = $sexo === 'M'?'masculino':'femenino';
			$marcar_beca_solicitada = $beca_solicitada === 'ACADEMICA'?'success':($beca_solicitada === 'TRANSPORTE'?'info':($beca_solicitada === 'VULNERABILIDAD'?'primary':'warning'));
			$marcar_inter = $intercuatrimestrales === 'Si'?'danger':'gris';
			$marcar_renovante = $renovante === 'Si'?'marked':'gris';
			$marcar_reinscrito = $reinscrito === 'Si'?'verde':'danger';
			$marcar_reingreso = $reingreso=='Si'?'rojo':'gris';
			$reingreso = $reingreso=='Si'?"<strong>$reingreso</strong>":"<i>$reingreso</i>";
			 
			$marcar_porcentaje = $porcentaje === '100'?'myverystrong success':($porcentaje === '75'?'mystrong masculino verde':'');
			$marcar_no_aplica = $porcentaje === 'N/A'?'gris myitalic':'';
			//$materias = $materias === 0?'N/A':$materias;
			//$marcar_pocas_materias = $materias<4?($materias == 0?'gris myitalic':'rojo mystrong'):'';
			$marcar_pocas_materias = $materias == 'Todas'?'gris myitalic':'rojo mystrong';
			
			$adeudo_real = $d['debe']>0?$debe:'No';
			$marcar_debe = $d['debe']>0?'rojo mystrong':'gris';
			
			$html_code .= "<td>{$consecutivo}</td>";
			
			$html_code .= "<td><a href=\"Detallado/imprimirMotivos/{$matricula}/\" data-toggle=\"modal\" data-target=\"#modal_motivos\">";
			
			$html_code .= "{$matricula}</a></td>";
			$html_code .= "<td class=\"text-left\">{$nombre}</td>";
			$html_code .= "<td class=\"text-center {$marcar_sexo}\">{$sexo}</td>";
			$html_code .= "<td class=\"text-center {$marcar_beca_solicitada}\">{$beca_solicitada}</td>";
			$html_code .= "<td class=\"text-center\">{$cuatrimestre}</td>";
			$html_code .= "<td class=\"text-left\">{$carrera}</td>";			
			$html_code .= "<td class=\"text-center {$marcar_promedio}\">{$promedio}</td>";
			$html_code .= "<td class=\"text-center {$marcar_inter}\">{$intercuatrimestrales}</td>";			
			$html_code .= "<td class=\"text-center {$marcar_renovante}\">{$renovante}</td>";
			$html_code .= "<td class=\"text-center {$marcar_reinscrito}\">{$reinscrito}</td>";
			$html_code .= "<td class=\"text-center {$marcar_responsabilidad}\">{$servicio_social}</td>";
			$html_code .= "<td class=\"text-center {$marcar_no_aplica} {$marcar_porcentaje} \">{$porcentaje}</td>";
			$html_code .= "<td class=\"text-center {$marcar_pocas_materias}\">{$materias}</td>";
			$html_code .= "<td class=\"text-center {$marcar_reingreso}\">{$reingreso}</td>";
			$html_code .= "<td class=\"text-center \">{$inscripcion}</td>";			
			$html_code .= "<td class=\"text-center {$marcar_debe}\">{$adeudo_real}</td>";
			

			$html_code .= "</tr>";
		}
		$html_code .= "</table>";
		$html_code .= "</div>";
		$html_code .= "<script type=\"text/javascript\">$.isLoading( \"hide\" );</script>";
		
		return $html_code;
	}

	
	
	
	public function getSolicitantesDeBecaExcel($sql){
		global $DBSito;
		$this->periodo_servicio = ($this->_periodo)-1;
		$rs = $DBSito->Execute($sql);
		$data = $rs->getArray();
		$codigo_excel = $this->getExcelSolicitantesDeBeca($data);
		return $codigo_excel;		
	}
	
	public function getExcelSolicitantesDeBeca($data){
		$cadena = '';
		
		// Set properties
		$this->excel->getProperties()
		->setCreator("UTA")
		->setLastModifiedBy("Luis Perea")
		->setTitle("Reporte de Becas")
		->setSubject("Filtrado de Solicitantes de Beca Interna")
		->setDescription("Reporte de Solicitantes de Becas UTA")
		->setKeywords("Excel Office 2007 openxml php")
		->setCategory("Excel");
		
		// Append information
		$this->excel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Carrera')
		->setCellValue('B1', 'Baja Temporal')
		->setCellValue('C1', 'Inscrito')
		->setCellValue('D1', 'No Inscrito')
		->setCellValue('E1', 'Baja Definitiva')
		->setCellValue('F1', 'Pendiente');
		
		foreach ($data as $d){

			$matricula = $d['matricula'];
			$nombre = $d['nombre'];
			$sexo = $d['sexo'];
			$beca_solicitada = $d['beca_solicitada'];
			$cuatrimestre = $d['cuatrimestre'];
			$carrera = $d['carrera'];
			$promedio = $d['promedio'];
			$intercuatrimestrales = $d['intercuatrimestrales'];
			$adeudos = $d['adeudos'];
			$renovante = $d['renovante'];
			$reinscrito = $d['reinscrito'];
			$servicio_social = $d['servicio_social'];
			$porcentaje = $d['porcentaje'];
			$materias = $d['materias'];
			$cadena .= $matricula.' '.$nombre.' '.$sexo.' '.$beca_solicitada.' '.$cuatrimestre;
		}
		
		
		// Rename sheet
		$this->excel->getActiveSheet()->setTitle('Reporte');
		
		// Set Active sheet, to show it first when opened.
		$this->excel->setActiveSheetIndex(0);
		
		// HTTP Header were modified to set Excel file to send
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="solicitantes_beca.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		//exit;
		$cadena.= "<script type=\"text/javascript\">$.isLoading( \"hide\" );</script>";
		//return $cadena;
		return 'hellooooooo';
	}
	
	public function activarServicioSocialPorResponsabilidadSocial($matricula,$periodo){
		global $DBSito;
		
		//$DBSito->debug = true;
		$sql = "
				insert into beca_servicio_social (matricula,periodo) values ({$matricula},{$periodo})
				";
		$rs = $DBSito->Execute($sql);
		return $sql;
	}
	
	public function setServicioSocial($matricula){
		if ($matricula >169999){
			return $this->checkServicioSocialNuevos($matricula);			
		}else{
			return $this->checkServicioSocialAnteriores($matricula);
		}
	}
	
	public function checkServicioSocialNuevos($matricula){
		global $DBSito;
		
		$sql = "
			select
            sbq.matricula,
            nombre = (pr.apellido_paterno + ' ' + pr.apellido_materno + ' ' + pr.nombre),
            sum(sbq.horas) as suma
            from (
            select distinct
            pae.matricula,
            pe.periodo,
            pe.nombre as servicio,
            pe.horas_acreditadas as horas
            from alumno_grupo as ag
            left outer join [dbo].[serv_integrante] as pae on pae.matricula = ag.matricula
            left outer join [dbo].[serv_catalogo] as pe on pe.id = pae.id_catalogo
            where pae.completo = 1
            ) as sbq
            left outer join alumno as al on al.matricula = sbq.matricula
            left outer join persona as pr on pr.cve_persona = al.cve_alumno
            where sbq.periodo = {$this->periodo_servicio} and sbq.matricula = {$matricula}
            group by sbq.matricula,pr.nombre,pr.apellido_paterno,pr.apellido_materno            
            having sum(sbq.horas) > 32
				";
		
		$rs = $DBSito->Execute($sql);
		return $rs->fields['matricula'];
	}
	
	public function verificarBeca($matricula,$periodo){
		global $DBSito;
		
		$sql = "select estatus from beca_asignada where cve_beca_cat > 0 and estatus <> 5 and matricula = $matricula and cve_periodo = $periodo";
		$rs = $DBSito->Execute($sql);

		$becado = $rs->fields['estatus']>0?true:false;
		
		return $becado;
	}
	
	public function isCanceled_($matricula,$periodo){
		global $DBSito;
	
		$sql = "select estatus from beca_asignada where estatus = 5 and matricula = $matricula and cve_periodo = $periodo";
		$rs = $DBSito->Execute($sql);
	
		$cancelada = $rs->fields['estatus']==5?true:false;
	
		return $cancelada;
	}
	
	public function cancelarBeca($matricula,$periodo){
		global $DBSito;
	
		$sql = "update beca_asignada set cve_beca_cat = 0, estatus = 5 where matricula = '$matricula' and cve_periodo = $periodo";
		
		
		// Comment to test and do not CANCEL
		$rs = $DBSito->Execute($sql);
		
		return "Beca eliminada para matricula $matricula";
	
	}
	
	/*
	 * Cancellation and Decancellation Registry Log	 
	 */
	
	public function setLog($texto){
		global $DBSito;
		$sql = "insert into loglf (descripcion) values ('$texto')";
		
		$rs = $DBSito->Execute($sql);
		return true;
	}
	
	// ===============================================================
	// ===============================================================
	// ===================== QUIT CANCELLATION =======================
	// ===============================================================
	// ===============================================================
	public function descancelarBeca($matricula,$periodo){
		global $DBSito;
	
		$sql = "update beca_asignada set estatus = 1 where matricula = '$matricula' and cve_periodo = $periodo";
	
	
		// Comment to test and do not UPDATE
		//$rs = $DBSito->Execute($sql);
	
		return "Beca descancelada para matricula $matricula";
	
	}
	
	public function checkServicioSocialAnteriores($matricula){
		global $DBSito;
		
		$sql = "
			select
            sbq.matricula,
            nombre = (pr.apellido_paterno + ' ' + pr.apellido_materno + ' ' + pr.nombre),
            sum(sbq.horas) as suma
            from (
            select distinct
            pae.matricula,
            pe.periodo,
            pe.nombre as servicio,
            pe.horas_acreditadas as horas
            from alumno_grupo as ag
            left outer join [dbo].[serv_integrante] as pae on pae.matricula = ag.matricula
            left outer join [dbo].[serv_catalogo] as pe on pe.id = pae.id_catalogo
            where pae.completo = 1
            ) as sbq
            left outer join alumno as al on al.matricula = sbq.matricula
            left outer join persona as pr on pr.cve_persona = al.cve_alumno
            where sbq.periodo = {$this->periodo_servicio} and sbq.matricula = {$matricula}
            group by sbq.matricula,pr.nombre,pr.apellido_paterno,pr.apellido_materno            
            having sum(sbq.horas) > 20
				";
		
		$rs = $DBSito->Execute($sql);
		return $rs->fields['matricula'];
	}
	
	public function esReingreso($matricula){
		global $DBSito;
		
		$sql ="
				select distinct matricula
				from alumno_clase
				where cve_status = 9 and matricula = {$matricula}
				";
		$rs = $DBSito->Execute($sql);
		return $rs->fields['matricula'];
		
	}
	
	public function checarSesion($id,$sid){
		global $DBSito;
		
		$sql = "select sesion from registro_sesion
				where cve_persona = (select cve_alumno from alumno where matricula = {$id})
				and activo = 1";
		$rs = $DBSito->Execute($sql);
		return $rs->fields['sesion'] === $sid?0:1;
		
	}
	
	public function getMotivos($matricula, $periodo){
		global $DBSito;
		
		$sql = "select motivos from beca_solicitud
		where matricula = {$matricula}
		and id_periodo_aplicacion = {$periodo}";
		$rs = $DBSito->Execute($sql);		
		return ''.$rs->fields['motivos'].'';			
	}
	
	public function getEncuesta($matricula){
		global $DBSito;
			
		$sql = "select distinct p.pregunta,r.respuesta 
				from pregunta_respuesta pr
				inner join pregunta p on p.cve_pregunta = pr.cve_pregunta
				inner join respuesta r on r.cve_pregunta = p.cve_pregunta and pr.cve_respuesta = r.cve_respuesta
				where pr.cve_encuestado = (select max(cve_encuestado) encuestado from encuestado where cve_persona = (select cve_alumno from alumno where matricula = {$matricula}))
				and pr.cve_pregunta in
				(
				select cve_pregunta from pregunta
				where cve_pregunta in
				(select cve_pregunta from pregunta_encuesta where cve_encuesta = 95)
				and activo = 1
				)
		";
		$rs = $DBSito->Execute($sql);
		return $rs->getArray();
	}
	
	
	/*
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * @@@ 							IMPORTAR BECAS                            @@@ 
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 */
	
	public function verificarSiYaEstaRegistradaLabeca($periodo, $matricula){
		global $DBSito;
		
		$sql = "select cve_periodo from beca_asignada where cve_periodo = {$periodo} and matricula = '{$matricula}'";
		$rs = $DBSito->Execute($sql);
		return $rs->fields['cve_periodo'];		
	}
	
	public function importarCSV($periodo,$informacion){		
		global $DBSito;
		$ya_registrada = '';	
		$icono = '';
		$texto = '<div class="container-fluid">
				<h1 id="form_space"><strong><i class="fa fa-upload azul"></i> Becas importadas</strong></h1>
				<h5>Matr&iacute;cula - Beca</h5>
				';
		foreach ($informacion as $i){
			$matricula = $i[0];
			$beca = $i[1];
			$fic = $this->getFechaInicioPeriodo($periodo);
			$ffc = $this->getFechaFinPeriodo($periodo);
			
			$ya_registrada =  $this->verificarSiYaEstaRegistradaLabeca($periodo, $matricula);
			$icono = $ya_registrada?'<i class="fa fa-files-o rojo"></i><i class="fa fa-caret-left" aria-hidden="true"></i><strong> Ya registrada</strong><br />':'- <span class="gris">'.$beca.'</span> <i class="fa fa-check-square-o verde"></i> <small>Insertada</small><br />';
			
			$sql = "insert into beca_asignada 
					(matricula, cve_beca_cat, cve_periodo, estatus, fecha, cve_cajero, fecha_fin)
					values
					('{$matricula}',{$beca},{$periodo},1,'{$fic}',0,'{$ffc}')
					";
	
			/* ------------------------------------------------------------------------------- */
			/* ---              Here we can disable INSERT to do validation tests          --- */
			/* ------------------------------------------------------------------------------- */			
			$rs = $DBSito->Execute($sql); // Comment to disable
			/* ------------------------------------------------------------------------------- */
			$texto .= '<span class="azul">'.$matricula.'</span> '.$icono;						
		}
		$boton_regresar = '<br /><button type="button" class="btn btn-success btn-md" onclick="history.back()">
            Regresar <i class="fa fa-times-circle-o" aria-hidden="true"></i></button></div>';
		$texto .= $boton_regresar;
		return $texto;
	}
	
	public function getFechaInicioPeriodo($periodo){
		global $DBSito;
	
		$sql = "select fecha_inicio from periodo where cve_periodo = $periodo";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['fecha_inicio'];
	}
	
	public function getFechaFinPeriodo($periodo){
		global $DBSito;
	
		$sql = "select fecha_fin from periodo where cve_periodo = $periodo";
	
		$rs = $DBSito->Execute($sql);
	
		return $rs->fields['fecha_fin'];
	}
	
	/*
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * @@@ 						REPORTE BECADOS                               @@@
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 */
	public function getBecados($sql){
		global $DBSito;		
		$rs = $DBSito->Execute($sql);
		$data = $rs->getArray();
		$html_code = $this->getHTMLBecados($data);		
		return $html_code;
	}
	
	public function getHTMLBecados($data){
		
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
		
		$html_code = '';
		$contador = 1;
			
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">No.</th>";
		$html_code .= "<th class=\"text-center\">Matr&iacute;cula </th>";
		$html_code .= "<th class=\"text-center\">Nombre</th>";
		$html_code .= "<th class=\"text-center\">Sexo</th>";
		$html_code .= "<th class=\"text-center\">Carrera</th>";
		$html_code .= "<th class=\"text-center\">Cuatrimestre</th>";
		$html_code .= "<th class=\"text-center\">Tipo Beca</th>";
		$html_code .= "<th class=\"text-center\">Categor&iacute;a</th>";
		$html_code .= "</tr>";
		foreach ($data as $d){			
			$matricula = 			 $d['matricula_alumno'];
			$nombre = 	 			 $d['nombre'];
			$sexo = 	 			 $d['sexo'];
			$carrera =   			 $d['carrera'];
			$numero_cuatrimestre = 	 $d['numero_cuatrimestre'];
			$descripcion_beca_tipo = $d['descripcion_beca_tipo'];
			$descripcion_beca_cat =  $d['descripcion_beca_cat'];
			
			$html_code .= "<td class=\"text-center\">{$contador}</td>";
			$html_code .= "<td class=\"text-center\">{$matricula}</td>";
			$html_code .= "<td class=\"text-left\">{$nombre}</td>";
			$html_code .= "<td class=\"text-center\">{$sexo}</td>";
			$html_code .= "<td class=\"text-left\">{$carrera}</td>";
			$html_code .= "<td class=\"text-center\">{$numero_cuatrimestre}</td>";
			$html_code .= "<td class=\"text-left\">{$descripcion_beca_tipo}</td>";
			$html_code .= "<td class=\"text-left\">{$descripcion_beca_cat}</td>";			
			$contador++;
			$html_code .= "</tr>";
		}
		$html_code .= "</table>";
		echo $html_code;
	}

	/*
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * @@@ 						REPORTE NO BECADOS                               @@@
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 */
	public function getNoBecados($sql){
		global $DBSito;
		$rs = $DBSito->Execute($sql);
		$data = $rs->getArray();
		$html_code = $this->getHTMLNoBecados($data);
		return $html_code;
	}
	
	public function getHTMLNoBecados($data){
	
		// matricula_alumno
		// nombre
		// sexo
		// cve_periodo
		// numero_cuatrimestre
		// cve_carrera
		// carrera
		// causa_rechazo
		// convocatoria
		
		$html_code = '';
		$contador = 1;
			
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">No.</th>";
		$html_code .= "<th class=\"text-center\">Matr&iacute;cula </th>";
		$html_code .= "<th class=\"text-center\">Nombre</th>";
		$html_code .= "<th class=\"text-center\">Sexo</th>";
		$html_code .= "<th class=\"text-center\">Carrera</th>";
		$html_code .= "<th class=\"text-center\">Cuatrimestre</th>";		
		$html_code .= "<th class=\"text-center\">Causa Rechazo</th>";
		$html_code .= "<th class=\"text-center\">Convocatoria</th>";
		$html_code .= "</tr>";
		foreach ($data as $d){
			$matricula = 			 $d['matricula_alumno'];
			$nombre = 	 			 $d['nombre'];
			$sexo = 	 			 $d['sexo'];
			$carrera =   			 $d['carrera'];
			$numero_cuatrimestre = 	 $d['numero_cuatrimestre'];			
			$causa_rechazo =  $d['causa_rechazo'];
			$convocatoria =  $d['convocatoria'];
				
			$html_code .= "<td class=\"text-center\">{$contador}</td>";
			$html_code .= "<td class=\"text-center\">{$matricula}</td>";
			$html_code .= "<td class=\"text-left\">{$nombre}</td>";
			$html_code .= "<td class=\"text-center\">{$sexo}</td>";
			$html_code .= "<td class=\"text-left\">{$carrera}</td>";
			$html_code .= "<td class=\"text-center\">{$numero_cuatrimestre}</td>";
			$html_code .= "<td class=\"text-left\">{$causa_rechazo}</td>";			
			$html_code .= "<td class=\"text-left\">{$convocatoria}</td>";
			$contador++;
			$html_code .= "</tr>";
		}
		$html_code .= "</table>";
		echo $html_code;
	}
	
	
	public function este_alumno_esta_becado($periodo, $matricula){
		global $DBSito;
		
		$sql = "select cve_beca_asignada from beca_asignada where matricula = $matricula and cve_periodo = $periodo";
		
		$rs = $DBSito->Execute($sql);
		
		return $rs->fields['cve_beca_asignada'];
	}
	
	
	
	
	// TODO
	public function altaBecaIndividual($data){
		global $DBSito;
		
		
		$periodo = $data['periodo'];
		$matricula = $data['matricula'];
		$beca = $data['beca'];
		$ip = $data['ip'];
				
		$fecha_inicio = $this->getFechaInicioPeriodo($periodo);
		$fecha_inicio = str_replace(' ','T',$fecha_inicio);
		
		$fecha_fin = $this->getFechaFinPeriodo($periodo);
		$fecha_fin = str_replace(' ','T',$fecha_fin);
		
		$sql = "insert into beca_asignada 
				(matricula,cve_beca_cat,cve_periodo,estatus,fecha,cve_cajero,fecha_fin) 
				values ('$matricula',$beca,$periodo,1,'$fecha_inicio',666,'$fecha_fin')";
		
		// Uncommento to test
		$texto = '<prueba sistemas> ';
		// ------------------
		
		$texto = 'ALTA de Beca por IP: '.$ip;
		$texto .= ' en el Periodo: '.$periodo.' Matricula: '.$matricula.' Beca: '.$beca.' '.$fecha_inicio.' '.$fecha_fin;
		
		$this->setLog($texto);
		// Comment to test and do not CREATE
		//$rs = $DBSito->Execute($sql);
							
		return $sql;
	}
	
	
	public function estaCancelada($periodo, $matricula){
		global $DBSito;
		
		$sql = "select cve_beca_cat, estatus from beca_asignada where matricula = '$matricula' and cve_periodo = $periodo";
		
		$rs = $DBSito->Execute($sql);
				
		if (($rs->fields['cve_beca_cat'] = 0)||($rs->fields['estatus']) == 5){		
			return true;
		}else{			
			return false;
		}
	}
	
	
	
	public function modificarBecaIndividual($periodo, $matricula, $beca){
		global $DBSito;
		
		$sql = "update beca_asignada set cve_beca_cat = $beca where cve_periodo = $periodo and matricula = $matricula";
		
		if ($this->estaCancelada($periodo, $matricula)){
			return true;			
		}else{
			
			// Comment to test and do not do CHANGES
			// $rs = $DBSito->Execute($sql);						
			return false;			
		}		
	}
	
	public function getPermitidos(){
	
		/*
		 *
		 */
		//TODO Make an access table
		/*
		 *
		 */
		$permitidos = ['externo','A00453','B00621','B00421'];
		return $permitidos;
	}
	
	/*
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * @@@ 				  REPORTE TODOS LOS BECADOS                           @@@
	 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 */
	public function getAllBecados($sql){
		global $DBSito;
		$rs = $DBSito->Execute($sql);
		$data = $rs->getArray();
		$html_code = $this->getAllHTMLBecados($data);
		return $html_code;
	}
	
	public function getAllHTMLBecados($data){
		//matricula
		//nombre
		//beca
		//cve_beca_cat
		//nivel
		//carrera
		//ssyear
		//np
		//periodo
		$html_code = '';	
		$matricula_anterior = '';
		$counter = 1;
		$temp_counter = 1;
		$switch = 0;
		$color = 'masculino';
		
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">No.</th>";
		$html_code .= "<th class=\"text-center\">No. Becas</th>";
		$html_code .= "<th class=\"text-center\">Matr&iacute;cula </th>";
		$html_code .= "<th class=\"text-center\">Nombre</th>";
		$html_code .= "<th class=\"text-center\">Beca</th>";
		$html_code .= "<th class=\"text-center\">Carrera</th>";
		$html_code .= "<th class=\"text-center\">Año</th>";
		$html_code .= "<th class=\"text-center\">Periodo</th>";
		$html_code .= "</tr>";
		
		foreach ($data as $d){

			$matricula = 			$d['matricula'];
			$nombre = 	 			$d['nombre'];
			$beca = 				$d['beca'];
			$carrera = 				$d['carrera'];
			$ssyear = 				$d['ssyear'];
			$periodo = 				$d['periodo'];
			
			if($matricula_anterior != $matricula){
				$temp_counter = 1;
				$switch = $switch + 1;
				$color = (($switch%2 == 0)?'femenino':'masculino');
				$html_code .= "<tr><td class=\"text-left {$color}\">{$counter}</td>";
				$html_code .= "<td class=\"text-left {$color}\">{$temp_counter}</td>";				
			}else{
				$temp_counter = $temp_counter + 1;
				$html_code .= "<tr><td class=\"text-left {$color}\">{$counter}</td>";
				$html_code .= "<td class=\"text-left {$color}\">{$temp_counter}</td>";
			}
						
			$html_code .= "<td class=\"text-left {$color}\">{$matricula}</td>";
			$html_code .= "<td class=\"text-left {$color}\">{$nombre}</td>";
			$html_code .= "<td class=\"text-left {$color}\">{$beca}</td>";
			$html_code .= "<td class=\"text-left {$color}\">{$carrera}</td>";
			$html_code .= "<td class=\"text-left {$color}\">{$ssyear}</td>";
			$html_code .= "<td class=\"text-left {$color}\">{$periodo}</td>";
			
			$counter++;
			$matricula_anterior = $matricula;
			$html_code .= "</tr>";
		}

		$html_code .= '</table>';
		return $html_code;
		
		
		
	}
	
}