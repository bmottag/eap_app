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
		public function updatePayroll($arrData) 
		{
				$idPayroll =  $this->input->post('hddIdentificador');
				$activities =  $this->security->xss_clean($this->input->post('activities'));
				$activities =  addslashes($activities);

				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				
				$observationStart =  $this->input->post('hddObservationStart');
				
				$observation = $observationStart . "<br><br>" . $observation;
			
				$data = array(
					'finish' => $arrData["finish"],
					'adjusted_finish' => $arrData["ajusteFinish"],
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
				$dteStart = new DateTime($info[0]['adjusted_start']);
				$dteEnd   = new DateTime($info[0]['adjusted_finish']);
				
				$dteDiff  = $dteStart->diff($dteEnd);
				$workingTime = $dteDiff->format("%R%a days %H:%I:%S");//days hours:minutes:seconds
			
				//START hours calculation
				$minutes = (strtotime($info[0]['adjusted_finish'])-strtotime($info[0]['adjusted_start']))/60;
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
				
				$idPayroll =  $info[0]['id_payroll'];

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
		
	/*
	 ************************
	 ************************
	 ** METODOS PARA EL FOREMAN
	 ************************
	 ************************
	 */
	 
		/**
		 * Update payroll hour
		 * @since 2/2/2018
		 */
		public function savePayrollHour() 
		{
				$name = $this->session->userdata['name'];//nombre de usuario conectado
				$idPayroll = $this->input->post('hddIdentificador');
				$inicio = $this->input->post('hddInicio');
				$fin = $this->input->post('hddFin');
				
				$observationNew =  $this->security->xss_clean($this->input->post('observation'));
				$observationAnterior =  $this->input->post('hddObservation');
				
				
				if($observationAnterior){
					$observation =  $observationAnterior . "<br>";
				}else{
					$observation = "";
				}
				
				$observation .= "********************<br>";
				$observation .= "<strong>Changue hour by " . $name . ".</strong>";
				$observation .= "<br>Before -> Start: " . $inicio . " <br>Before -> Finish: " . $fin;
				if($observationNew)
				{
					$observation .=  "<br>" . addslashes($observationNew) . "<br>";
				}
				$observation .= "Date: " . date("Y-m-d G:i:s") . "<br>********************";

				$fechaStart = $this->input->post('start_date');
				$horaStart = $this->input->post('hora_inicio');
				$fechaFinish = $this->input->post('finish_date');
				$horaFinish = $this->input->post('hora_final');

				
				$fechaStart = $fechaStart . " " . $horaStart . ":00";
				$fechaFinish = $fechaFinish . " " . $horaFinish . ":00"; 

				$sql = "UPDATE payroll";
				$sql.= " SET observation='$observation', finish =  '$fechaFinish', start='$fechaStart'";
				$sql.= " WHERE id_payroll=$idPayroll";

				$query = $this->db->query($sql);

				if ($query) {
					return true;
				} else {
					return false;
				}

		}
	
		/**
		 * Add PAYROLL
		 * @since 3/4/2018
		 */
		public function savePayrollAdvanced($arrData)
		{
				$name = $this->session->userdata['name'];//nombre de usuario conectado
				
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				
				if($observation){
					$observation =  addslashes($observation) . "<br>";
				}else{
					$observation = "";
				}
				
				$observation .= "********************<br>";
				$observation .= "<strong>Payrrol inserted by " . $name . ".</strong>";
				$observation .= "<br>Date: " . date("Y-m-d G:i:s") . "<br>********************";
				
				$activities =  $this->security->xss_clean($this->input->post('activities'));
				$activities =  addslashes($activities);
				
				$data = array(
					'fk_id_project' => $this->input->post('project'),
					'fk_id_user' => $this->input->post('user'),
					'start' => $arrData["start"],
					'adjusted_start' => $arrData["ajusteStart"],		
					'finish' => $arrData["finish"],
					'adjusted_finish' => $arrData["ajusteFinish"],
					'activities' => $activities,
					'observation' => $observation
				);	
				
				$query = $this->db->insert('payroll', $data);
				$idPayroll = $this->db->insert_id();

				if ($query) {
					return $idPayroll;
				} else {
					return false;
				}
		}



		
		
		
		
	    
	}