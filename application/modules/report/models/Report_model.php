<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Report_model extends CI_Model {

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
				
				$moreInfo = "<strong>Changue hour by " . $name . ".</strong> <br>Before -> Start: " . $inicio . " <br>Before -> Finish: " . $fin;
				$observation = $this->input->post('hddObservation') . "<br>********************<br>" . $moreInfo . "<br>" . $this->input->post('observation') . "<br>Date: " . date("Y-m-d G:i:s") . "<br>********************";

				$fechaStart = $this->input->post('start_date');
				$horaStart = $this->input->post('start_hour');
				$minStart = $this->input->post('start_min');
				$fechaFinish = $this->input->post('finish_date');
				$horaFinish = $this->input->post('finish_hour');
				$minFinish = $this->input->post('finish_min');
				
				$fechaStart = $fechaStart . " " . $horaStart . ":" . $minStart . ":00";
				$fechaFinish = $fechaFinish . " " . $horaFinish . ":" . $minFinish . ":00"; 

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

		/**
		 * Add PAYROLL
		 * @since 3/4/2018
		 */
		public function savePayrollAdvanced() 
		{
				$observation =  $this->security->xss_clean($this->input->post('observation'));
				$observation =  addslashes($observation);
				
				$activities =  $this->security->xss_clean($this->input->post('activities'));
				$activities =  addslashes($activities);
				
				$fechaStart = $this->input->post('start_date');
				$fechaFinish = $this->input->post('finish_date');
				
				$horaStart = $this->input->post('hora_inicio');
				$horaStart = date("H:i:s", strtotime($horaStart));
				
				$horaFinish = $this->input->post('hora_final');
				$horaFinish = date("H:i:s", strtotime($horaFinish));
				
				$fechaStart = $fechaStart . " " . $horaStart;
				$fechaFinish = $fechaFinish . " " . $horaFinish; 
				
				$data = array(
					'fk_id_project' => $this->input->post('project'),
					'fk_id_user' => $this->input->post('user'),
					'start' => $fechaStart,
					'finish' => $fechaFinish,
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