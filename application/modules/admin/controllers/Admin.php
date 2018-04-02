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

			$msj = "Se adicionó el Cliente con éxito.";
			if ($idUser != '') {
				$msj = "Se guardó el Cliente con éxito.";
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
					$data["mensaje"] = " Error. El nombre de usuario ya existe.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El nombre de usuario ya existe.');
				}
				if($result_email){
					$data["mensaje"] = " Error. El correo ya existe.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El correo ya existe.');
				}
				if($result_user && $result_email){
					$data["mensaje"] = " Error. El nombre de usuario y correo ya existen.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El nombre de usuario y correo ya existen.');
				}
			} else {
			
				if ($idUser = $this->admin_model->saveUsuario()) {
					$data["result"] = true;
					$data["idRecord"] = $idUser;
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$data["idRecord"] = '';
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
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
			$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>CAMBIO DE CONTRASEÑA";
			
			if($newPassword == $confirm)
			{					
					if ($this->admin_model->updatePassword()) {
						$data["msj"] = "Se actualizó la contraseña.";
						$data["msj"] .= "<br><strong>Usuario: </strong>" . $this->input->post("hddUser");
						$data["msj"] .= "<br><strong>Contraseña: </strong>" . $passwd;
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



	
}