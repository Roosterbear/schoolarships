<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/../libraries/db/db.php";

class Restricciones
{
	public function getSolicitantes($sql){
		global $DBSito;			
	
		$rs = $DBSito->Execute($sql);
	
		$data = $rs->getArray();
		
		$html_code = $this->printSolicitantes($data);
		return $html_code;
	}
	
	
	public function printSolicitantes($data){
		
		$num = 0;
		$matricula = '';
		$nombre = '';
		$tipo = '';
		$carrera = '';
		$periodo = '';
		$servicio = '';		
		
		// matricula - nombre - tipo - carrera - servicio
		$html_code = '';
		$html_code = "<div class=\"col-lg-12 text-center\">";
		$html_code .= "<table class=\"table table-stripped table-condensed table-bordered table-hover \">";
		$html_code .= "<tr><th class=\"text-center\">#</th><th class=\"text-center\">Matr&iacute;cula</th><th class=\"text-center\">Nombre del Solicitante</th>";
		$html_code .= "<th class=\"text-center\">Tipo de Beca</th><th class=\"text-center\">Carrera</th><th class=\"text-center\">Estado</th><th class=\"text-center\">Agregar / Quitar</th></tr>";		
		
		foreach ($data as $d){
				$num = $num + 1;
				$matricula = $d['matricula'];							
				$nombre = $d['nombre'];
				$tipo = $d['tipo'];
				$carrera = $d['carrera'];
				$periodo = $d['periodo'];
				$servicio = $d['servicio'];
				
				$tipo_beca = $tipo==1?'ACADEMICA':($tipo==2?'DEPORTIVA / CULTURAL':'TRANSPORTE');
				$html_code .= "<tr>";
				$html_code .= "<td>{$num}</td>";
				$html_code .= "<td>{$matricula}</td>";
				$html_code .= "<td>{$nombre}</td>";			
				$html_code .= "<td>{$tipo_beca}</td>";		
				$html_code .= "<td>{$carrera}</td>";				
				
				// Icono y Color de ESTADO
				$color_estado_servicio = $servicio=='1'?'verde':'rojo';
				$icono_estado_servicio = $servicio=='1'?'check-square-o':'times-circle';
				
				// Color del check
				$agregar = $servicio=='1'?'gris':'verde';
				$quitar  = $servicio=='1'?'rojo':'gris';
				
				// Puntero del mouse 
				$link_validar = $servicio=='1'?'no_chequeo':'chequeo';
				$link_quitar = $servicio=='1'?'chequeo':'no_chequeo';
				
				// Clase disparadora
				$chequeo_validar = $servicio=='1'?'':'agregar_servicio';
				$chequeo_quitar = $servicio=='1'?'quitar_servicio':'';

				// Icono y Color de ESTADO
				$html_code .= "<td><span class=\"{$color_estado_servicio}\"><i class=\"fa fa-{$icono_estado_servicio} fa-lg\" aria-hidden=\"true\"></i></span></td>";

				// Botones de Agregar / Quitar
				$html_code .= "<td>";
				$html_code .= "<span id=\"{$matricula}\" {$chequeo_validar} class=\"{$agregar} {$link_validar}\" ><i class=\"fa fa-tags fa-lg\" aria-hidden=\"true\"></i></span>";
				$html_code .= "<span id=\"{$matricula}\" {$chequeo_quitar} class=\"{$quitar} {$link_quitar} \"><i class=\"fa fa-trash  fa-lg\" aria-hidden=\"true\"></i></span></span></td>";
				$html_code .= "</td>";
				$html_code .= "</tr>";										
		}
		
		$html_code .= "</table>";
		$html_code .= "</div>";
		
		return $html_code;
	}
	
	public function changeServicioSocial($sql){
		global $DBSito;
		
		$rs = $DBSito->Execute($sql);
		
		return true;
	}
}
