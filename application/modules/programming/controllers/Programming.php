<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programming extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("programming_model");
    }
	
	/**
	 * Listado de programaciones
     * @since 2/7/2018
     * @author BMOTTAG
	 */
	public function index($idProgramming = 'x')
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		$data['informationHistorico'] = FALSE;
						
		$arrParam = array();
		$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes
		
		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info inspecciones
		}

		$data["view"] = 'programming';
		$this->load->view("layout", $data);
	}
	
	/**
	 * lista de usuarios
     * @since 1/7/2018
     * @author BMOTTAG
	 */
	public function users()
	{		
		$this->load->model("general_model");
		$arrParam = array(
			"table" => "programming_users",
			"order" => "id_programming_users",
			"id" => "x"
		);
		$data['info'] = $this->general_model->get_basic_search($arrParam);

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
			$idUser = $this->input->post("idUser");	
			
			if ($idUser != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "programming_users",
					"order" => "id_programming_users",
					"column" => "id_programming_users",
					"id" => $idUser
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
	
	/**
	 * lista de skills
     * @since 1/7/2018
     * @author BMOTTAG
	 */
	public function skills()
	{		
		$this->load->model("general_model");
		$arrParam = array(
			"table" => "programming_skills",
			"order" => "id_programming_skill",
			"id" => "x"
		);
		$data['info'] = $this->general_model->get_basic_search($arrParam);
		
		$data["view"] = 'skills';
		$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario skills
     * @since 1/7/2018
     */
    public function cargarModalSkills() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$idSkill = $this->input->post("idSkill");	
			
			if ($idSkill != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "programming_skills",
					"order" => "id_programming_skill",
					"column" => "id_programming_skill",
					"id" => $idSkill
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("skills_modal", $data);
    }
	
	/**
	 * Update skills
     * @since 1/6/2018
     * @author BMOTTAG
	 */
	public function save_skill()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSkill = $this->input->post('hddIdSkill');
			
			$msj = "You have add a new skill!!";
			if ($idSkill != '') {
				$msj = "You have update a skill!!";
			}

			if ($idSkill = $this->programming_model->saveSkill()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }
	


	
}