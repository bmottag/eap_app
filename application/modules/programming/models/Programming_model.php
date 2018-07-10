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
					$data['state'] = 1;
					
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
		 * Add PROGRAMMING WORKER
		 * @since 4/7/2018
		 */
		public function addProgrammingWorker() 
		{
			$idProgramming = $this->input->post('hddId');
			
			//delete workers
			$this->db->delete('programming_worker', array('fk_id_programming' => $idProgramming));
			
			//add the new workers
			$query = 1;
			if ($workers = $this->input->post('workers')) {
				$tot = count($workers);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_programming' => $idProgramming,
						'fk_id_programming_user' => $workers[$i]
					);
					$query = $this->db->insert('programming_worker', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Add PROGRAMMING SKILL
		 * @since 5/7/2018
		 */
		public function addProgrammingSkill() 
		{
			$idWorker = $this->input->post('hddId');
			
			//delete workers
			$this->db->delete('programming_users_skills', array('fk_id_programming_user' => $idWorker));
			
			//add the new workers
			$query = 1;
			if ($skills = $this->input->post('skills')) {
				$tot = count($skills);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_programming_user' => $idWorker,
						'fk_id_programming_skill' => $skills[$i]
					);
					$query = $this->db->insert('programming_users_skills', $data);
				}
			}
			if ($query) {
				return true;
			} else{
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
		
		/**
		 * Cmabia el estado de la programacion
		 * @since 8/7/2018
		 */
		public function deleteProgramming() 
		{
			$idProgramming = $this->input->post('identificador');
		
			$data = array('state' => 3); //estado eliminada
			
			$this->db->where('id_programming', $idProgramming);
			$query = $this->db->update('programming', $data);
						
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Contar trabajadores
		 * @since 10/7/2018
		 */
		public function countWorkers($idProgramming)
		{
				$sql = "SELECT count(id_programming_worker) CONTEO";
				$sql.= " FROM programming_worker";
				$sql.= " WHERE fk_id_programming = $idProgramming";

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
			
		
	    
	}