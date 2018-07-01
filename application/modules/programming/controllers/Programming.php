<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programming extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("programming_model");
    }
	
	/**
	 * lista de usuarios
     * @since 1/7/2018
     * @author BMOTTAG
	 */
	public function users()
	{
		$this->load->model("general_model");
		$arrParam = array();
		$data['info'] = $this->general_model->get_programming_users($arrParam);

		$data["view"] = 'users';
		$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario usuarios
     * @since 1/7/2018
     */
    public function cargarModalUsers() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idUser"] = $this->input->post("idUser");	
			
			if ($data["idUser"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "programming_users",
					"order" => "id_programming_users",
					"column" => "id_programming_users",
					"id" => $data["idUser"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("users_modal", $data);
    }
	
	/**
	 * Update users
     * @since 1/6/2018
     * @author BMOTTAG
	 */
	public function save_users()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idUser = $this->input->post('hddIdUser');
			
			$msj = "You have add a new user!!";
			if ($idUser != '') {
				$msj = "You have update an user!!";
			}

			if ($idUser = $this->programming_model->saveUser()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }
	


	
}