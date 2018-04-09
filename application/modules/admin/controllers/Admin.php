<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("admin_model");
		$this->load->helper('form');
    }
	
	/**
	 * lista de usuarios
     * @since 29/3/2018
     * @author BMOTTAG
	 */
	public function usuarios()
	{
		$this->load->model("general_model");
		$arrParam = array();
		$data['info'] = $this->general_model->get_user_list($arrParam);

		$data["view"] = 'usuarios';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Form usuario
     * @since 29/3/2018
     * @author BMOTTAG
	 */
	public function update_usuario($idUser = 'x')
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		
		//consultar lista de roles
		$arrParam = array(
			"table" => "param_rol",
			"order" => "rol_name",
			"id" => "x"
		);
		$data['roles'] = $this->general_model->get_basic_search($arrParam);

		//si envio el id, entonces busco la informacion 
		if ($idUser != 'x') {
			$arrParam = array("idUser" => $idUser);
			$data['information'] = $this->general_model->get_user_list($arrParam);//info cliente
		}

		$data["view"] = 'form_usuario';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar usuario
     * @since 29/3/2018
	 */
	public function save_usuario()
	{			
			header('Content-Type: application/json');
			
			$idUser = $this->input->post('hddId');
			$log_user = $this->input->post('usuario');
			$email = $this->input->post('email');

			$msj = "You have add a new User!!";
			if ($idUser != '') {
				$msj = "You have update the User!!";
			}	
			
			$result_user = false;
			$result_email = false;

			//verificar si ya existe el usuario
			$arrParam = array(
				"idUser" => $idUser,
				"column" => "log_user",
				"value" => $log_user
			);
			$result_user = $this->admin_model->verifyUser($arrParam);
			
			//verificar si ya existe el correo
			$arrParam = array(
				"idUser" => $idUser,
				"column" => "email",
				"value" => $email
			);
			$result_email = $this->admin_model->verifyUser($arrParam);

			if ($result_user || $result_email) {
				$data["result"] = "error";
				if($result_user){
					$data["mensaje"] = " Error. The user already exist.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> The user already exist.');
				}
				if($result_email){
					$data["mensaje"] = " Error. The email already exist.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> The email already exist.');
				}
				if($result_user && $result_email){
					$data["mensaje"] = " Error. The user and email already exist.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> The user and email already exist.');
				}
			} else {
			
				if ($idUser = $this->admin_model->saveUsuario()) {
					$data["result"] = true;
					$data["idRecord"] = $idUser;
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$data["idRecord"] = '';
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help, contact the Admin.');
				}
			
			}

			echo json_encode($data);
    }
	
	/**
	 * Change password
     * @since 29/3/2018
     * @author BMOTTAG
	 */
	public function change_password($idUser)
	{
			if (empty($idUser)) {
				show_error('ERROR!!! - You are in the wrong place. The ID USER is missing.');
			}
			
			$this->load->model("general_model");
			$arrParam = array("idUser" => $idUser);
			$data['information'] = $this->general_model->get_user_list($arrParam);//info cliente
		
			$data["view"] = "form_password";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update user´s password
	 */
	public function update_password()
	{
			$data = array();			
			
			$newPassword = $this->input->post("inputPassword");
			$confirm = $this->input->post("inputConfirm");
			$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
			
			$data['linkBack'] = "admin/usuarios";
			$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>CHANGE PASSWORD";
			
			if($newPassword == $confirm)
			{					
					if ($this->admin_model->updatePassword()) {
						$data["msj"] = "You have update the password.";
						$data["msj"] .= "<br><strong>User: </strong>" . $this->input->post("hddUser");
						$data["msj"] .= "<br><strong>Password: </strong>" . $passwd;
						$data["clase"] = "alert-success";
					}else{
						$data["msj"] = "<strong>Error!!!</strong> Ask for help.";
						$data["clase"] = "alert-danger";
					}
			}else{
				//definir mensaje de error
				echo "pailas no son iguales";
			}
						
			$data["view"] = "template/answer";
			$this->load->view("layout", $data);
	}
	
	/**
	 * lista de project
     * @since 4/4/2018
     * @author BMOTTAG
	 */
	public function project()
	{
		$this->load->model("general_model");
		$arrParam = array();
		$data['info'] = $this->general_model->get_project($arrParam);

		$data["view"] = 'projects';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Form project
     * @since 4/4/2018
     * @author BMOTTAG
	 */
	public function update_project($idProject = 'x')
	{			
		$this->load->model("general_model");
		$data['information'] = FALSE;
		
		//consultar lista de roles
		$arrParam = array(
			"table" => "param_rol",
			"order" => "rol_name",
			"id" => "x"
		);
		$data['roles'] = $this->general_model->get_basic_search($arrParam);

		//si envio el id, entonces busco la informacion 
		if ($idProject != 'x') {
			$arrParam = array("idProject" => $idProject);
			$data['information'] = $this->general_model->get_project($arrParam);//info project
		}

		$data["view"] = 'form_project';
		$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar project
     * @since 4/4/2018
	 */
	public function save_project()
	{			
			header('Content-Type: application/json');
			
			$idProject = $this->input->post('hddId');

			$msj = "You have add a new Project!!";
			if ($idProject != '') {
				$msj = "You have update the Project!!";
			}	
						
			if ($this->admin_model->saveProject()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help, contact the Admin.');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Company List
     * @since 8/4/2018
     * @author BMOTTAG
	 */
	public function company()
	{
			$this->load->model("general_model");

			$arrParam = array(
				"table" => "param_company",
				"order" => "id_company",
				"id" => "x"
			);
			$data['info'] = $this->general_model->get_basic_search($arrParam);
			
			$data["view"] = 'company';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario company
     * @since 8/4/2018
     */
    public function cargarModalCompany() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idCompany"] = $this->input->post("idCompany");	
			
			if ($data["idCompany"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "param_company",
					"order" => "id_company",
					"column" => "id_company",
					"id" => $data["idCompany"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("company_modal", $data);
    }
	
	/**
	 * Update company
     * @since 8/4/2018
     * @author BMOTTAG
	 */
	public function save_company()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idCompany = $this->input->post('hddId');
			
			$msj = "You have add a new company!!";
			if ($idCompany != '') {
				$msj = "You have update a company!!";
			}

			if ($idCompany = $this->admin_model->saveCompany()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);	
    }



	
}