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
		
		/**
		 * Add/Edit PROGRAMMING
		 * @since 2/7/2018
		 */
		public function saveProgramming() 
		{
				$idUser = $this->session->userdata("id");
				$idProgramming = $this->input->post('hddId');
				
				$data = array(
					'fk_id_project' => $this->input->post('project'),
					'date_programming' => $this->input->post('date_programming'),
					'quantity' => $this->input->post('quantity'),
					'observation' => $this->input->post('observation')
				);
				
				//revisar si es para adicionar o editar
				if ($idProgramming == '') {
					$data['fk_id_user'] = $idUser;
					$data['date_issue'] = date("Y-m-d G:i:s");	
					
					$query = $this->db->insert('programming', $data);				
				} else {
					$this->db->where('id_programming', $idProgramming);
					$query = $this->db->update('programming', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Verify if the project already exist for that date
		 * @author BMOTTAG
		 * @since  1/7/2018
		 */
		public function verifyProject($arrData) 
		{
				$this->db->where('fk_id_project', $arrData["idProject"]);
				$this->db->where('date_programming', $arrData["date"]);
				$query = $this->db->get("programming");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
			
		
	    
	}