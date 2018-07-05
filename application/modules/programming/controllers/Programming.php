<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programming extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("programming_model");
		$this->load->helper('form');
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
		$data['informationWorker'] = FALSE;
						
		$arrParam = array();
		$data['information'] = $this->general_model->get_programming($arrParam);//info solicitudes
		
		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
			
			//lista de trabajadores para esta programacion
			$data['informationWorker'] = $this->general_model->get_programming_workers($arrParam);//info inspecciones
		}

		$data["view"] = 'programming';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Form programming
     * @since 2/7/2018
     * @author BMOTTAG
	 */
	public function update_programming($idProgramming = 'x')
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		
		//project list - (active's items)
		$arrParam = array("state" => 1);
		$data['project'] = $this->general_model->get_project($arrParam);
		
		//si envio el id, entonces busco la informacion 
		if ($idProgramming != 'x') {
			$arrParam = array("idProgramming" => $idProgramming);
			$data['information'] = $this->general_model->get_programming($arrParam);//info programacion
		}

		$data["view"] = 'form_programming';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar programacion
     * @since 2/7/2018
	 */
	public function save_programming()
	{			
			header('Content-Type: application/json');
			
			$idProgramming = $this->input->post('hddId');
			$idProject = $this->input->post('project');
			$date = $this->input->post('date_programming');

			$msj = "You have add a new programming!!";
			if ($idProgramming != '') {
				$msj = "You have update a programming!!";
			}
			
			//verificar si ya existe el proyecto para esa fecha
			$result_project = false;
			$arrParam = array(
				"idProject" => $idProject,
				"date" => $date
			);
			$result_project = $this->programming_model->verifyProject($arrParam);
			
			if ($result_project) {
				$data["result"] = "error";

				$data["mensaje"] = " Error. This project is already scheduled for that date.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> This project is already scheduled for that date.');
			} else {
			
				if ($idProgramming = $this->programming_model->saveProgramming()) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			
			}

			echo json_encode($data);
    }
	
	/**
	 * lista de trabajadores disponibles
     * @since 1/7/2018
     * @author BMOTTAG
	 */
	public function workers()
	{		
		$this->load->model("general_model");
		$arrParam = array();
		$data['info'] = $this->general_model->get_programming_user_list($arrParam);

		$data["view"] = 'workers';
		$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario usuarios
     * @since 1/7/2018
     */
    public function cargarModalWorkers() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$idUser = $this->input->post("idUser");	
			
			if ($idUser != 'x') {
				$this->load->model("general_model");
				$arrParam = array("idUser" => $idUser);
				$data['information'] = $this->general_model->get_programming_user_list($arrParam);
			}
			
			$this->load->view("workers_modal", $data);
    }
	
	/**
	 * Update workers
     * @since 1/6/2018
     * @author BMOTTAG
	 */
	public function save_workers()
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
	
	/**
	 * Form Add Workers
     * @since 4/7/2018
     * @author BMOTTAG
	 */
	public function add_programming_workers($idProgramming)
	{
			if (empty($idProgramming)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//workers list
			$this->load->model("general_model");
			$arrParam = array();
			$data['workersList'] = $this->general_model->get_programming_user_list($arrParam);//workers list
			
			$view = 'form_add_workers';
			$data["idProgramming"] = $idProgramming;
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker
     * @since 4/7/2018
     * @author BMOTTAG
	 */
	public function save_programming_workers()
	{			
			header('Content-Type: application/json');
			$data = array();
			$data["idProgramming"] = $this->input->post('hddId');

			if ($this->programming_model->addProgrammingWorker()) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
				
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, remember to get the signature of each one.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Add Workers Skills
     * @since 5/7/2018
     * @author BMOTTAG
	 */
	public function add_workers_skills($idWorker)
	{
			if (empty($idWorker)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//skills list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "programming_skills",
				"order" => "id_programming_skill",
				"id" => "x"
			);
			$data['skillsList'] = $this->general_model->get_basic_search($arrParam);
			
			$view = 'form_add_skills';
			$data["idWorker"] = $idWorker;
			$data["view"] = $view;
			$this->load->view("layout", $data);
	}
	
	/**
	 * Save worker skills
     * @since 5/7/2018
     * @author BMOTTAG
	 */
	public function save_workers_skills()
	{			
			header('Content-Type: application/json');
			$data = array();

			if ($this->programming_model->addProgrammingSkill()) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
				
				$this->session->set_flashdata('retornoExito', 'You have add the Workers, remember to get the signature of each one.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	


	
}