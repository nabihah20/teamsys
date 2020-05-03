<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Team extends CI_Controller {
	function __construct(){
		parent:: __construct();
		$this->load->model('team_m','m');
	}

	function index(){
		$this->load->view('layout/header');
		$this->load->view('team/index');
		$this->load->view('layout/footer');
	}

	public function showAllTeam(){
		$result = $this->m->showAllTeam();
		echo json_encode($result);
	}

	public function addTeam(){
		$result = $this->m->addTeam();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		} 
		echo json_encode($msg);
	}

}
