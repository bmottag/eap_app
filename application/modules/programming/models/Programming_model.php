<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Programming_model extends CI_Model {

		
		/**
		 * Add/Edit USER
		 * @since 1/7/2018
		 */
		public function saveUser() 
		{
				$idUser = $this->input->post('hddIdUser');
				
				$data = array(
					'full_name' => $this->input->post('name'),
					'movil_number' => $this->input->post('movilNumber')
				);
				
				//revisar si es para adicionar o editar
				if ($idUser == '') {
					$query = $this->db->insert('programming_users', $data);				
				} else {
					$this->db->where('id_programming_users', $idUser);
					$query = $this->db->update('programming_users', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
			
		
	    
	}