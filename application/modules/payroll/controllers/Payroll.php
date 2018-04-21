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
	

	
}