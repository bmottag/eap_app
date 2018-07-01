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
		
		/**
		 * Add/Edit SKILLS
		 * @since 1/7/2018
		 */
		public function saveSkill() 
		{
				$idSkill = $this->input->post('hddIdSkill');
				
				$data = array(
					'skill' => $this->input->post('skill')
				);
				
				//revisar si es para adicionar o editar
				if ($idSkill == '') {
					$query = $this->db->insert('programming_skills', $data);				
				} else {
					$this->db->where('id_programming_skill', $idSkill);
					$query = $this->db->update('programming_skills', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
			
		
	    
	}