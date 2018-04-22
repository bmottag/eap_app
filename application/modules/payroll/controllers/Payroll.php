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
			"idUser" => $this->session->userdata("id"),
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
		
		$start = date('Y-m-d G:i:s');
		$startXXX = strtotime($start);
						
		$ajusteStart = $this->calcular_hora_inicio_ajustada($startXXX);//calculo la hora ajustada por arriba cada 30 minutos
		
		$arrParam = array(
			"start" => $start,
			"ajusteStart" => $ajusteStart
		);
		
		if ($this->payroll_model->savePayroll($arrParam)) {
			$this->session->set_flashdata('retornoExito', 'have a nice shift, you started at ' . $hour . '.');
		} else {
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}

		redirect("/dashboard",'refresh');
	}
	
	/**
	 * Update finish time payroll
     * @since 4/4/2018
     * @author BMOTTAG
	 */
	public function updatePayroll()
	{	
		$finish = date('Y-m-d G:i:s');
		$finishXXX = strtotime($finish);
						
		$ajusteFinish = $this->calcular_hora_fin_ajustada($finishXXX);//calculo la hora ajustada final por abajo cada 15 minutos
		
		$arrParam = array(
			"finish" => $finish,
			"ajusteFinish" => $ajusteFinish
		);
	
		if ($this->payroll_model->updatePayroll($arrParam)) {

			//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
			//START search info for the payroll
			$this->load->model("general_model");
			$arrParam = array(
				"idPayroll" => $this->input->post('hddIdentificador')
			);			
			$infoPayroll = $this->general_model->get_payroll($arrParam);
			//END of search				

			//update working time and working hours
			$hour = date("G:i");
			if ($this->payroll_model->updateWorkingTimePayroll($infoPayroll)) {
				$this->session->set_flashdata('retornoExito', 'have a good night, you finished at ' . $hour . '.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
			}
			
		} else {
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}

		redirect("/dashboard",'refresh');
	}
	
	/**
	 * calculo la hora ajustada por arriba cada 30 minutos
     * @since 21/4/2018
     * @author BMOTTAG
	 */
	public function calcular_hora_inicio_ajustada($start)
	{					
		$ajusteStart = date("Y-m-j H:i:s", $start);

		$fecha = date( 'Y-m-j' , $start );
		$hora = date( 'H' , $start );
		$minutos = date( 'i' , $start );

		//calcular hora inicial con el ajuste de redondear por arriba a cada 30 min
		if($minutos <= 30)
		{
			$minutos = 30;
			$ajusteStart = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteStart = date("Y-m-j H:i:s", strtotime($ajusteStart));
		}else{
			//si es mas de los 30 minutos enotnces redondeamos a la siguiente hora
			$minutos = 0;
			$ajusteStart = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteStart = date("Y-m-j H:i:s", strtotime($ajusteStart));
			
			$ajusteStart = strtotime ( '+1 hour' , strtotime ( $ajusteStart ) ) ;//le sumo una hora
			$ajusteStart = date ( 'Y-m-j H:i:s' , $ajusteStart );
		}
		
		return $ajusteStart;
	}
	
	/**
	 * calculo la hora final ajustada por abajo cada 15 minutos
     * @since 21/4/2018
     * @author BMOTTAG
	 */
	public function calcular_hora_fin_ajustada($finish)
	{					
		$fecha = date( 'Y-m-j' , $finish );
		$hora = date( 'H' , $finish );
		$minutos = date( 'i' , $finish );

		//calcular hora final con el ajuste de redondear por abajo cada 15 min
		if($minutos < 15)
		{
			$minutos = 0;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteFinish = date("Y-m-j H:i:s", strtotime($ajusteFinish));
		}elseif($minutos >= 15 && $minutos < 30){
			$minutos = 15;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteFinish = date("Y-m-j H:i:s", strtotime($ajusteFinish));
		}elseif($minutos >= 30 && $minutos < 45){
			$minutos = 30;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteFinish = date("Y-m-j H:i:s", strtotime($ajusteFinish));
		}else{
			//si es mas de los 30 minutos enotnces redondeamos a la siguiente hora
			$minutos = 45;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteFinish = date("Y-m-j H:i:s", strtotime($ajusteFinish));
		}
		
		return $ajusteFinish;
	}
	
	/*
	 ************************
	 ************************
	 ** METODOS PARA EL FOREMAN
	 ************************
	 ************************
	 */
	 
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
			
			$fechaStart = $this->input->post('start_date');
			$fechaFinish = $this->input->post('finish_date');
			
			$horaStart = $this->input->post('hora_inicio');
			$horaStart = date("H:i:s", strtotime($horaStart));
			
			$horaFinish = $this->input->post('hora_final');
			$horaFinish = date("H:i:s", strtotime($horaFinish));
			
			$fechaStart = $fechaStart . " " . $horaStart;
			$fechaFinish = $fechaFinish . " " . $horaFinish; 
	
			$startXXX = strtotime($fechaStart);
			$finishXXX = strtotime($fechaFinish);
						
			$ajusteStart = $this->calcular_hora_inicio_ajustada($startXXX);//calculo la hora ajustada por arriba cada 30 minutos
								
			$ajusteFinish = $this->calcular_hora_fin_ajustada($finishXXX);//calculo la hora ajustada final por abajo cada 15 minutos
			
			$arrParam = array(
				"start" => $fechaStart,
				"ajusteStart" => $ajusteStart,
				"finish" => $fechaFinish,
				"ajusteFinish" => $ajusteFinish
			);
			
			if ($this->payroll_model->savePayrollHour($arrParam)) {
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
				if ($this->payroll_model->updateWorkingTimePayroll($infoPayroll)) {
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
			
			$fechaStart = $this->input->post('start_date');
			$fechaFinish = $this->input->post('finish_date');
			
			$horaStart = $this->input->post('hora_inicio');
			$horaStart = date("H:i:s", strtotime($horaStart));
			
			$horaFinish = $this->input->post('hora_final');
			$horaFinish = date("H:i:s", strtotime($horaFinish));
			
			$fechaStart = $fechaStart . " " . $horaStart;
			$fechaFinish = $fechaFinish . " " . $horaFinish; 
			
			$startXXX = strtotime($fechaStart);
			$finishXXX = strtotime($fechaFinish);
						
			$ajusteStart = $this->calcular_hora_inicio_ajustada($startXXX);//calculo la hora ajustada por arriba cada 30 minutos
								
			$ajusteFinish = $this->calcular_hora_fin_ajustada($finishXXX);//calculo la hora ajustada final por abajo cada 15 minutos
			
			$arrParam = array(
				"start" => $fechaStart,
				"ajusteStart" => $ajusteStart,
				"finish" => $fechaFinish,
				"ajusteFinish" => $ajusteFinish
			);

			if ($idPayroll = $this->payroll_model->savePayrollAdvanced($arrParam)) 
			{				
				//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
				//START search info for the payroll
				$this->load->model("general_model");
				$arrParam = array("idPayroll" => $idPayroll);			
				$infoPayroll = $this->general_model->get_payroll($arrParam);
				//END of search				

				//update working time and working hours
				$this->payroll_model->updateWorkingTimePayroll($infoPayroll);
				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help, contact the Admin.');
			}
			
			echo json_encode($data);
    }
	 

	 
	 
	
}