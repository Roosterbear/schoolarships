<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Importacion extends CI_Controller
{
	
	public $becas_util;
	public $repetido;
	private $_usuarioSITO;	
	
	public function __construct(){
		parent::__construct ();
	
		$this->load->helper('utilidades');
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();			
		
		/*
		 * --------- DEVELOPMENT [TESTING]
		 */
		$this->_usuarioSITO = isset($_REQUEST ['uid'])?$_REQUEST ['uid']:'externo';
		
		
		/*
		 * --------- PRODUCTION
		 */
		//$this->_usuarioSITO = $_REQUEST?$_REQUEST['uid']:0;
		
		
		$this->_usuario_autorizado = in_array($this->_usuarioSITO, $this->becas_util->utilerias->getPermitidos());
	}
	
	public function index(){		
		$this->load->view('header');	
		
		if ($this->_usuarioSITO){
			if($this->_usuario_autorizado){
				$data['usuario'] = $this->_usuarioSITO;
				$this->load->view('importacionVw',$data);
			}else{
				$this->load->view('importacion_error_autorizacionVw');
			}
		}else{
			$this->load->view('importacion_error_sitoVw');
		}
		
		$this->load->view('footer');
	
	}
	
	
	public function checarArchivo(){
		$this->load->view('header');
		$data['usuario'] = $this->_usuarioSITO;
		$this->load->view('importacionChecarArchivoVw',$data);
		$this->load->view('footer');
	}
	
	public function csv(){		
		$periodo = $this->becas_util->utilerias->getIdPeriodoActual();
		$informacion = $_REQUEST['informacion'];
						
		echo $this->becas_util->utilerias->importarCSV($periodo, $informacion);
		
	}
}





