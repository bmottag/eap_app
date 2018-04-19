<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("report_model");
    }
	
	/**
	 * Search by daterange
     * @since 4/4/2018
     * @author BMOTTAG
	 */
    public function search($modulo) 
	{
			if (empty($modulo) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			$this->load->model("general_model");			

			switch ($modulo) {
				case 'payroll':
					$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
					break;
				case 'payrollByAdmin':
					$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
					//workers list
					$arrParam = array('state' => 1);
					$data['userList'] = $this->general_model->get_user_list($arrParam);//users list
					
					//project list
					$arrParam = array('state' => 1);
					$data['projectList'] = $this->general_model->get_project($arrParam);
					break;
			}
			
			$data["view"] = "form_search";
			
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($this->input->post('datetimepicker_from')){
				$data['from'] =  $this->input->post('datetimepicker_from');
				$data['to'] =  $this->input->post('datetimepicker_to');
				$data['user'] =  $this->input->post('user');
				$data['user'] = $data['user']==''?'x':$data['user'];
				
				$data['project'] =  $this->input->post('project');
				$data['project'] = $data['project']==''?'x':$data['project'];
				
				$arrParam = array(
					"from" => $data['from'],
					"to" => $data['to'],
					"idUser" => $data['user'],
					"idProject" => $data['project']
				);

				switch ($modulo) {
					case 'payroll':
						$data['info'] = $this->general_model->get_payroll($arrParam);
						$data["view"] = "list_payroll";
						$data["modulo"] = $modulo;
						break;
					case 'payrollByAdmin':
						$data['info'] = $this->general_model->get_payroll($arrParam);
						$data["view"] = "list_payroll";
						$data["modulo"] = $modulo;
						break;
				}
				
			}

			$this->load->view("layout", $data);
    }
	
    /**
     * Cargo modal- formulario para editar las horas de los empleados
     * @since 5/4/2018
     */
    public function cargarModalHours() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$this->load->model("general_model");

			//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
			//START search info for the task
			$arrParam = array(
				"idPayroll" => $this->input->post('idPayroll')
			);
			$data['information'] = $this->general_model->get_payroll($arrParam);
			//END of search				
						
			$this->load->view("modal_hours_worker", $data);
    }
	
	/**
	 * Save payroll hours
     * @since 5/4/2018
     * @author BMOTTAG
	 */
	public function savePayrollHour()
	{			
			header('Content-Type: application/json');
			$data = array();

			if ($this->report_model->savePayrollHour()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				
				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the task
				$this->load->model("general_model");
				$arrParam = array(
					"idPayroll" => $this->input->post('hddIdentificador')
				);
				$infoPayroll = $this->general_model->get_payroll($arrParam);
				//END of search	

				//update working time and working hours
				if ($this->report_model->updateWorkingTimePayroll($infoPayroll)) {
					$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
				
				
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Add payroll
     * @since 18/4/2018
     * @author BMOTTAG
	 */
	public function payroll_advanced()
	{
			$data['information'] = FALSE;
			
			$this->load->model("general_model");
			$arrParam = array("state" => 1);
			$data['userList'] = $this->general_model->get_user_list($arrParam);//listado de usuarios
			
			//project list - (active's items)
			$arrParam = array(
				"table" => "project",
				"order" => "project_name",
				"column" => "project_state",
				"id" => 1
			);
			$data['project'] = $this->general_model->get_basic_search($arrParam);
		
			$data["view"] = "form_payroll_advanced";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar payroll
     * @since 18/4/2018
	 */
	public function save_payroll_advanced()
	{			
			header('Content-Type: application/json');
			
			$idPayroll = $this->input->post('hddId');

			$msj = "You have add a Payroll!!";
			if ($idPayroll != '') {
				$msj = "You have update the Payroll!!";
			}	
						
			if ($idPayroll = $this->report_model->savePayrollAdvanced()) 
			{				
				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the payroll
				$this->load->model("general_model");
				$arrParam = array("idPayroll" => $idPayroll);			
				$infoPayroll = $this->general_model->get_payroll($arrParam);
				//END of search				

				//update working time and working hours
				$this->report_model->updateWorkingTimePayroll($infoPayroll);
				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help, contact the Admin.');
			}
			
			echo json_encode($data);
    }

	
}