<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Payroll_model extends CI_Model {

	    
		/**
		 * Add PAYROLL
		 * @since 3/4/2018
		 */
		public function savePayroll() 
		{				
				$data = array(
					'fk_id_user' => $this->session->userdata('id'),
					'fk_id_project_start' => $this->input->post('project'),
					'fk_id_project_finish' => 0,
					'start' => date('Y-m-d G:i:s'),
					'observation' => $this->input->post('observation')
				);	

				$query = $this->db->insert('payroll', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}


		
		
		
		
	    
	}