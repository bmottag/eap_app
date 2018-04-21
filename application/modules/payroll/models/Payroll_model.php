<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Payroll_model extends CI_Model {

	    
		/**
		 * Add PAYROLL
		 * @since 3/4/2018
		 * @review 21/4/2018
		 */
		public function savePayroll($arrData) 
		{
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				
				$data = array(
					'fk_id_user' => $this->session->userdata('id'),
					'fk_id_project' => $this->input->post('project'),
					'start' => $arrData["start"],
					'adjusted_start' => $arrData["ajusteStart"],
					'observation' => $observation
				);	

				$query = $this->db->insert('payroll', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Update PAYROLL - finish and observation
		 * @since 4/4/2018
		 */
		public function updatePayroll() 
		{
				$idPayroll =  $this->input->post('hddIdentificador');
				$activities =  $this->security->xss_clean($this->input->post('activities'));
				$activities =  addslashes($activities);

				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				
				$observationStart =  $this->input->post('hddObservationStart');
				
				$observation = $observationStart . "<br><br>" . $observation;
			
				$data = array(
					'finish' => date('Y-m-d G:i:s'),
					'activities' => $activities,
					'observation' => $observation
				);
				
				$this->db->where('id_payroll', $idPayroll);
				$query = $this->db->update('payroll', $data);
				
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Update PAYROLL - workin time and workin hours
		 * @since 17/11/2016
		 */
		public function updateWorkingTimePayroll($info) 
		{
				$dteStart = new DateTime($info[0]['start']);
				$dteEnd   = new DateTime($info[0]['finish']);
				
				$dteDiff  = $dteStart->diff($dteEnd);
				$workingTime = $dteDiff->format("%R%a days %H:%I:%S");//days hours:minutes:seconds
			
				//START hours calculation
				$minutes = (strtotime($info[0]['finish'])-strtotime($info[0]['start']))/60;
				$minutes = abs($minutes);  
				$minutes = round($minutes);
		
				$hours = $minutes/60;
				$hours = round($hours,2);
				
				$justHours = intval($hours);
				$decimals=$hours-$justHours; 

				//Ajuste de los decimales para redondearlos a .25 / .5 / .75
				if($decimals<0.12){
					$transformation = 0;
				}elseif($decimals>=0.12 && $decimals<0.37){
					$transformation = 0.25;
				}elseif($decimals>=0.37 && $decimals<0.62){
					$transformation = 0.5;
				}elseif($decimals>=0.62 && $decimals<0.87){
					$transformation = 0.75;
				}elseif($decimals>=0.87){
					$transformation = 1;
				}
				$workingHours = $justHours + $transformation;
				//FINISH hours calculation
				
				$idPayroll =  $this->input->post('hddIdentificador');

				$sql = "UPDATE payroll";
				$sql.= " SET working_time='$workingTime', working_hours =  $workingHours";
				$sql.= " WHERE id_payroll=$idPayroll";

				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}


		
		
		
		
	    
	}