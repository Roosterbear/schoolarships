<?php
defined('BASEPATH') OR exit('No direct script access allowed');
session_start();
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Validador extends CI_Controller {
		
	public $becas_util;
		
	public function __construct(){
		parent::__construct ();
		
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();
				
	}
	
	public function index(){
		$this->load->view('header');	
		
		$data['lista_grupo_seguridad'] = @$this->becas_util->validadores->listarGrupoSeguridad();
		//$data['usuario'] = $_REQUEST['usuario'];
		
		$this->load->view('validadoresVw',$data);
		
		$this->load->view('footer');
	}
	
	public function esEmpleado(){
		if ($_REQUEST){
			$usuario = $_REQUEST['usuario'];		
		}else{
			$usuario = '';
		}
		echo $this->becas_util->validadores->getNombreUsuario($usuario);	
	}
	
	public function esValidador(){
		if ($_REQUEST){
			$usuario = $_REQUEST['usuario'];		
		}else{
			$usuario = '';
		}
		echo $this->becas_util->validadores->esValidador($usuario);
	}
	
	public function insertValidador(){
		if ($_REQUEST){
			$usuario = $_REQUEST['usuario'];
		}else{
			$usuario = '';
		}
		
		echo $this->becas_util->validadores->agregarUsuario($usuario);		
	}
	
	
	public function deleteValidador(){
		if ($_REQUEST){
			$usuario = $_REQUEST['usuario'];
		}else{
			$usuario = '';
		}
				
		echo $this->becas_util->validadores->borrarUsuario($usuario);
	}
	
	
	public function modifyValidador(){
		if ($_REQUEST){
			$data['usuario'] = $_REQUEST['usuario'];
			$data['validacion'] = $_REQUEST['validacion'];
			$data['dato'] = $_REQUEST['dato'];
			$data['borrar'] = $_REQUEST['borrar'];
		}else{
			$data['usuario'] = '';
			$data['validacion'] = '';
			$data['dato'] = '';
			$data['borrar'] = '';
		}
		
		$this->becas_util->validadores->administrarFiltros($data);
		
	}
	
	public function displayFiltros(){
		if ($_REQUEST){
			$data['usuario'] = $_REQUEST['usuario'];			
			$data['filtro'] = $_REQUEST['filtro'];
		}else{
			$data['usuario'] = '';
			$data['filtro'] = '';
		}
		
		echo $this->becas_util->validadores->getFiltros($data);
		
	}
}