<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin_model extends CI_Model {

	    
		/**
		 * Verify if the user already exist by the social insurance number
		 * @author BMOTTAG
		 * @since  27/3/2018
		 */
		public function verifyUser($arrData) 
		{
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('id_user !=', $arrData["idUser"]);
				}			

				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("user");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
				
		/**
		 * Add/Edit USUARIO
		 * @since 29/3/2018
		 */
		public function saveUsuario() 
		{
				$idUser = $this->input->post('hddId');
				
				$data = array(
					'first_name' => $this->input->post('nombres'),
					'last_name' => $this->input->post('apellidos'),
					'log_user' => $this->input->post('usuario'),
					'email' => $this->input->post('email'),
					'movil' => $this->input->post('celular'),
					'fk_id_rol' => $this->input->post('rol'),
					'state' => $this->input->post('state')
				);	

				//revisar si es para adicionar o editar
				if ($idUser == '') {
					$data['birthdate'] = date("Y-m-d");
					$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';//123456
					$data['address'] = '';
					$query = $this->db->insert('user', $data);
					$idUser = $this->db->insert_id();
				} else {
					$this->db->where('id_user', $idUser);
					$query = $this->db->update('user', $data);
				}
				if ($query) {
					return $idUser;
				} else {
					return false;
				}
		}
		
	    /**
	     * Update user's password
	     * @author BMOTTAG
	     * @since  29/3/2018
	     */
	    public function updatePassword()
		{
				$idUser = $this->input->post("hddId");
				$newPassword = $this->input->post("inputPassword");
				$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('user', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
		/**
		 * Add/Edit PROJECT
		 * @since 29/3/2018
		 */
		public function saveProject() 
		{
				$idProject = $this->input->post('hddId');
				
				$data = array(
					'project_name' => $this->input->post('project'),
					'project_number' => $this->input->post('project_number'),
					'fk_id_company' => $this->input->post('company'),
					'project_state' => $this->input->post('state')
				);	

				//revisar si es para adicionar o editar
				if ($idProject == '') {
					$query = $this->db->insert('project', $data);
				} else {
					$this->db->where('id_project', $idProject);
					$query = $this->db->update('project', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit COMPANY
		 * @since 8/4/2018
		 */
		public function saveCompany() 
		{
				$idCompany = $this->input->post('hddId');
				
				$data = array(
					'company_name' => $this->input->post('company'),
					'contact' => $this->input->post('contact'),
					'movil_number' => $this->input->post('movilNumber'),
					'email' => $this->input->post('email')
				);
				
				//revisar si es para adicionar o editar
				if ($idCompany == '') {
					$query = $this->db->insert('param_company', $data);				
				} else {
					$this->db->where('id_company', $idCompany);
					$query = $this->db->update('param_company', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		
		
		
	    
	}