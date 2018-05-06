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

				$observationNew =  $this->security->xss_clean($this->input->post('observation'));
				$observationNew =  addslashes($observationNew);
				
				$observationStart =  $this->input->post('hddObservationStart');
				
				if($observationStart){
					$observation =  $observationStart . "<br><br>";
				}else{
					$observation = "";
				}
				
				$observation .= $observationNew;
				
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
		public function updateWorkingTimePayroll($arrData) 
		{
				$data = array(
					'working_time' => $arrData["workingTime"],
					'working_hours' => $arrData["workingHours"]
				);
				
				$this->db->where('id_payroll', $arrData["idPayroll"]);
				$query = $this->db->update('payroll', $data);
				
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
		public function savePayrollHour($arrData) 
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
					
				$data = array(
					'start' => $arrData["start"],
					'adjusted_start' => $arrData["ajusteStart"],		
					'finish' => $arrData["finish"],
					'adjusted_finish' => $arrData["ajusteFinish"],
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
		
		/**
		 * Add PERIOD
		 * @since 26/4/2018
		 */
		public function savePeriod($arrData)
		{				
				$period = $arrData["periodoIniNew"] . " --> " . $arrData["periodoFinNew"];
				
				$data = array(
					'date_start' => $arrData["periodoIniNew"],
					'date_finish' => $arrData["periodoFinNew"],
					'period' => $period
				);	
				
				$query = $this->db->insert('payroll_period', $data);
				$idPeriod = $this->db->insert_id();

				if ($query) {
					return $idPeriod;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit PAYROLL PROJECT PERIOD
		 * @since 26/4/2018
		 */
		public function updatePayrollProjectPeriod($arrData) 
		{				
				$idProjectPeriod = $arrData["idProjectPeriod"];
				
				$data = array(
					'total_hours' => $arrData["hotalHoras"],
				);	

				//revisar si es para adicionar o editar
				if ($idProjectPeriod == '') {
					$data['fk_id_user'] = $arrData["idUser"];
					$data['fk_id_project'] = $arrData["idProject"];
					$data['fk_id_period'] = $arrData["idPeriod"];
					$query = $this->db->insert('payroll_project_period', $data);
				} else {
					$this->db->where('id_project_period', $idProjectPeriod);
					$query = $this->db->update('payroll_project_period', $data);
				}
				if ($query) {
					return TRUE;
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit PAYROLL TOTAL PERIOD
		 * @since 2/5/2018
		 */
		public function updatePayrollTotalPeriod($arrData) 
		{				
				$idTotalPeriod = $arrData["idTotalPeriod"];
				
				$data = array(
					'total_hours_user' => $arrData["hotalHoras"],
					'hour_price' => $arrData["valorHora"],
					'hour_price_lmia' => $arrData["valorHoraLMIA"],
					'max_hours' => $arrData["noHorasMaximo"],
					'less_max_hours' => $arrData["lessMaxHours"],
					'over_max_hours' => $arrData["overMaxHours"],
					'gross_amount' => $arrData["grossAmount"],
					'casual_amount' => $arrData["casualAmount"],
					'gst_amount' => $arrData["GST"],
					'total_user' => $arrData["valorTotal"]
				);	

				//revisar si es para adicionar o editar
				if ($idTotalPeriod == '') {
					$data['fk_id_user'] = $arrData["idUser"];
					$data['fk_id_period'] = $arrData["idPeriod"];
					$query = $this->db->insert('payroll_total_period', $data);
				} else {
					$this->db->where('id_total_period', $idTotalPeriod);
					$query = $this->db->update('payroll_total_period', $data);
				}
				if ($query) {
					return TRUE;
				} else {
					return false;
				}
		}


		
		
		
		
	    
	}