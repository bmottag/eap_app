<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("payroll_model");
		$this->load->helper('form');
    }
	
	/**
	 * Form add payroll
     * @since 3/4/2018
     * @author BMOTTAG
	 */
	public function index()
	{			
		$this->load->model("general_model");
		//project list - (active's items)
		$arrParam = array(
			"table" => "project",
			"order" => "project_name",
			"column" => "project_state",
			"id" => 1
		);
		$data['project'] = $this->general_model->get_basic_search($arrParam);
		
		//search for the last payroll record
		$arrParam = array(
			"idEmployee" => $this->session->userdata("id"),
			"limit" => 1
		);			
		$data['information'] = $this->general_model->get_payroll($arrParam);

		$view = 'form_add_payroll';
		
		//if the last record doesn't have finish time
		if($data['information'] && $data['information'][0]['finish'] == 0){
			$view = 'form_end_payroll';
		}
		
		$data["view"] = $view;
		$this->load->view("layout", $data);
	}
	
	/**
	 * Save payroll
     * @since 3/4/2018
     * @author BMOTTAG
	 */
	public function savePayroll()
	{			
			$hour = date("G:i");
			
			if ($this->payroll_model->savePayroll()) {
                $this->session->set_flashdata('retornoExito', 'have a nice shift, you started at ' . $hour . '.');
            } else {
                $this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
            }

			redirect("/dashboard",'refresh');
	}
	

	
}