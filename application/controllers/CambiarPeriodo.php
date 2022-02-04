<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CambiarPeriodo extends CI_Controller
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

		$data['periodo_actual'] = @$this->becas_util->utilerias->getPeriodoActual();

		$data['id_periodo_actual'] = @$this->becas_util->utilerias->getIdPeriodoActual();

		$data['carreras'] = @$this->becas_util->alumnos->getCarreras();
		$data['tipos_beca'] = @$this->becas_util->alumnos->getTiposBecaFull();

		$this->load->view('individualVw',$data);
		$this->load->view('footer');

	}
}