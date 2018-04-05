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
	

	
}