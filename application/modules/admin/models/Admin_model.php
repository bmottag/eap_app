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
					'fk_id_type' => $this->input->post('type'),
					'hora_real' => $this->input->post('hora_real'),
					'hora_contrato' => $this->input->post('hora_contrato'),
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
				$idUserForeman = $this->input->post('foreman');
				$hddIdUserForemanAnterior = $this->input->post('hddIdUserForemanAnterior');
				
				$data = array(
					'project_name' => $this->input->post('project'),
					'project_number' => $this->input->post('project_number'),
					'address' => $this->input->post('address'),
					'fk_id_company' => $this->input->post('company'),
					'fk_id_user_foreman' => $idUserForeman,
					'project_state' => $this->input->post('state'),
					'purchase_order_general' => $this->input->post('purchase_order')
				);

				//revisar si es para adicionar o editar
				if ($idProject == '') {
					$query = $this->db->insert('project', $data);
					$idProject = $this->db->insert_id();
					
				} else {
					$this->db->where('id_project', $idProject);
					$query = $this->db->update('project', $data);
				}
				
				//si el  nuevo foreman es diferente al anterior entonces guardo LOG del nuevo foreman
				if($idUserForeman != $hddIdUserForemanAnterior){
					//se ingresa el log del foreman
					$data = array(
						'fk_id_project' => $idProject,
						'fk_id_user_foreman' => $idUserForeman,
						'date_issue' => date("Y-m-d G:i:s"),
						'fk_id_user' => $this->session->userdata("id")
					);
					$query = $this->db->insert('log_foreman_project', $data);
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
					'fax' => $this->input->post('fax'),
					'address' => $this->input->post('address'),
					'website' => $this->input->post('website'),
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
		
		/**
		 * Add/Edit COMPANY CONTACTS
		 * @since 12/4/2018
		 */
		public function saveContact() 
		{
				$idContact = $this->input->post('hddIdContact');
				
				$data = array(
					'fk_id_company' => $this->input->post('hddIdCompany'),
					'contact_name' => $this->input->post('contact'),
					'contact_position' => $this->input->post('position'),
					'contact_movil' => $this->input->post('movilNumber'),
					'contact_email' => $this->input->post('email')
				);
				
				//revisar si es para adicionar o editar
				if ($idContact == '') {
					$query = $this->db->insert('param_company_contacts', $data);				
					$idContact = $this->db->insert_id();
				} else {
					$this->db->where('id_contact', $idContact);
					$query = $this->db->update('param_company_contacts', $data);
				}
				if ($query) {
					return $idContact;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit PRUCHASE ORDER
		 * @since 24/4/2018
		 */
		public function savePurchaseOrder() 
		{
				$idPurchaseOrder = $this->input->post('hddIdProjectPO');
				
				$data = array(
					'fk_id_project' => $this->input->post('hddIdProject'),
					'purchase_order' => $this->input->post('purchase_order'),
					'description' => $this->input->post('description')
				);
				
				//revisar si es para adicionar o editar
				if ($idPurchaseOrder == '') {
					$query = $this->db->insert('project_purchase_order', $data);				
				} else {
					$this->db->where('id_purchase_order', $idPurchaseOrder);
					$query = $this->db->update('project_purchase_order', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		
		
	    
	}