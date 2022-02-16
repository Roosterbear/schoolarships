<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *
 * @author: Luis Fernando Perea Gallosso
 *
 */
class Menu extends CI_Controller {

	public $becas_util;
	
	public function __construct(){
		parent::__construct ();
		
		$this->load->library('BecasUtil');
		$this->becas_util = new BecasUtil();	
		
	}
	
	public function index(){
		$this->load->view('header');
		$this->load->view('menu');
		$this->load->view('footer');
	}
}