<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
    }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			
			if($userRol==3){ //If it is a normal user, just show the records of the user session
				$arrParam["idUser"] = $this->session->userdata("id");
			}
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_payroll($arrParam);

			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	
}